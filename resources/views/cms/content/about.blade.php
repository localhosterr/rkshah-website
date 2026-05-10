@extends('cms.layouts.app')
@section('title','About Page Editor')
@section('page-title','About Page Editor')
@section('page-subtitle','All fields show current live content — edit only what you want to change')
@push('header-actions')
<a href="{{ route('about') }}" target="_blank" class="header-btn header-btn--outline">🔗 Preview About Page</a>
<button form="aboutForm" type="submit" class="header-btn header-btn--gold">💾 Save Changes</button>
@endpush
@push('styles')
<style>
.current-val{font-size:11px;color:var(--t4);margin-top:4px;font-style:italic;padding-left:2px}
.section-hint{background:#EFF6FF;border:1px solid #BFDBFE;border-radius:var(--r);padding:10px 14px;font-size:12px;color:#1E40AF;margin-bottom:14px;display:flex;align-items:center;gap:8px}
</style>
@endpush
@section('content')

<div style="background:#FEF3C7;border:1px solid #FDE68A;border-radius:var(--r2);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px">
    <span style="font-size:20px">💡</span>
    <div>
        <div style="font-family:var(--ff-h);font-size:13px;font-weight:700;color:#92400E;margin-bottom:2px">How this works</div>
        <div style="font-size:12px;color:#92400E">Every field shows the <strong>current live content</strong>. Edit only the fields you want to change — blank fields are ignored. Timeline milestones are managed separately below.</div>
    </div>
</div>

<form id="aboutForm" action="{{ route('cms.content.about.update') }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')

{{-- Hero --}}
<div class="card" style="margin-bottom:16px">
    <div class="card__header"><div class="card__title">🏠 Page Hero</div><span style="font-size:11px;color:var(--t4);background:var(--bg);padding:4px 10px;border-radius:20px">Top section of the About page</span></div>
    <div class="card__body">
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Page Title</label>
                <input class="form-input" type="text" name="hero__title" value="{{ $sections['hero']['title'] ?? '' }}" placeholder="e.g. Built on Trust. Driven by Passion.">
                <div class="current-val">📍 Live: "{{ $sections['hero']['title'] ?? 'Not set' }}"</div>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Hero Description</label>
            <textarea class="form-textarea" name="hero__description" rows="2" placeholder="Shown below the title...">{{ $sections['hero']['description'] ?? '' }}</textarea>
            <div class="current-val">📍 Live: "{{ \Str::limit($sections['hero']['description'] ?? 'Not set', 100) }}"</div>
        </div>
    </div>
</div>

{{-- Story --}}
<div class="card" style="margin-bottom:16px">
    <div class="card__header"><div class="card__title">📖 Our Story Section</div><span style="font-size:11px;color:var(--t4);background:var(--bg);padding:4px 10px;border-radius:20px">The main story paragraphs</span></div>
    <div class="card__body">
        <div class="section-hint">ℹ️ These 4 paragraphs form the main story text shown next to the owner profile card.</div>
        <div class="form-group">
            <label class="form-label">Story Heading</label>
            <input class="form-input" type="text" name="story__heading" value="{{ $sections['story']['heading'] ?? '' }}" placeholder="e.g. Not a company. A commitment.">
            <div class="current-val">📍 Live: "{{ $sections['story']['heading'] ?? 'Not set' }}"</div>
        </div>
        @for($i=1;$i<=4;$i++)
        <div class="form-group">
            <label class="form-label">Paragraph {{ $i }}</label>
            <textarea class="form-textarea" name="story__para_{{ $i }}" rows="3" placeholder="Story paragraph {{ $i }}...">{{ $sections['story']['para_'.$i] ?? '' }}</textarea>
            <div class="current-val">📍 Live: "{{ \Str::limit($sections['story']['para_'.$i] ?? 'Not set', 100) }}"</div>
        </div>
        @endfor
    </div>
</div>

{{-- Owner --}}
<div class="card" style="margin-bottom:16px">
    <div class="card__header"><div class="card__title">👤 Owner Profile Card</div><span style="font-size:11px;color:var(--t4);background:var(--bg);padding:4px 10px;border-radius:20px">Dark card with name, title, and quote</span></div>
    <div class="card__body">
        {{-- Profile Photo --}}
        <div style="background:var(--bg);border-radius:var(--r2);padding:14px;margin-bottom:14px;border:1px solid var(--border)">
          <div style="font-family:var(--ff-h);font-size:10px;font-weight:700;color:var(--t4);text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px">Owner Profile Photo</div>
          <div style="display:flex;align-items:center;gap:16px">
            @if(!empty($ownerPhoto ?? ''))
            <img src="{{ asset('storage/'.($ownerPhoto ?? '')) }}"
                 style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:2px solid var(--navy)">
            @else
            <div style="width:80px;height:80px;border-radius:50%;background:var(--navy);display:flex;align-items:center;justify-content:center;font-family:var(--ff-h);font-size:1.5rem;font-weight:900;color:var(--gold)">RK</div>
            @endif
            <div style="flex:1">
              <input type="file" name="owner_photo" accept="image/jpg,image/jpeg,image/png,image/webp"
                     style="font-size:13px;padding:6px;width:100%;border:1.5px solid var(--border);border-radius:var(--r);background:white">
              <div style="font-size:11px;color:var(--t4);margin-top:4px">Upload profile photo · max 4MB · jpg/png/webp · Will show on About page instead of initials</div>
            </div>
          </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Owner Name</label>
                <input class="form-input" type="text" name="owner__name" value="{{ $sections['owner']['name'] ?? '' }}" placeholder="RK Shah">
                <div class="current-val">📍 Live: "{{ $sections['owner']['name'] ?? 'Not set' }}"</div>
            </div>
            <div class="form-group">
                <label class="form-label">Owner Title / Role</label>
                <input class="form-input" type="text" name="owner__title" value="{{ $sections['owner']['title'] ?? '' }}" placeholder="Founder & Owner">
                <div class="current-val">📍 Live: "{{ $sections['owner']['title'] ?? 'Not set' }}"</div>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Location / Since</label>
            <input class="form-input" type="text" name="owner__location" value="{{ $sections['owner']['location'] ?? '' }}" placeholder="Soniya Vihar, Delhi · Since 2015">
            <div class="current-val">📍 Live: "{{ $sections['owner']['location'] ?? 'Not set' }}"</div>
        </div>
        <div class="form-group">
            <label class="form-label">Owner Quote <span style="color:var(--t4);font-weight:400">(shown in the dark profile card)</span></label>
            <textarea class="form-textarea" name="owner__quote" rows="3" placeholder="Personal quote from RK Shah...">{{ $sections['owner']['quote'] ?? '' }}</textarea>
            <div class="current-val">📍 Live: "{{ \Str::limit($sections['owner']['quote'] ?? 'Not set', 100) }}"</div>
        </div>
    </div>
</div>

{{-- CTA --}}
<div class="card" style="margin-bottom:24px">
    <div class="card__header"><div class="card__title">🚀 Bottom CTA Section</div></div>
    <div class="card__body">
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">CTA Title</label>
                <input class="form-input" type="text" name="cta__title" value="{{ $sections['cta']['title'] ?? '' }}" placeholder="e.g. Travel with Someone You Can Trust">
                <div class="current-val">📍 Live: "{{ $sections['cta']['title'] ?? 'Not set' }}"</div>
            </div>
            <div class="form-group">
                <label class="form-label">CTA Description</label>
                <input class="form-input" type="text" name="cta__description" value="{{ $sections['cta']['description'] ?? '' }}" placeholder="Supporting text...">
                <div class="current-val">📍 Live: "{{ \Str::limit($sections['cta']['description'] ?? 'Not set', 80) }}"</div>
            </div>
        </div>
    </div>
</div>

{{-- Sticky save bar --}}
<div style="position:sticky;bottom:0;background:white;border-top:2px solid var(--border);padding:14px 0;display:flex;align-items:center;justify-content:space-between;z-index:50">
    <div style="font-size:13px;color:var(--t3)"><span style="color:var(--green);font-weight:600">●</span> Only fields you edit will be updated — blank fields keep current content</div>
    <div style="display:flex;gap:10px">
        <a href="{{ route('about') }}" target="_blank" class="btn btn--outline">🔗 Preview About Page</a>
        <button type="submit" class="btn btn--gold" style="padding:11px 28px">💾 Save Changes</button>
    </div>
</div>

</form>

{{-- TIMELINE — separate section, not part of the save form --}}
<div class="card" style="margin-top:24px">
    <div class="card__header">
        <div class="card__title">🗓️ Journey Timeline <span style="font-family:var(--ff-b);font-size:12px;font-weight:400;color:var(--t4)">— {{ $timeline->count() }} milestones</span></div>
        <button class="btn btn--sm btn--gold" onclick="document.getElementById('addMilestoneModal').classList.add('open')">+ Add Milestone</button>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Year</th><th>Icon</th><th>Color</th><th>Title</th><th>Description</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($timeline as $item)
                <tr>
                    <td><span style="font-family:var(--ff-h);font-weight:900;color:{{ $item->color }};font-size:1rem">{{ $item->year }}</span></td>
                    <td style="font-size:22px">{{ $item->icon }}</td>
                    <td><div style="width:24px;height:24px;border-radius:4px;background:{{ $item->color }};border:1px solid var(--border)"></div></td>
                    <td style="font-weight:600;color:var(--t1)">{{ $item->title }}</td>
                    <td style="font-size:12px;color:var(--t3);max-width:300px">{{ \Str::limit($item->description, 90) }}</td>
                    <td>
                        <form action="{{ route('cms.content.timeline.delete', $item->id) }}" method="POST" onsubmit="return confirm('Delete this milestone?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="icon-btn icon-btn--danger" title="Delete milestone">🗑️</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="empty-state"><div class="empty-state__icon">🗓️</div><div class="empty-state__title">No milestones yet</div></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Add Milestone Modal --}}
<div class="modal-backdrop" id="addMilestoneModal">
    <div class="modal">
        <div class="modal__header">
            <div class="modal__title">Add Timeline Milestone</div>
            <button class="modal__close" onclick="closeModal('addMilestoneModal')">✕</button>
        </div>
        <form action="{{ route('cms.content.timeline.store') }}" method="POST">
            @csrf
            <div class="modal__body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Year *</label>
                        <input class="form-input" type="text" name="year" required placeholder="2026" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Icon (emoji)</label>
                        <input class="form-input" type="text" name="icon" placeholder="🚗" maxlength="5">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Title *</label>
                        <input class="form-input" type="text" name="title" required placeholder="Milestone title">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Accent Color</label>
                        <input class="form-input" type="color" name="color" value="#D4A017">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Description *</label>
                    <textarea class="form-textarea" name="description" required rows="3" placeholder="What happened this year?"></textarea>
                </div>
            </div>
            <div class="modal__footer">
                <button type="button" class="btn btn--outline" onclick="closeModal('addMilestoneModal')">Cancel</button>
                <button type="submit" class="btn btn--gold">Add Milestone</button>
            </div>
        </form>
    </div>
</div>

@endsection
@push('scripts')
<script>
// Highlight fields that have been changed
document.querySelectorAll('.form-input, .form-textarea').forEach(input => {
    const original = input.value;
    input.addEventListener('input', () => {
        if (input.value.trim() !== '' && input.value !== original) {
            input.style.borderColor = '#10B981';
            input.style.background  = '#f0fdf4';
        } else {
            input.style.borderColor = '';
            input.style.background  = '';
        }
    });
});
</script>
@endpush
