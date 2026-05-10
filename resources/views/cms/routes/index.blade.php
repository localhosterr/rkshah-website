@extends('cms.layouts.app')
@section('title','Routes & Pricing')
@section('page-title','Routes & Pricing')
@section('page-subtitle','Add, edit, delete routes · Manage per-car pricing · Toggle live/hidden')

@push('header-actions')
<a href="{{ route('routes.index') }}" target="_blank" class="header-btn header-btn--outline">🔗 Preview</a>
<button class="header-btn header-btn--gold" onclick="openModal('addRouteModal')">+ Add Route</button>
@endpush

@push('styles')
<style>
.current-val{font-size:10px;color:var(--t4);margin-top:3px;font-style:italic}
.field-changed{border-color:#10B981!important;background:#f0fdf4!important}
.price-input{font-family:var(--ff-h);font-weight:600;font-size:12px;padding:7px 8px;width:100%}
.no-price{border-style:dashed;color:var(--t4)}
</style>
@endpush

@section('content')

<div style="background:#FEF3C7;border:1px solid #FDE68A;border-radius:var(--r2);padding:12px 18px;margin-bottom:16px;display:flex;gap:10px;align-items:center">
  <span style="font-size:18px">💡</span>
  <div style="font-size:12px;color:#92400E">
    <strong>All prices pre-filled.</strong>
    💾 saves pricing · ✏️ edits route details + image · 🗑️ deletes · Toggle shows/hides on website.
  </div>
</div>

<div class="card">
  <div class="card__header">
    <div class="card__title">🗺️ All Routes <span style="font-size:12px;font-weight:400;color:var(--t4)">{{ $routes->count() }} routes</span></div>
  </div>
  <div style="overflow-x:auto">
    <table>
      <thead>
        <tr>
          <th style="min-width:180px">Route</th>
          <th>Image</th>
          <th>Dist · Time</th>
          <th>Tag</th>
          <th style="min-width:90px">🚕 Dzire</th>
          <th style="min-width:90px">🚐 Ertiga</th>
          <th style="min-width:90px">🚗 Creta</th>
          <th style="min-width:90px">🚙 Innova</th>
          <th>Live</th>
          <th style="min-width:130px">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($routes as $route)
        <tr>
          <form action="{{ route('cms.routes.update', $route->id) }}" method="POST">
            @csrf @method('PATCH')

            <td>
              <div style="font-weight:600;color:var(--t1)">{{ $route->from_city }} → {{ $route->to_city }}</div>
              <div style="font-size:11px;color:var(--t4)">{{ $route->highlight }} · {{ $route->highway }}</div>
            </td>

            {{-- Image status --}}
            <td>
              @if($route->featured_image)
                <img src="{{ asset('storage/'.$route->featured_image) }}"
                     style="width:60px;height:40px;object-fit:cover;border-radius:4px;border:1px solid var(--border)"
                     alt="Route image">
              @else
                <span style="font-size:11px;color:var(--t4)">No image</span>
              @endif
            </td>

            <td style="font-size:12px;color:var(--t3);white-space:nowrap">
              {{ $route->distance_km > 0 ? $route->distance_km.' km' : '—' }}
              @if($route->duration_hrs)<br><span style="color:var(--t4)">~{{ $route->duration_hrs }}h</span>@endif
            </td>
            <td><span style="font-size:11px;background:var(--bg);padding:2px 8px;border-radius:10px;color:var(--t3)">{{ $route->tag ?? '—' }}</span></td>

            @foreach(['price_dzire'=>$route->price_dzire,'price_ertiga'=>$route->price_ertiga,'price_creta'=>$route->price_creta,'price_innova'=>$route->price_innova] as $field=>$price)
            <td>
              <input class="form-input price-input js-track {{ !$price ? 'no-price' : '' }}"
                     type="number" name="{{ $field }}" value="{{ $price }}"
                     min="0" step="10" placeholder="—">
              <div class="current-val">{{ $price ? '₹'.number_format($price) : 'Not offered' }}</div>
            </td>
            @endforeach

            <td>
              <label class="toggle">
                <input type="checkbox" name="is_published"
                       {{ $route->is_published?'checked':'' }} onchange="this.form.submit()">
                <span class="toggle__slider"></span>
              </label>
              <div class="current-val" style="text-align:center">{{ $route->is_published?'✅ Live':'❌ Off' }}</div>
            </td>

            <td>
              <div style="display:flex;gap:4px;flex-wrap:wrap">
                <button type="submit" class="btn btn--sm btn--gold" title="Save pricing">💾</button>
                <button type="button" class="icon-btn" title="Edit details & image"
                  onclick="openEditRoute(
                    {{ $route->id }},
                    '{{ addslashes($route->from_city) }}',
                    '{{ addslashes($route->to_city) }}',
                    '{{ $route->distance_km }}',
                    '{{ $route->duration_hrs }}',
                    '{{ addslashes($route->highway ?? '') }}',
                    '{{ addslashes($route->highlight ?? '') }}',
                    '{{ addslashes($route->tag ?? '') }}',
                    '{{ $route->accent_color ?? '#083C5D' }}',
                    '{{ $route->featured_image ? asset('storage/'.$route->featured_image) : '' }}'
                  )">✏️</button>
                <a href="{{ route('routes.show', $route->slug) }}" target="_blank" class="icon-btn" title="Preview">🔗</a>
                <button type="button" class="icon-btn icon-btn--danger" title="Delete"
                  onclick="deleteRoute({{ $route->id }}, '{{ addslashes($route->from_city.' → '.$route->to_city) }}')">🗑️</button>
              </div>
            </td>
          </form>
        </tr>
        @empty
        <tr><td colspan="10"><div class="empty-state"><div class="empty-state__icon">🗺️</div><div class="empty-state__title">No routes yet</div></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>


