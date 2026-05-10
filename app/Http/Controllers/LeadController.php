<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        // Clean phone
        $phone = preg_replace('/\D/', '', $request->input('phone', ''));
        if (strlen($phone) === 12 && str_starts_with($phone, '91')) {
            $phone = substr($phone, 2);
        }
        $request->merge(['phone' => $phone]);

        // Normalise car_type
        $carMap = [
            'innova' => 'innova_crysta',
            'creta'  => 'kia_creta',
            'ertiga' => 'ertiga',
            'dzire'  => 'swift_dzire',
            'any'    => 'any',
        ];
        $carRaw = $request->input('car_type', 'any');
        $request->merge(['car_type' => $carMap[$carRaw] ?? $carRaw]);

        // Normalise passengers
        $passengerMap = ['1–4' => 4, '5–7' => 7, '1-4' => 4, '5-7' => 7];
        $pasRaw = $request->input('passengers', null);
        if ($pasRaw && isset($passengerMap[$pasRaw])) {
            $request->merge(['passengers' => $passengerMap[$pasRaw]]);
        } elseif ($pasRaw && !is_numeric($pasRaw)) {
            $request->merge(['passengers' => null]);
        }

        $validated = $request->validate([
            'name'        => 'required|string|min:2|max:100',
            'phone'       => ['required', 'string', 'regex:/^[6-9]\d{9}$/'],
            'from_city'   => 'required|string|max:80',
            'to_city'     => 'required|string|max:80',
            'travel_date' => 'nullable|date|after_or_equal:today',
            'car_type'    => 'nullable|string|in:innova_crysta,kia_creta,ertiga,swift_dzire,any',
            'trip_type'   => 'nullable|string|in:one_way,round_trip,airport,hourly',
            'passengers'  => 'nullable|integer|min:1|max:20',
            'message'     => 'nullable|string|max:500',
        ]);

        // Duplicate check
        $duplicate = Lead::where('phone', $validated['phone'])
            ->where('from_city', $validated['from_city'])
            ->where('to_city',   $validated['to_city'])
            ->where('created_at', '>=', now()->subHours(24))
            ->exists();

        if ($duplicate) {
            return redirect()->back()
                ->with('booking_info', 'We already have your enquiry! RK Shah will call you shortly on ' . $validated['phone'] . '.')
                ->withInput();
        }

        // Save lead
        $lead = Lead::create(array_merge($validated, [
            'source'       => 'website',
            'status'       => 'new',
            'ip_address'   => $request->ip(),
            'utm_source'   => $request->query('utm_source'),
            'utm_medium'   => $request->query('utm_medium'),
            'utm_campaign' => $request->query('utm_campaign'),
        ]));

        Log::info('New lead saved', [
            'id'    => $lead->id,
            'name'  => $lead->name,
            'route' => $lead->from_city . ' → ' . $lead->to_city,
            'phone' => $lead->phone,
        ]);

        // Always try WhatsApp notification (works on local and production)
        $this->sendWhatsApp($lead);

        // Email notification only in production
        if (app()->isProduction()) {
            $this->sendEmail($lead);
        }

        return redirect()->route('thank-you')
            ->with('lead_name',  $lead->name)
            ->with('lead_phone', $lead->phone)
            ->with('lead_route', $lead->from_city . ' → ' . $lead->to_city);
    }

    /**
     * Send WhatsApp notification via Meta Cloud API
     * Configure in CMS → Settings → Notifications
     */
    private function sendWhatsApp(Lead $lead): void
    {
        // Check if enabled in settings
        $enabled = Setting::get('wa_notify_enabled', '0');
        if ($enabled !== '1' && $enabled !== true) {
            return;
        }

        $token      = Setting::get('wa_api_token', '');
        $phoneId    = Setting::get('wa_phone_id', '');
        $toNumber   = Setting::get('whatsapp_number', '919324555165');

        // If Meta API not configured, fallback to simple HTTP notification
        if (empty($token) || empty($phoneId)) {
            $this->sendWhatsAppFallback($lead, $toNumber);
            return;
        }

        $message = "🚗 *New Lead #{$lead->id} — RK Shah CMS*\n\n"
                 . "👤 *Name:* {$lead->name}\n"
                 . "📞 *Phone:* {$lead->phone}\n"
                 . "📍 *Route:* {$lead->from_city} → {$lead->to_city}\n"
                 . "🚙 *Car:* {$lead->car_label}\n"
                 . "📅 *Date:* " . ($lead->travel_date?->format('d M Y') ?? 'Not specified') . "\n"
                 . "⏰ *Received:* " . now()->format('d M Y, h:i A') . "\n\n"
                 . "👉 Call customer: +91{$lead->phone}";

        try {
            $response = Http::withToken($token)
                ->timeout(8)
                ->post("https://graph.facebook.com/v18.0/{$phoneId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'to'                => $toNumber,
                    'type'              => 'text',
                    'text'              => ['body' => $message],
                ]);

            if ($response->successful()) {
                Log::info("WhatsApp notification sent for Lead #{$lead->id}");
            } else {
                Log::warning("WhatsApp API error for Lead #{$lead->id}: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::warning("WhatsApp notification failed: " . $e->getMessage());
        }
    }

    /**
     * Fallback: CallMeBot API (free, no setup needed)
     * User needs to add +34 644 44 21 49 to contacts & send "I allow callmebot to send me messages"
     * Then get their apikey from the reply
     */
    private function sendWhatsAppFallback(Lead $lead, string $toNumber): void
    {
        $apiKey = Setting::get('wa_callmebot_key', '');
        if (empty($apiKey)) {
            Log::info("WhatsApp fallback skipped — no callmebot key configured");
            return;
        }

        $message = "New Lead #{$lead->id}: {$lead->name} | {$lead->phone} | {$lead->from_city} to {$lead->to_city} | " . ($lead->travel_date?->format('d M Y') ?? 'Date TBD');

        try {
            // Format number for callmebot (remove leading country code issues)
            $phone = ltrim($toNumber, '91');
            $phone = '91' . ltrim($phone, '0');

            Http::timeout(8)->get('https://api.callmebot.com/whatsapp.php', [
                'phone'  => '+' . $phone,
                'text'   => $message,
                'apikey' => $apiKey,
            ]);

            Log::info("CallMeBot WhatsApp sent for Lead #{$lead->id}");
        } catch (\Exception $e) {
            Log::warning("CallMeBot failed: " . $e->getMessage());
        }
    }

    /**
     * Email notification
     */
    private function sendEmail(Lead $lead): void
    {
        try {
            \Mail::send([], [], function ($msg) use ($lead) {
                $msg->to(Setting::get('admin_email_notify', 'rkshahcarrental@gmail.com'))
                    ->subject("New Lead #{$lead->id} — {$lead->from_city} → {$lead->to_city}")
                    ->html("
                        <h2>New Enquiry — RK Shah CMS</h2>
                        <p><b>Name:</b> {$lead->name}</p>
                        <p><b>Phone:</b> {$lead->phone}</p>
                        <p><b>Route:</b> {$lead->from_city} → {$lead->to_city}</p>
                        <p><b>Car:</b> {$lead->car_label}</p>
                        <p><b>Date:</b> " . ($lead->travel_date?->format('d M Y') ?? '—') . "</p>
                        <a href='" . route('cms.leads.show', $lead->id) . "'>View in CMS →</a>
                    ");
            });
        } catch (\Exception $e) {
            Log::warning('Lead email failed: ' . $e->getMessage());
        }
    }
}
