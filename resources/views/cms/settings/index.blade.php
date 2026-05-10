@extends('cms.layouts.app')
@section('title','Settings')
@section('page-title','Settings')
@section('page-subtitle','Business info, pricing rates, contact details — all changes go live on the website instantly')

@push('header-actions')
<a href="{{ route('home') }}" target="_blank" class="header-btn header-btn--outline">🔗 Preview Website</a>
@endpush

@push('styles')
<style>
.current-val{font-size:11px;color:var(--t4);margin-top:4px;font-style:italic}
.changed{border-color:#10B981 !important;background:#f0fdf4 !important}
.settings-tabs{display:flex;gap:4px;background:var(--bg);border-radius:var(--r);padding:4px;margin-bottom:20px}
.settings-tab{flex:1;padding:8px 12px;text-align:center;border-radius:6px;font-size:12px;font-weight:600;font-family:var(--ff-h);cursor:pointer;transition:all .2s;border:none;background:none;color:var(--t3)}
.settings-tab.active{background:var(--navy);color:white}
.tab-content{display:none}
.tab-content.active{display:block}
</style>
@endpush

@section('content')

<div style="background:#FEF3C7;border:1px solid #FDE68A;border-radius:var(--r2);padding:12px 18px;margin-bottom:20px;display:flex;gap:10px;align-items:center">
    <span style="font-size:18px">💡</span>
    <div style="font-size:12px;color:#92400E">
        <strong>Every field shows the current live value from the database.</strong>
        All changes go live on your website immediately after saving — no deployment needed.
    </div>
</div>

{{-- Tab buttons --}}
<div class="settings-tabs">
    <button class="settings-tab active" onclick="switchTab('business',this)">⚙️ Business Info</button>
    <button class="settings-tab" onclick="switchTab('pricing',this)">💰 Pricing & Rates</button>
    <button class="settings-tab" onclick="switchTab('contact',this)">📞 Contact & Social</button>
    <button class="settings-tab" onclick="switchTab('display',this)">🌐 Display</button>
    <button class="settings-tab" onclick="switchTab('notifications',this)" style="{{ ($settings['wa_notify_enabled'] ?? '0') === '1' ? 'color:#065F46' : '' }}">
        🔔 Notifications{{ ($settings['wa_notify_enabled'] ?? '0') === '1' ? ' ✅' : '' }}
    </button>
</div>

{{-- BUSINESS INFO --}}
<div id="tab-business" class="tab-content active">
    <form action="{{ route('cms.settings.update') }}" method="POST">
        @csrf @method('PUT')
        <input type="hidden" name="tab" value="business">
        <div class="card">
            <div class="card__header"><div class="card__title">⚙️ Business Information</div></div>
            <div class="card__body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Business Name</label>
                        <input class="form-input js-track" type="text" name="business_name"
                               value="{{ $settings['business_name'] ?? '' }}" placeholder="RK Shah Car Rental">
                        <div class="current-val">📍 Currently: "{{ $settings['business_name'] ?? 'Not set' }}"</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Business Tagline</label>
                        <input class="form-input js-track" type="text" name="business_tagline"
                               value="{{ $settings['business_tagline'] ?? '' }}" placeholder="Your Travel Partner">
                        <div class="current-val">📍 Currently: "{{ $settings['business_tagline'] ?? 'Not set' }}"</div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Phone / WhatsApp Number</label>
                        <input class="form-input js-track" type="text" name="business_phone"
                               value="{{ $settings['business_phone'] ?? '' }}" placeholder="+91 93245 55165">
                        <div class="current-val">📍 Currently: "{{ $settings['business_phone'] ?? 'Not set' }}"</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">WhatsApp Number (digits only, no +)</label>
                        <input class="form-input js-track" type="text" name="whatsapp_number"
                               value="{{ $settings['whatsapp_number'] ?? '' }}" placeholder="919324555165">
                        <div class="current-val">📍 Currently: "{{ $settings['whatsapp_number'] ?? 'Not set' }}"</div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input class="form-input js-track" type="email" name="business_email"
                               value="{{ $settings['business_email'] ?? '' }}" placeholder="rkshahcarrental@gmail.com">
                        <div class="current-val">📍 Currently: "{{ $settings['business_email'] ?? 'Not set' }}"</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Business Address</label>
                        <input class="form-input js-track" type="text" name="business_address"
                               value="{{ $settings['business_address'] ?? '' }}" placeholder="Soniya Vihar, Delhi">
                        <div class="current-val">📍 Currently: "{{ $settings['business_address'] ?? 'Not set' }}"</div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Business Hours</label>
                        <input class="form-input js-track" type="text" name="business_hours"
                               value="{{ $settings['business_hours'] ?? '' }}" placeholder="6 AM – 11 PM · All Days">
                        <div class="current-val">📍 Currently: "{{ $settings['business_hours'] ?? 'Not set' }}"</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Years in Business</label>
                        <input class="form-input js-track" type="number" name="years_in_business"
                               value="{{ $settings['years_in_business'] ?? '' }}" min="1" max="99">
                        <div class="current-val">📍 Currently: {{ $settings['years_in_business'] ?? 'Not set' }} years</div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Google Rating (e.g. 4.9)</label>
                        <input class="form-input js-track" type="number" name="google_rating"
                               value="{{ $settings['google_rating'] ?? '' }}" min="1" max="5" step="0.1">
                        <div class="current-val">📍 Currently: {{ $settings['google_rating'] ?? 'Not set' }}★</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Google Review Count</label>
                        <input class="form-input js-track" type="number" name="google_review_count"
                               value="{{ $settings['google_review_count'] ?? '' }}" min="0">
                        <div class="current-val">📍 Currently: {{ $settings['google_review_count'] ?? 'Not set' }} reviews</div>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-top:14px;text-align:right"><button type="submit" class="btn btn--gold btn--lg">💾 Save Business Info</button></div>
    </form>
</div>

{{-- PRICING --}}
<div id="tab-pricing" class="tab-content">
    <form action="{{ route('cms.settings.update') }}" method="POST">
        @csrf @method('PUT')
        <input type="hidden" name="tab" value="pricing">
        <div class="card">
            <div class="card__header"><div class="card__title">💰 Per-KM Rates</div><span style="font-size:12px;color:var(--t4)">Used in fare calculator · changes apply instantly</span></div>
            <div class="card__body">
                <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px">
                    @foreach([['🚕','Swift Dzire','rate_dzire'],['🚐','Ertiga','rate_ertiga'],['🚗','Kia Creta','rate_creta'],['🚙','Innova Crysta','rate_innova']] as [$emoji,$name,$key])
                    <div style="background:var(--bg);border-radius:var(--r2);padding:18px;text-align:center;border:1.5px solid var(--border)">
                        <div style="font-size:32px;margin-bottom:8px">{{ $emoji }}</div>
                        <div style="font-family:var(--ff-h);font-size:12px;font-weight:700;color:var(--t1);margin-bottom:10px">{{ $name }}</div>
                        <div class="form-group" style="margin:0">
                            <label class="form-label">₹ per km</label>
                            <input class="form-input js-track" type="number" name="{{ $key }}"
                                   value="{{ $settings[$key] ?? '' }}" min="1" max="999"
                                   style="text-align:center;font-size:1.3rem;font-family:var(--ff-h);font-weight:700">
                            <div class="current-val">📍 Current: ₹{{ $settings[$key] ?? '—' }}/km</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card" style="margin-top:16px">
            <div class="card__header"><div class="card__title">Driver Allowance (₹ per day)</div><span style="font-size:12px;color:var(--t4)">Added on top of km fare</span></div>
            <div class="card__body">
                <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px">
                    @foreach([['🚕','Swift Dzire','da_dzire'],['🚐','Ertiga','da_ertiga'],['🚗','Kia Creta','da_creta'],['🚙','Innova Crysta','da_innova']] as [$emoji,$name,$key])
                    <div class="form-group">
                        <label class="form-label">{{ $emoji }} {{ $name }}</label>
                        <input class="form-input js-track" type="number" name="{{ $key }}"
                               value="{{ $settings[$key] ?? '' }}" min="0" max="9999">
                        <div class="current-val">📍 Current: ₹{{ number_format($settings[$key] ?? 0) }}/day</div>
                    </div>
                    @endforeach
                </div>
                <div style="border-top:1px solid var(--border);margin-top:16px;padding-top:16px">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Minimum Booking Distance (km)</label>
                            <input class="form-input js-track" type="number" name="min_booking_km"
                                   value="{{ $settings['min_booking_km'] ?? '' }}" min="0">
                            <div class="current-val">📍 Current: {{ $settings['min_booking_km'] ?? '—' }} km</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Fare Range ± % (shown to customers)</label>
                            <input class="form-input js-track" type="number" name="fare_range_percent"
                                   value="{{ $settings['fare_range_percent'] ?? '' }}" min="0" max="30">
                            <div class="current-val">📍 Current: ±{{ $settings['fare_range_percent'] ?? '10' }}% range shown</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-top:14px;text-align:right"><button type="submit" class="btn btn--gold btn--lg">💾 Save Pricing</button></div>
    </form>
</div>

{{-- CONTACT & SOCIAL --}}
<div id="tab-contact" class="tab-content">
    <form action="{{ route('cms.settings.update') }}" method="POST">
        @csrf @method('PUT')
        <input type="hidden" name="tab" value="contact">
        <div class="card">
            <div class="card__header"><div class="card__title">📱 Social Media Links</div></div>
            <div class="card__body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Facebook Page URL</label>
                        <input class="form-input js-track" type="url" name="social_facebook"
                               value="{{ $settings['social_facebook'] ?? '' }}" placeholder="https://facebook.com/...">
                        <div class="current-val">📍 Current: "{{ $settings['social_facebook'] ?? 'Not set' }}"</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Instagram Page URL</label>
                        <input class="form-input js-track" type="url" name="social_instagram"
                               value="{{ $settings['social_instagram'] ?? '' }}" placeholder="https://instagram.com/...">
                        <div class="current-val">📍 Current: "{{ $settings['social_instagram'] ?? 'Not set' }}"</div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">YouTube Channel URL</label>
                        <input class="form-input js-track" type="url" name="social_youtube"
                               value="{{ $settings['social_youtube'] ?? '' }}" placeholder="https://youtube.com/...">
                        <div class="current-val">📍 Current: "{{ $settings['social_youtube'] ?? 'Not set' }}"</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Admin Email for Lead Alerts</label>
                        <input class="form-input js-track" type="email" name="admin_email_notify"
                               value="{{ $settings['admin_email_notify'] ?? '' }}" placeholder="rkshahcarrental@gmail.com">
                        <div class="current-val">📍 Current: "{{ $settings['admin_email_notify'] ?? 'Not set' }}"</div>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-top:14px;text-align:right"><button type="submit" class="btn btn--gold btn--lg">💾 Save Contact & Social</button></div>
    </form>
</div>

{{-- DISPLAY --}}
<div id="tab-display" class="tab-content">
    <form action="{{ route('cms.settings.update') }}" method="POST">
        @csrf @method('PUT')
        <input type="hidden" name="tab" value="display">
        <div class="card">
            <div class="card__header"><div class="card__title">🌐 Display Settings</div></div>
            <div class="card__body">
                <div class="form-group">
                    <label class="form-label">Booking Advance Amount (₹)</label>
                    <input class="form-input js-track" type="number" name="booking_advance"
                           value="{{ $settings['booking_advance'] ?? '' }}" min="0">
                    <div class="current-val">📍 Current: ₹{{ $settings['booking_advance'] ?? '500' }} advance required</div>
                </div>
            </div>
        </div>
        <div style="margin-top:14px;text-align:right"><button type="submit" class="btn btn--gold btn--lg">💾 Save Display Settings</button></div>
    </form>
</div>

{{-- NOTIFICATIONS --}}
<div id="tab-notifications" class="tab-content">
    <form action="{{ route('cms.settings.update') }}" method="POST">
        @csrf @method('PUT')
        <input type="hidden" name="tab" value="notifications">

        {{-- Status overview --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px">
            <div style="background:{{ ($settings['wa_notify_enabled'] ?? '0') === '1' ? '#D1FAE5' : 'var(--bg)' }};border:1.5px solid {{ ($settings['wa_notify_enabled'] ?? '0') === '1' ? '#6EE7B7' : 'var(--border)' }};border-radius:var(--r2);padding:16px;text-align:center">
                <div style="font-size:28px;margin-bottom:6px">{{ ($settings['wa_notify_enabled'] ?? '0') === '1' ? '✅' : '⚪' }}</div>
                <div style="font-family:var(--ff-h);font-size:13px;font-weight:700;color:var(--t1)">WhatsApp Alerts</div>
                <div style="font-size:12px;color:var(--t4)">{{ ($settings['wa_notify_enabled'] ?? '0') === '1' ? 'Active — you will be notified' : 'Disabled' }}</div>
            </div>
            <div style="background:{{ !empty($settings['admin_email_notify'] ?? '') ? '#D1FAE5' : 'var(--bg)' }};border:1.5px solid {{ !empty($settings['admin_email_notify'] ?? '') ? '#6EE7B7' : 'var(--border)' }};border-radius:var(--r2);padding:16px;text-align:center">
                <div style="font-size:28px;margin-bottom:6px">{{ !empty($settings['admin_email_notify'] ?? '') ? '✅' : '⚪' }}</div>
                <div style="font-family:var(--ff-h);font-size:13px;font-weight:700;color:var(--t1)">Email Alerts</div>
                <div style="font-size:12px;color:var(--t4)">{{ !empty($settings['admin_email_notify'] ?? '') ? ($settings['admin_email_notify'] ?? '') : 'Not configured' }}</div>
            </div>
        </div>

        {{-- WhatsApp Config --}}
        <div class="card" style="margin-bottom:16px">
            <div class="card__header">
                <div class="card__title">💬 WhatsApp Notifications</div>
                <span style="font-size:11px;color:var(--t4);background:var(--bg);padding:4px 10px;border-radius:20px">Notifies you on WhatsApp when a new lead submits the booking form</span>
            </div>
            <div class="card__body">

                <div class="form-row" style="margin-bottom:16px">
                    <div class="form-group">
                        <label class="form-label">WhatsApp Notifications</label>
                        <select class="form-select js-track" name="wa_notify_enabled">
                            <option value="0" {{ ($settings['wa_notify_enabled'] ?? '0') === '0' ? 'selected' : '' }}>❌ Disabled</option>
                            <option value="1" {{ ($settings['wa_notify_enabled'] ?? '0') === '1' ? 'selected' : '' }}>✅ Enabled</option>
                        </select>
                        <div class="current-val">📍 Currently: {{ ($settings['wa_notify_enabled'] ?? '0') === '1' ? 'Enabled' : 'Disabled' }}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Your WhatsApp Number <span style="color:var(--t4);font-weight:400">(digits only)</span></label>
                        <input class="form-input js-track" type="text" name="whatsapp_number"
                               value="{{ $settings['whatsapp_number'] ?? '' }}"
                               placeholder="919324555165">
                        <div class="current-val">📍 Currently: {{ $settings['whatsapp_number'] ?? 'Not set' }}</div>
                    </div>
                </div>

                {{-- Method choice --}}
                <div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:var(--r2);padding:16px;margin-bottom:16px">
                    <div style="font-family:var(--ff-h);font-size:12px;font-weight:700;color:#1E40AF;margin-bottom:12px">📱 Choose Notification Method</div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                        <div style="background:white;border-radius:var(--r);padding:14px;border:1px solid #BFDBFE">
                            <div style="font-family:var(--ff-h);font-size:12px;font-weight:700;color:var(--t1);margin-bottom:4px">Method 1 — CallMeBot (Free, Easy)</div>
                            <div style="font-size:11px;color:var(--t3);line-height:1.6;margin-bottom:8px">
                                1. Save +34 644 44 21 49 in contacts<br>
                                2. Send it "I allow callmebot to send me messages"<br>
                                3. You'll receive your API key by WhatsApp<br>
                                4. Paste the key below
                            </div>
                            <div class="form-group" style="margin:0">
                                <label class="form-label">CallMeBot API Key</label>
                                <input class="form-input js-track" type="text" name="wa_callmebot_key"
                                       value="{{ $settings['wa_callmebot_key'] ?? '' }}"
                                       placeholder="e.g. 1234567">
                                <div class="current-val">📍 {{ !empty($settings['wa_callmebot_key'] ?? '') ? '✅ Key configured' : '⚪ Not configured' }}</div>
                            </div>
                        </div>
                        <div style="background:white;border-radius:var(--r);padding:14px;border:1px solid #BFDBFE">
                            <div style="font-family:var(--ff-h);font-size:12px;font-weight:700;color:var(--t1);margin-bottom:4px">Method 2 — Meta WhatsApp API (Professional)</div>
                            <div style="font-size:11px;color:var(--t3);line-height:1.6;margin-bottom:8px">
                                Requires a Meta Business account and WhatsApp Business API setup. Go to developers.facebook.com to get your credentials.
                            </div>
                            <div class="form-group" style="margin-bottom:8px">
                                <label class="form-label">Phone Number ID</label>
                                <input class="form-input js-track" type="text" name="wa_phone_id"
                                       value="{{ $settings['wa_phone_id'] ?? '' }}"
                                       placeholder="From Meta Business Suite">
                                <div class="current-val">📍 {{ !empty($settings['wa_phone_id'] ?? '') ? '✅ Configured' : '⚪ Not configured' }}</div>
                            </div>
                            <div class="form-group" style="margin:0">
                                <label class="form-label">API Token (Permanent)</label>
                                <input class="form-input js-track" type="text" name="wa_api_token"
                                       value="{{ $settings['wa_api_token'] ?? '' }}"
                                       placeholder="EAAxxxxx...">
                                <div class="current-val">📍 {{ !empty($settings['wa_api_token'] ?? '') ? '✅ Token saved' : '⚪ Not configured' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="background:#FEF3C7;border:1px solid #FDE68A;border-radius:var(--r);padding:12px 14px;font-size:12px;color:#92400E">
                    💡 <strong>How it works:</strong> When a visitor fills the booking form, the system sends you a WhatsApp message with the customer name, phone number, and route — so you can call them back within 5 minutes.
                    The message is sent instantly when the lead is saved. If both methods are configured, Meta API is used. CallMeBot is used as fallback.
                </div>

            </div>
        </div>

        {{-- Email Config --}}
        <div class="card" style="margin-bottom:16px">
            <div class="card__header"><div class="card__title">📧 Email Notifications</div></div>
            <div class="card__body">
                <div class="form-group">
                    <label class="form-label">Send Lead Alerts To (Email)</label>
                    <input class="form-input js-track" type="email" name="admin_email_notify"
                           value="{{ $settings['admin_email_notify'] ?? '' }}"
                           placeholder="rkshahcarrental@gmail.com">
                    <div class="current-val">📍 Currently: {{ $settings['admin_email_notify'] ?? 'Not set' }}</div>
                    <div style="font-size:11px;color:var(--t4);margin-top:4px">Email notifications only work on the live server with SMTP configured in .env</div>
                </div>
            </div>
        </div>

        <div style="margin-top:14px;text-align:right">
            <button type="submit" class="btn btn--gold btn--lg">💾 Save Notification Settings</button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
function switchTab(name, btn) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.settings-tab').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-'+name).classList.add('active');
    btn.classList.add('active');
}
document.querySelectorAll('.js-track').forEach(el => {
    const orig = el.value;
    el.addEventListener('change', () => el.classList.toggle('changed', el.value !== orig));
    el.addEventListener('input',  () => el.classList.toggle('changed', el.value !== orig));
});
</script>
@endpush