{{-- ADD ROUTE MODAL --}}
<div class="modal-backdrop" id="addRouteModal">
  <div class="modal modal--lg">
    <div class="modal__header">
      <div class="modal__title">➕ Add New Route</div>
      <button class="modal__close" onclick="closeModal('addRouteModal')">✕</button>
    </div>
    <form action="{{ route('cms.routes.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal__body">

        <div class="form-row">
          <div class="form-group"><label class="form-label">From City *</label><input class="form-input" type="text" name="from_city" required value="Delhi"></div>
          <div class="form-group"><label class="form-label">To City *</label><input class="form-input" type="text" name="to_city" required placeholder="e.g. Varanasi"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Distance (km) *</label><input class="form-input" type="number" name="distance_km" required placeholder="820" min="0"></div>
          <div class="form-group"><label class="form-label">Duration (hours)</label><input class="form-input" type="number" name="duration_hrs" step="0.5" placeholder="12.5" min="0"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Highway / Route</label><input class="form-input" type="text" name="highway" placeholder="e.g. NH19 via Agra"></div>
          <div class="form-group"><label class="form-label">Known For / Highlight</label><input class="form-input" type="text" name="highlight" placeholder="e.g. Kashi Vishwanath"></div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Category Tag</label>
            <select class="form-select" name="tag">
              <option value="">Select tag...</option>
              <option value="Weekend">Weekend</option>
              <option value="Hills">Hills</option>
              <option value="Spiritual">Spiritual</option>
              <option value="Rajasthan">Rajasthan</option>
              <option value="Airport">Airport</option>
            </select>
          </div>
          <div class="form-group"><label class="form-label">Accent Color</label><input class="form-input" type="color" name="accent_color" value="#083C5D"></div>
        </div>

        {{-- IMAGE UPLOAD --}}
        <div class="form-group">
          <label class="form-label">Route Image <span style="color:var(--t4);font-weight:400">(optional · 1200×280px recommended · max 4MB)</span></label>
          <input type="file" name="route_image" accept="image/jpg,image/jpeg,image/png,image/webp"
                 style="font-size:13px;padding:6px;width:100%;border:1.5px solid var(--border);border-radius:var(--r);background:var(--bg)">
          <div style="font-size:11px;color:var(--t4);margin-top:3px">Shown on route card and route detail page</div>
        </div>

        <div style="border-top:1px solid var(--border);padding-top:14px;margin-top:4px">
          <div style="font-family:var(--ff-h);font-size:11px;font-weight:700;color:var(--t3);text-transform:uppercase;margin-bottom:10px">Starting Prices (₹ one way) — leave blank if car not offered</div>
          <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px">
            @foreach(['price_dzire'=>'🚕 Dzire','price_ertiga'=>'🚐 Ertiga','price_creta'=>'🚗 Creta','price_innova'=>'🚙 Innova'] as $field=>$label)
            <div class="form-group" style="margin:0"><label class="form-label">{{ $label }}</label><input class="form-input" type="number" name="{{ $field }}" placeholder="—" min="0" step="10" style="font-family:var(--ff-h);font-weight:600"></div>
            @endforeach
          </div>
        </div>

        <div style="display:flex;align-items:center;gap:8px;margin-top:14px">
          <label class="toggle"><input type="checkbox" name="is_published" value="1" checked><span class="toggle__slider"></span></label>
          <span style="font-size:13px;color:var(--t2)">Publish on website immediately</span>
        </div>
      </div>
      <div class="modal__footer">
        <button type="button" class="btn btn--outline" onclick="closeModal('addRouteModal')">Cancel</button>
        <button type="submit" class="btn btn--gold">➕ Add Route</button>
      </div>
    </form>
  </div>
