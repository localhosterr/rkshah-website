@extends('cms.layouts.app')
@section('title','Homepage Editor')
@section('page-title','Homepage Content Editor')
@section('page-subtitle','All fields show current live content — edit only what you want to change')
@push('header-actions')
<a href="{{ route('home') }}" target="_blank" class="header-btn header-btn--outline">🔗 Preview Website</a>
<button form="homepageForm" type="submit" class="header-btn header-btn--gold">💾 Save Changes</button>
@endpush
@push('styles')
<style>
.current-val{font-size:11px;color:var(--t4);margin-top:4px;font-style:italic;padding-left:2px}
.section-hint{background:#EFF6FF;border:1px solid #BFDBFE;border-radius:var(--r);padding:10px 14px;font-size:12px;color:#1E40AF;margin-bottom:14px;display:flex;align-items:center;gap:8px}
.changed{border-color:#10B981 !important;background:#f0fdf4 !important}
</style>
@endpush
@section('content')

<div style="background:#FEF3C7;border:1px solid #FDE68A;border-radius:var(--r2);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px">
    <span style="font-size:20px">💡</span>
    <div>
        <div style="font-family:var(--ff-h);font-size:13px;font-weight:700;color:#92400E;margin-bottom:2px">How this works</div>
        <div style="font-size:12px;color:#92400E">Every field shows the <strong>current live content</strong> from your website. Edit only the fields you want to change — blank fields are ignored and the original content stays unchanged. Changed fields turn green.</div>
    </div>
</div>

<form id="homepageForm" action="{{ route('cms.content.homepage.update') }}" method="POST">
@csrf @method('PUT')

{{-- HERO --}}
<div class="card" style="margin-bottom:16px">
    <div class="card__header">
        <div class="card__title">🏠 Hero Section</div>
        <span style="font-size:11px;color:var(--t4);background:var(--bg);padding:4px 10px;border-radius:20px">Top of homepage · Big headline + description</span>
    </div>
    <div class="card__body">
        <div class="section-hint">ℹ️ This is the first thing visitors see. Line 1 appears in white, Line 2 in gold.</div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Top Label <span style="color:var(--t4);font-weight:400">(small text above headline)</span></label>
                <input class="form-input js-track" type="text" name="hero__label" value="{{ $sections['hero']['label'] ?? '' }}" placeholder="e.g. Delhi's Trusted Outstation Cab Service">
                <div class="current-val">📍 Currently: "{{ $sections['hero']['label'] ?? 'Not set' }}"</div>
            </div>
            <div class="form-group">
                <label class="form-label">Primary Button Text</label>
                <input class="form-input js-track" type="text" name="hero__cta_primary" value="{{ $sections['hero']['cta_primary'] ?? '' }}" placeholder="e.g. Book Your Cab Now">
                <div class="current-val">📍 Currently: "{{ $sections['hero']['cta_primary'] ?? 'Not set' }}"</div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Headline Line 1 <span style="color:var(--t4);font-weight:400">(white)</span></label>
                <input class="form-input js-track" type="text" name="hero__title_line1" value="{{ $sections['hero']['title_line1'] ?? '' }}" placeholder="e.g. Every Road Leads to">
                <div class="current-val">📍 Currently: "{{ $sections['hero']['title_line1'] ?? 'Not set' }}"</div>
            </div>
            <div class="form-group">
                <label class="form-label">Headline Line 2 <span style="color:var(--gold);font-weight:400">● gold</span></label>
                <input class="form-input js-track" type="text" name="hero__title_line2" value="{{ $sections['hero']['title_line2'] ?? '' }}" placeholder="e.g. a Great Journey.">
                <div class="current-val">📍 Currently: "{{ $sections['hero']['title_line2'] ?? 'Not set' }}"</div>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Hero Description</label>
            <textarea class="form-textarea js-track" name="hero__description" rows="2">{{ $sections['hero']['description'] ?? '' }}</textarea>
            <div class="current-val">📍 Currently: "{{ \Str::limit($sections['hero']['description'] ?? 'Not set', 100) }}"</div>
        </div>
    </div>
</div>

{{-- TICKER --}}
<div class="card" style="margin-bottom:16px">
    <div class="card__header">
        <div class="card__title">📢 Scrolling Ticker Bar</div>
        <span style="font-size:11px;color:var(--t4);background:var(--bg);padding:4px 10px;border-radius:20px">Gold scrolling bar · 8 items</span>
    </div>
    <div class="card__body">
        <div class="section-hint">ℹ️ These 8 items scroll continuously across the gold bar below the hero section.</div>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px">
            @for($i=1;$i<=8;$i++)
            <div class="form-group">
                <label class="form-label">Item {{ $i }}</label>
                <input class="form-input js-track" type="text" name="ticker__item_{{ $i }}" value="{{ $sections['ticker']['item_'.$i] ?? '' }}" placeholder="e.g. AC Cars">
                <div class="current-val">📍 "{{ $sections['ticker']['item_'.$i] ?? 'Not set' }}"</div>
            </div>
            @endfor
        </div>
    </div>
</div>

{{-- TRUST BAR --}}
<div class="card" style="margin-bottom:16px">
    <div class="card__header">
        <div class="card__title">🔒 Trust Bar Badges</div>
        <span style="font-size:11px;color:var(--t4);background:var(--bg);padding:4px 10px;border-radius:20px">5 badges on dark bar · use emoji + text</span>
    </div>
    <div class="card__body">
        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:10px">
            @for($i=1;$i<=5;$i++)
            <div class="form-group">
                <label class="form-label">Badge {{ $i }}</label>
                <input class="form-input js-track" type="text" name="trust_bar__item_{{ $i }}" value="{{ $sections['trust_bar']['item_'.$i] ?? '' }}" placeholder="🔒 Verified">
                <div class="current-val">📍 "{{ $sections['trust_bar']['item_'.$i] ?? 'Not set' }}"</div>
            </div>
            @endfor
        </div>
    </div>
</div>

{{-- WHY US --}}
<div class="card" style="margin-bottom:16px">
    <div class="card__header">
        <div class="card__title">🛡️ Why Choose Us — 6 USP Cards</div>
        <span style="font-size:11px;color:var(--t4);background:var(--bg);padding:4px 10px;border-radius:20px">6 cards shown on the homepage</span>
    </div>
    <div class="card__body">
        <div class="form-row" style="margin-bottom:16px">
            <div class="form-group">
                <label class="form-label">Section Title</label>
                <input class="form-input js-track" type="text" name="why_us__section_title" value="{{ $sections['why_us']['section_title'] ?? '' }}">
                <div class="current-val">📍 Currently: "{{ $sections['why_us']['section_title'] ?? 'Not set' }}"</div>
            </div>
            <div class="form-group">
                <label class="form-label">Section Description</label>
                <input class="form-input js-track" type="text" name="why_us__section_desc" value="{{ $sections['why_us']['section_desc'] ?? '' }}">
                <div class="current-val">📍 Currently: "{{ \Str::limit($sections['why_us']['section_desc'] ?? 'Not set', 60) }}"</div>
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
            @for($i=1;$i<=6;$i++)
            <div style="background:var(--bg);border-radius:var(--r);padding:16px;border:1px solid var(--border)">
                <div style="font-family:var(--ff-h);font-size:11px;font-weight:700;color:var(--t3);margin-bottom:10px;text-transform:uppercase;display:flex;align-items:center;gap:8px">
                    <span style="background:var(--navy);color:var(--gold);width:20px;height:20px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:10px;flex-shrink:0">{{ $i }}</span>
                    USP Card {{ $i }}
                    <span style="color:var(--t4);font-weight:400;font-size:10px">· Current: {{ $sections['why_us']['usp_'.$i.'_title'] ?? 'Not set' }}</span>
                </div>
                <div style="display:flex;gap:8px;margin-bottom:8px">
                    <div class="form-group" style="width:68px;flex-shrink:0;margin:0">
                        <label class="form-label">Icon</label>
                        <input class="form-input js-track" type="text" name="why_us__usp_{{ $i }}_icon" value="{{ $sections['why_us']['usp_'.$i.'_icon'] ?? '' }}" placeholder="🛡️" style="text-align:center;font-size:18px">
                    </div>
                    <div class="form-group" style="flex:1;margin:0">
                        <label class="form-label">Title</label>
                        <input class="form-input js-track" type="text" name="why_us__usp_{{ $i }}_title" value="{{ $sections['why_us']['usp_'.$i.'_title'] ?? '' }}" placeholder="Card title">
                    </div>
                </div>
                <div class="form-group" style="margin:0">
                    <label class="form-label">Description</label>
                    <textarea class="form-textarea js-track" name="why_us__usp_{{ $i }}_desc" rows="2" placeholder="Card description">{{ $sections['why_us']['usp_'.$i.'_desc'] ?? '' }}</textarea>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>

{{-- HOW IT WORKS --}}
<div class="card" style="margin-bottom:16px">
    <div class="card__header">
        <div class="card__title">🔢 How It Works — 4 Steps</div>
        <span style="font-size:11px;color:var(--t4);background:var(--bg);padding:4px 10px;border-radius:20px">Booking process steps</span>
    </div>
    <div class="card__body">
        <div class="form-row" style="margin-bottom:14px">
            <div class="form-group">
                <label class="form-label">Section Title</label>
                <input class="form-input js-track" type="text" name="how_it_works__section_title" value="{{ $sections['how_it_works']['section_title'] ?? '' }}">
                <div class="current-val">📍 Currently: "{{ $sections['how_it_works']['section_title'] ?? 'Not set' }}"</div>
            </div>
            <div class="form-group">
                <label class="form-label">Section Description</label>
                <input class="form-input js-track" type="text" name="how_it_works__section_desc" value="{{ $sections['how_it_works']['section_desc'] ?? '' }}">
                <div class="current-val">📍 Currently: "{{ \Str::limit($sections['how_it_works']['section_desc'] ?? 'Not set', 60) }}"</div>
            </div>
        </div>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px">
            @for($i=1;$i<=4;$i++)
            <div style="background:var(--bg);border-radius:var(--r);padding:14px;border:1px solid var(--border)">
                <div style="font-family:var(--ff-h);font-size:11px;font-weight:700;color:var(--t3);margin-bottom:8px;text-transform:uppercase">Step {{ $i }}
                    <span style="font-weight:400;color:var(--t4)">· {{ $sections['how_it_works']['step_'.$i.'_title'] ?? 'Not set' }}</span>
                </div>
                <div style="display:flex;gap:6px;margin-bottom:8px">
                    <div class="form-group" style="width:48px;flex-shrink:0;margin:0">
                        <label class="form-label">No.</label>
                        <input class="form-input js-track" type="text" name="how_it_works__step_{{ $i }}_num" value="{{ $sections['how_it_works']['step_'.$i.'_num'] ?? '' }}" placeholder="0{{ $i }}" style="text-align:center">
                    </div>
                    <div class="form-group" style="width:48px;flex-shrink:0;margin:0">
                        <label class="form-label">Icon</label>
                        <input class="form-input js-track" type="text" name="how_it_works__step_{{ $i }}_icon" value="{{ $sections['how_it_works']['step_'.$i.'_icon'] ?? '' }}" placeholder="📋" style="text-align:center;font-size:16px">
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:8px">
                    <label class="form-label">Title</label>
                    <input class="form-input js-track" type="text" name="how_it_works__step_{{ $i }}_title" value="{{ $sections['how_it_works']['step_'.$i.'_title'] ?? '' }}" placeholder="Step title">
                </div>
                <div class="form-group" style="margin:0">
                    <label class="form-label">Description</label>
                    <textarea class="form-textarea js-track" name="how_it_works__step_{{ $i }}_desc" rows="3" placeholder="Step description">{{ $sections['how_it_works']['step_'.$i.'_desc'] ?? '' }}</textarea>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>

{{-- CTA --}}
<div class="card" style="margin-bottom:80px">
    <div class="card__header">
        <div class="card__title">🚀 Bottom CTA Banner</div>
        <span style="font-size:11px;color:var(--t4);background:var(--bg);padding:4px 10px;border-radius:20px">Gold banner at the bottom of homepage</span>
    </div>
    <div class="card__body">
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">CTA Title</label>
                <input class="form-input js-track" type="text" name="cta__title" value="{{ $sections['cta']['title'] ?? '' }}" placeholder="e.g. Ready for Your Next Adventure?">
                <div class="current-val">📍 Currently: "{{ $sections['cta']['title'] ?? 'Not set' }}"</div>
            </div>
            <div class="form-group">
                <label class="form-label">CTA Description</label>
                <input class="form-input js-track" type="text" name="cta__description" value="{{ $sections['cta']['description'] ?? '' }}" placeholder="Supporting text below the title">
                <div class="current-val">📍 Currently: "{{ \Str::limit($sections['cta']['description'] ?? 'Not set', 80) }}"</div>
            </div>
        </div>
    </div>
</div>

{{-- Sticky save bar --}}
<div style="position:sticky;bottom:0;background:white;border-top:2px solid var(--border);padding:14px 0;display:flex;align-items:center;justify-content:space-between;z-index:50">
    <div style="font-size:13px;color:var(--t3)">
        <span style="color:var(--green);font-weight:600">●</span>
        Fields that turn green have been changed · blank fields keep current content
    </div>
    <div style="display:flex;gap:10px">
        <a href="{{ route('home') }}" target="_blank" class="btn btn--outline">🔗 Preview Homepage</a>
        <button type="submit" class="btn btn--gold" style="padding:11px 28px">💾 Save Changes</button>
    </div>
</div>

</form>
@endsection

@push('scripts')
<script>
// Turn fields green when edited
document.querySelectorAll('.js-track').forEach(input => {
    const original = input.value;
    input.addEventListener('input', () => {
        if (input.value.trim() !== '' && input.value !== original) {
            input.classList.add('changed');
        } else {
            input.classList.remove('changed');
        }
    });
});
</script>
@endpush
