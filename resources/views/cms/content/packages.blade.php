@extends('cms.layouts.app')
@section('title', 'Tour Packages')
@section('page-title', 'Tour Packages')
@section('page-subtitle', 'Add, edit, delete packages · Image upload works in both Add and Edit')
@push('header-actions')
  <a href="{{ route('packages.index') }}" target="_blank" class="header-btn header-btn--outline">🔗 Preview</a>
  <button class="header-btn header-btn--gold" onclick="openModal('addPackageModal')">+ Add Package</button>
@endpush
@push('styles')
  <style>
    .current-val {
      font-size: 11px;
      color: var(--t4);
      margin-top: 4px;
      font-style: italic
    }

    .field-changed {
      border-color: #10B981 !important;
      background: #f0fdf4 !important
    }

    .img-preview {
      width: 70px;
      height: 50px;
      object-fit: cover;
      border-radius: var(--r);
      border: 1px solid var(--border)
    }
  </style>
@endpush
@section('content')

  <div class="how-to-bar">
    <span style="font-size:20px">💡</span>
    <div>
      <div class="how-to-bar__title">All values pre-filled · Image upload in both Add and Edit</div>
      <div class="how-to-bar__text">Each package has its own Save button. Changed fields turn green. 🗑️ permanently
        deletes the package.</div>
    </div>
  </div>

  <div style="display:flex;flex-direction:column;gap:16px">
    @forelse($packages as $pkg)
      <div class="card">
        <div class="card__header">
          <div style="display:flex;align-items:center;gap:12px">
            @if($pkg->featured_image)
              <img src="{{ asset('storage/' . $pkg->featured_image) }}"
                style="width:56px;height:56px;object-fit:cover;border-radius:var(--r);border:1px solid var(--border)">
            @else
              <span style="font-size:36px">{{ $pkg->emoji }}</span>
            @endif
            <div>
              <div class="card__title">{{ $pkg->name }}</div>
              <div style="font-size:11px;color:var(--t4)">
                {{ $pkg->nights > 0 ? $pkg->nights . 'N / ' . $pkg->days . 'D' : 'Custom' }}
                · {{ $pkg->price > 0 ? '₹' . number_format($pkg->price) . '/person' : 'Custom Pricing' }}
                @if($pkg->badge) · <span style="color:var(--gold);font-weight:600">{{ $pkg->badge }}</span>@endif
              </div>
            </div>
          </div>
          <div style="display:flex;align-items:center;gap:8px">
            <span class="badge badge--{{ $pkg->is_published ? 'active' : 'inactive' }}">
              {{ $pkg->is_published ? 'Published' : 'Hidden' }}
            </span>
            <a href="{{ route('packages.show', $pkg->slug) }}" target="_blank" class="icon-btn" title="Preview">🔗</a>
            <button class="icon-btn icon-btn--danger"
              onclick="deletePackage({{ $pkg->id }},'{{ addslashes($pkg->name) }}')">🗑️</button>
          </div>
        </div>

        <div class="card__body">
          <form action="{{ route('cms.content.packages.update', $pkg->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PATCH')
            <input type="hidden" name="is_published_submitted" value="1">

            {{-- Row 1: Name, Price, Badge, Published, Save --}}
            <div
              style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr auto;gap:10px;align-items:end;margin-bottom:12px">
              <div class="form-group" style="margin:0">
                <label class="form-label">Package Name</label>
                <input class="form-input js-track" type="text" name="name" value="{{ $pkg->name }}">
                <div class="current-val">📍 "{{ $pkg->name }}"</div>
              </div>
              <div class="form-group" style="margin:0">
                <label class="form-label">Price (₹/person)</label>
                <input class="form-input js-track" type="number" name="price" value="{{ $pkg->price }}" min="0"
                  placeholder="0 = custom">
                <div class="current-val">📍 {{ $pkg->price > 0 ? '₹' . number_format($pkg->price) : 'Custom' }}</div>
              </div>
              <div class="form-group" style="margin:0">
                <label class="form-label">Badge</label>
                <input class="form-input js-track" type="text" name="badge" value="{{ $pkg->badge }}"
                  placeholder="e.g. Best Seller">
                <div class="current-val">📍 "{{ $pkg->badge ?: 'None' }}"</div>
              </div>
              <div class="form-group" style="margin:0">
                <label class="form-label">Status</label>
                <div style="display:flex;align-items:center;gap:8px;height:38px">
                  <label class="toggle">
                    <input type="checkbox" name="is_published" value="1" {{ $pkg->is_published ? 'checked' : '' }}>
                    <span class="toggle__slider"></span>
                  </label>
                  <span style="font-size:12px;color:var(--t3)">{{ $pkg->is_published ? 'Live' : 'Hidden' }}</span>
                </div>
              </div>
              <button type="submit" class="btn btn--gold" style="align-self:end">💾 Save</button>
            </div>

            {{-- Description --}}
            <div class="form-group" style="margin-bottom:12px">
              <label class="form-label">Description</label>
              <textarea class="form-textarea js-track" name="description" rows="2">{{ $pkg->description }}</textarea>
              <div class="current-val">📍 {{ \Str::limit($pkg->description ?? '—', 80) }}</div>
            </div>

            {{-- Row 2: Destinations, Includes --}}
            <div class="form-row" style="margin-bottom:12px">
              <div class="form-group" style="margin:0">
                <label class="form-label">Destinations <span style="color:var(--t4);font-weight:400">(comma
                    separated)</span></label>
                <input class="form-input js-track" type="text" name="destinations"
                  value="{{ is_array($pkg->destinations) ? implode(', ', $pkg->destinations) : '' }}"
                  placeholder="e.g. Jaipur, Jodhpur, Udaipur">
                <div class="current-val">📍 {{ is_array($pkg->destinations) ? implode(', ', $pkg->destinations) : '—' }}
                </div>
              </div>
              <div class="form-group" style="margin:0">
                <label class="form-label">Includes <span style="color:var(--t4);font-weight:400">(comma
                    separated)</span></label>
                <input class="form-input js-track" type="text" name="includes"
                  value="{{ is_array($pkg->includes) ? implode(', ', $pkg->includes) : '' }}"
                  placeholder="AC Cab, Expert Driver, Fuel & Tolls">
                <div class="current-val">📍 {{ is_array($pkg->includes) ? implode(', ', $pkg->includes) : '—' }}</div>
              </div>
            </div>

            {{-- Row 3: Emoji, BG, Image Upload --}}
            <div style="background:var(--bg);border-radius:var(--r2);padding:12px;border:1px solid var(--border)">
              <div
                style="font-family:var(--ff-h);font-size:10px;font-weight:700;color:var(--t4);text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px">
                Image & Visual</div>
              <div style="display:grid;grid-template-columns:60px 1fr 1fr;gap:10px;align-items:start">
                <div class="form-group" style="margin:0">
                  <label class="form-label">Emoji</label>
                  <input class="form-input js-track" type="text" name="emoji" value="{{ $pkg->emoji }}" maxlength="5"
                    style="font-size:20px;text-align:center;padding:6px">
                </div>
                <div class="form-group" style="margin:0">
                  <label class="form-label">Card Background</label>
                  <select class="form-select js-track" name="bg_class">
                    @foreach(['pkg-rajasthan' => 'Rajasthan (brown)', 'pkg-himachal' => 'Himachal (blue)', 'pkg-uttarakhand' => 'Uttarakhand (green)', 'pkg-agra' => 'Agra (gold)', 'pkg-rishikesh' => 'Rishikesh (teal)', 'pkg-custom' => 'Custom (navy)'] as $val => $lbl)
                      <option value="{{ $val }}" {{ $pkg->bg_class === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                    @endforeach
                  </select>
                  <div class="current-val">📍 {{ $pkg->bg_class }}</div>
                </div>
                <div class="form-group" style="margin:0">
                  <label class="form-label">Upload Image <span style="color:var(--t4);font-weight:400">(max
                      3MB)</span></label>
                  <input type="file" name="package_image" accept="image/jpg,image/jpeg,image/png,image/webp"
                    style="font-size:12px;padding:5px;width:100%">
                  @if($pkg->featured_image)
                    <div style="display:flex;align-items:center;gap:8px;margin-top:6px">
                      <img src="{{ asset('storage/' . $pkg->featured_image) }}" class="img-preview">
                      <span style="font-size:11px;color:var(--t4)">Current image<br>Upload new to replace</span>
                    </div>
                  @else
                    <div class="current-val">📍 No image — showing emoji</div>
                  @endif
                </div>
              </div>
            </div>

          </form>
        </div>
      </div>
    @empty
      <div class="card">
        <div class="card__body">
          <div class="empty-state">
            <div class="empty-state__icon">🎒</div>
            <div class="empty-state__title">No packages yet</div>
            <div class="empty-state__desc">Click "+ Add Package" to create your first tour package</div>
          </div>
        </div>
      </div>
    @endforelse
  </div>


  {{-- ADD PACKAGE MODAL --}}
  <div class="modal-backdrop" id="addPackageModal">
    <div class="modal modal--lg">
      <div class="modal__header">
        <div class="modal__title">➕ Add New Tour Package</div>
        <button class="modal__close" onclick="closeModal('addPackageModal')">✕</button>
      </div>
      <form action="{{ route('cms.content.packages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal__body">

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Package Name *</label>
              <input class="form-input" type="text" name="name" required placeholder="e.g. Golden Triangle Tour">
            </div>
            <div class="form-group">
              <label class="form-label">Badge</label>
              <input class="form-input" type="text" name="badge" placeholder="e.g. Best Seller, New">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Nights *</label>
              <input class="form-input" type="number" name="nights" required min="0" placeholder="3">
              <div style="font-size:11px;color:var(--t4);margin-top:3px">Set 0 for day trips</div>
            </div>
            <div class="form-group">
              <label class="form-label">Days *</label>
              <input class="form-input" type="number" name="days" required min="0" placeholder="4">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Price Per Person (₹)</label>
              <input class="form-input" type="number" name="price" min="0" placeholder="0 = custom pricing">
            </div>
            <div class="form-group">
              <label class="form-label">Emoji</label>
              <input class="form-input" type="text" name="emoji" placeholder="🎒" maxlength="5" value="🎒"
                style="font-size:20px;text-align:center">
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Card Background</label>
            <select class="form-select" name="bg_class">
              <option value="pkg-rajasthan">Rajasthan (brown/gold)</option>
              <option value="pkg-himachal">Himachal (blue)</option>
              <option value="pkg-uttarakhand">Uttarakhand (green)</option>
              <option value="pkg-agra">Agra (gold)</option>
              <option value="pkg-rishikesh">Rishikesh (teal)</option>
              <option value="pkg-custom">Custom (navy)</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">Package Image <span style="color:var(--t4);font-weight:400">(optional · max 3MB ·
                jpg/png/webp)</span></label>
            <input type="file" name="package_image" accept="image/jpg,image/jpeg,image/png,image/webp"
              style="font-size:13px;padding:6px;width:100%;border:1.5px solid var(--border);border-radius:var(--r);background:var(--bg)">
            <div style="font-size:11px;color:var(--t4);margin-top:3px">If no image uploaded, emoji is shown instead</div>
          </div>

          <div class="form-group">
            <label class="form-label">Destinations <span style="color:var(--t4);font-weight:400">(comma
                separated)</span></label>
            <input class="form-input" type="text" name="destinations"
              placeholder="e.g. Jaipur, Jodhpur, Udaipur, Pushkar">
          </div>

          <div class="form-group">
            <label class="form-label">What's Included <span style="color:var(--t4);font-weight:400">(comma
                separated)</span></label>
            <input class="form-input" type="text" name="includes" value="AC Cab, Expert Driver, Fuel &amp; Tolls">
          </div>

          <div class="form-group">
            <label class="form-label">Description</label>
            <textarea class="form-textarea" name="description" rows="3"
              placeholder="Describe this package — highlights, what makes it special..."></textarea>
          </div>

          <div style="display:flex;align-items:center;gap:8px;margin-top:4px">
            <label class="toggle">
              <input type="checkbox" name="is_published" value="1" checked>
              <span class="toggle__slider"></span>
            </label>
            <span style="font-size:13px;color:var(--t2)">Publish on website immediately</span>
          </div>

        </div>
        <div class="modal__footer">
          <button type="button" class="btn btn--outline" onclick="closeModal('addPackageModal')">Cancel</button>
          <button type="submit" class="btn btn--gold">➕ Add Package</button>
        </div>
      </form>
    </div>
  </div>

  <form id="deletePackageForm" method="POST" style="display:none">@csrf @method('DELETE')</form>

@endsection
@push('scripts')
  <script>
    document.querySelectorAll('.js-track').forEach(i => {
      const o = i.value;
      i.addEventListener('input', () => i.classList.toggle('field-changed', i.value !== o));
      i.addEventListener('change', () => i.classList.toggle('field-changed', i.value !== o));
    });
    function deletePackage(id, name) {
      if (!confirm(`Delete "${name}"?\n\nThis permanently removes it from the website.`)) return;
      const f = document.getElementById('deletePackageForm');
      f.action = `/cms/content/packages/${id}`;
      f.submit();
    }
  </script>
@endpush