</div>


{{-- EDIT ROUTE DETAILS MODAL --}}
<div class="modal-backdrop" id="editRouteModal">
  <div class="modal modal--lg">
    <div class="modal__header">
      <div class="modal__title">✏️ Edit Route Details</div>
      <button class="modal__close" onclick="closeModal('editRouteModal')">✕</button>
    </div>
    {{-- enctype REQUIRED for image upload --}}
    <form id="editRouteForm" method="POST" enctype="multipart/form-data">
      @csrf @method('PATCH')
      <div class="modal__body">

        <div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:var(--r);padding:10px 14px;margin-bottom:14px;font-size:12px;color:#1E40AF">
          ℹ️ All fields pre-filled with current values. Edit only what needs to change — blank fields keep existing values.
        </div>

        <div class="form-row">
          <div class="form-group"><label class="form-label">From City</label><input class="form-input js-track" type="text" name="from_city" id="eFrom"></div>
          <div class="form-group"><label class="form-label">To City</label><input class="form-input js-track" type="text" name="to_city" id="eTo"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Distance (km)</label><input class="form-input js-track" type="number" name="distance_km" id="eKm" min="0"></div>
          <div class="form-group"><label class="form-label">Duration (hours)</label><input class="form-input js-track" type="number" name="duration_hrs" id="eHrs" step="0.5" min="0"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Highway / Route</label><input class="form-input js-track" type="text" name="highway" id="eHighway"></div>
          <div class="form-group"><label class="form-label">Known For / Highlight</label><input class="form-input js-track" type="text" name="highlight" id="eHighlight"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Category Tag</label><input class="form-input js-track" type="text" name="tag" id="eTag"></div>
          <div class="form-group"><label class="form-label">Accent Color</label><input class="form-input js-track" type="color" name="accent_color" id="eColor"></div>
        </div>

        {{-- IMAGE UPLOAD in edit modal --}}
        <div class="form-group" style="margin-top:8px">
          <label class="form-label">Route Image <span style="color:var(--t4);font-weight:400">(1200×280px · max 4MB · upload new to replace)</span></label>
          <input type="file" name="route_image" accept="image/jpg,image/jpeg,image/png,image/webp"
                 style="font-size:13px;padding:6px;width:100%;border:1.5px solid var(--border);border-radius:var(--r);background:var(--bg)">
          {{-- Current image preview --}}
          <div id="eImagePreview" style="display:none;margin-top:8px;align-items:center;gap:10px">
            <img id="eImageThumb" src="" alt="Current"
                 style="width:120px;height:50px;object-fit:cover;border-radius:var(--r);border:1px solid var(--border)">
            <span style="font-size:11px;color:var(--t4)">Current image — upload new to replace</span>
          </div>
        </div>

      </div>
      <div class="modal__footer">
        <button type="button" class="btn btn--outline" onclick="closeModal('editRouteModal')">Cancel</button>
        <button type="submit" class="btn btn--gold">💾 Save Changes</button>
      </div>
    </form>
  </div>
</div>

<form id="deleteRouteForm" method="POST" style="display:none">@csrf @method('DELETE')</form>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.js-track').forEach(i=>{
  const o=i.value;
  i.addEventListener('input',()=>i.classList.toggle('field-changed',i.value!==o));
});

function openEditRoute(id, from, to, km, hrs, highway, highlight, tag, color, imageUrl) {
  // Set form action
  document.getElementById('editRouteForm').action = '/cms/routes/' + id;
  // Pre-fill all fields
  document.getElementById('eFrom').value      = from;
  document.getElementById('eTo').value        = to;
  document.getElementById('eKm').value        = km;
  document.getElementById('eHrs').value       = hrs;
  document.getElementById('eHighway').value   = highway;
  document.getElementById('eHighlight').value = highlight;
  document.getElementById('eTag').value       = tag;
  document.getElementById('eColor').value     = color;
  // Show current image if exists
  var preview = document.getElementById('eImagePreview');
  var thumb   = document.getElementById('eImageThumb');
  if (imageUrl && imageUrl !== '') {
    thumb.src            = imageUrl;
    preview.style.display = 'flex';
  } else {
    preview.style.display = 'none';
  }
  openModal('editRouteModal');
}

function deleteRoute(id, name) {
  if (!confirm('Delete route "' + name + '"?\n\nThis permanently removes it from the website.')) return;
  var f = document.getElementById('deleteRouteForm');
  f.action = '/cms/routes/' + id;
  f.submit();
}
</script>
@endpush
