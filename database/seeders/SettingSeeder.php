<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // ── Business Info ────────────────────────────────────
            ['key' => 'business_name',        'value' => 'RK Shah Car Rental',           'type' => 'string',  'is_public' => true,  'description' => 'Business display name'],
            ['key' => 'business_phone',       'value' => '+91 93245 55165',              'type' => 'string',  'is_public' => true,  'description' => 'Primary phone number'],
            ['key' => 'business_email',       'value' => 'rkshahcarrental@gmail.com',    'type' => 'string',  'is_public' => true,  'description' => 'Primary email address'],
            ['key' => 'business_address',     'value' => 'Soniya Vihar, Delhi – 110094', 'type' => 'string',  'is_public' => true,  'description' => 'Business address'],
            ['key' => 'whatsapp_number',      'value' => '919324555165',                 'type' => 'string',  'is_public' => true,  'description' => 'WhatsApp number (digits only, no +)'],
            ['key' => 'business_tagline',     'value' => 'Your Travel Partner',          'type' => 'string',  'is_public' => true,  'description' => 'Tagline shown on website'],
            ['key' => 'business_hours',       'value' => '6 AM – 11 PM · All Days',     'type' => 'string',  'is_public' => true,  'description' => 'Operating hours'],
            ['key' => 'google_rating',        'value' => '4.9',                          'type' => 'number',  'is_public' => true,  'description' => 'Google rating to display'],
            ['key' => 'google_review_count',  'value' => '180',                          'type' => 'number',  'is_public' => true,  'description' => 'Number of Google reviews'],
            ['key' => 'years_in_business',    'value' => '8',                            'type' => 'number',  'is_public' => true,  'description' => 'Years in business'],

            // ── Per-KM Rates ─────────────────────────────────────
            ['key' => 'rate_dzire',   'value' => '9',  'type' => 'number', 'is_public' => true, 'description' => 'Swift Dzire rate per km (₹)'],
            ['key' => 'rate_ertiga',  'value' => '11', 'type' => 'number', 'is_public' => true, 'description' => 'Ertiga rate per km (₹)'],
            ['key' => 'rate_creta',   'value' => '12', 'type' => 'number', 'is_public' => true, 'description' => 'Kia Creta rate per km (₹)'],
            ['key' => 'rate_innova',  'value' => '14', 'type' => 'number', 'is_public' => true, 'description' => 'Innova Crysta rate per km (₹)'],

            // ── Driver Allowance (per day ₹) ─────────────────────
            ['key' => 'da_dzire',   'value' => '1500', 'type' => 'number', 'is_public' => true, 'description' => 'Swift Dzire driver allowance per day'],
            ['key' => 'da_ertiga',  'value' => '1800', 'type' => 'number', 'is_public' => true, 'description' => 'Ertiga driver allowance per day'],
            ['key' => 'da_creta',   'value' => '2000', 'type' => 'number', 'is_public' => true, 'description' => 'Kia Creta driver allowance per day'],
            ['key' => 'da_innova',  'value' => '2200', 'type' => 'number', 'is_public' => true, 'description' => 'Innova Crysta driver allowance per day'],

            // ── Booking Rules ─────────────────────────────────────
            ['key' => 'min_booking_km',    'value' => '250', 'type' => 'number', 'is_public' => true,  'description' => 'Minimum outstation distance (km)'],
            ['key' => 'booking_advance',   'value' => '500', 'type' => 'number', 'is_public' => true,  'description' => 'Minimum advance amount (₹)'],
            ['key' => 'fare_range_percent', 'value' => '10', 'type' => 'number', 'is_public' => false, 'description' => 'Fare range ±% shown to customers (middle path)'],

            // ── Notifications (private) ───────────────────────────
            ['key' => 'admin_email_notify', 'value' => 'rkshahcarrental@gmail.com', 'type' => 'string', 'is_public' => false, 'description' => 'Email to receive new lead alerts'],
            ['key' => 'wa_notify_enabled',  'value' => '0',                         'type' => 'boolean','is_public' => false, 'description' => 'Send WhatsApp alert for new leads'],

            // ── Social Media ──────────────────────────────────────
            ['key' => 'social_facebook',   'value' => '', 'type' => 'string', 'is_public' => true, 'description' => 'Facebook page URL'],
            ['key' => 'social_instagram',  'value' => '', 'type' => 'string', 'is_public' => true, 'description' => 'Instagram page URL'],
            ['key' => 'social_youtube',    'value' => '', 'type' => 'string', 'is_public' => true, 'description' => 'YouTube channel URL'],

            // ── WhatsApp Notification ────────────────────────────
            ['key' => 'wa_callmebot_key', 'value' => '', 'type' => 'string',  'is_public' => false, 'description' => 'CallMeBot API key for WhatsApp notifications'],
            ['key' => 'wa_phone_id',      'value' => '', 'type' => 'string',  'is_public' => false, 'description' => 'Meta WhatsApp Business Phone Number ID'],
            ['key' => 'wa_api_token',     'value' => '', 'type' => 'string',  'is_public' => false, 'description' => 'Meta WhatsApp Business API token'],

            ['key' => 'google_place_id',  'value' => '', 'type' => 'string', 'is_public' => false, 'description' => 'Google Place ID for rating fetch'],
            ['key' => 'google_api_key',   'value' => '', 'type' => 'string', 'is_public' => false, 'description' => 'Google Places API key'],
            ['key' => 'google_review_count', 'value' => '0', 'type' => 'string', 'is_public' => true, 'description' => 'Google review count (auto updated)'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                array_merge($setting, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        $this->command->info('  ✅ Settings seeded (' . count($settings) . ' records)');
    }
}
