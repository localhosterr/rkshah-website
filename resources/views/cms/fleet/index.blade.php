@extends('cms.layouts.app')
@section('title','Fleet Manager')
@section('page-title','Fleet Manager')
@section('page-subtitle','Add, edit, and remove vehicles — changes go live instantly')
@push('header-actions')
<a href="{{ route('fleet.index') }}" target="_blank" class="header-btn header-btn--outline">🔗 Preview</a>
<button class="header-btn header-btn--gold" onclick="openModal('addCarModal')">+ Add Car</button>
@endpush
@push('styles')
<style>
.current-val{font-size:11px;color:var(--t4);margin-top:4px;font-style:italic}
.field-changed{border-color:#10B981!important;background:#f0fdf4!important}
</style>
@endpush
@section('content')

<div class="how-to-bar">
  <span style="font-size:20px">💡</span>
  <div>
    <div class="how-to-bar__title">Full CRUD — Add new cars, edit pricing & details, deactivate or delete</div>
    <div class="how-to-bar__text">All current values pre-filled. Changed fields turn green. Each car has its own Save button. Rate changes update the fare calculator on the website instantly.</div>
  </div>
</div>

<div class="two-col">
  @foreach($cars as $car)
  <div class="card">
    <div class="card__header">
      <div style="display:flex;align-items:center;gap:12px">
        <span style="font-size:36px">{{ $car->emoji }}</span>
        <div>
          <div class="card__title">{{ $car->name }}</div>
          <div style="font-size:11px;color:var(--t4)">{{ $car->type }} · {{ $car->seats }} seats · {{ $car->fuel }} · {{ $car->model_year }}</div>
        </div>
      </div>
      <div style="display:flex;align-items:center;gap:8px">
        <span class="badge badge--{{ $car->is_active ? 'active' : 'inactive' }}">{{ $car->is_active ? 'Active' : 'Inactive' }}</span>
        <button class="icon-btn icon-btn--danger" title="Delete car"
                onclick="deleteCar({{ $car->id }},'{{ addslashes($car->name) }}')">🗑️</button>
      </div>
    </div>
    <div class="card__body">
      <form action="{{ route('cms.fleet.update', $car->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PATCH')
        <input type="hidden" name="is_active_submitted" value="1">

        {{-- CAR DETAILS --}}
        <div style="background:var(--bg);border-radius:var(--r2);padding:14px;margin-bottom:14px;border:1px solid var(--border)">
          <div style="font-family:var(--ff-h);font-size:10px;font-weight:700;color:var(--t4);text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px">Car Details</div>
          <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:10px">
            <div class="form-group" style="margin:0">
              <label class="form-label">Car Name</label>
              <input class="form-input js-track" type="text" name="name" value="{{ $car->name }}">
              <div class="current-val">📍 {{ $car->name }}</div>
            </div>
            <div class="form-group" style="margin:0">
              <label class="form-label">Type</label>
              <input class="form-input js-track" type="text" name="type" value="{{ $car->type }}">
              <div class="current-val">📍 {{ $car->type }}</div>
            </div>
            <div class="form-group" style="margin:0">
              <label class="form-label">Seats</label>
              <input class="form-input js-track" type="number" name="seats" value="{{ $car->seats }}" min="1" max="20">
              <div class="current-val">📍 {{ $car->seats }} seats</div>
            </div>
            <div class="form-group" style="margin:0">
              <label class="form-label">Fuel</label>
              <select class="form-select js-track" name="fuel">
                @foreach(['Diesel','Petrol','CNG/Petrol','Petrol/Diesel'] as $fuelOpt)
                <option value="{{ $fuelOpt }}" {{ $car->fuel===$fuelOpt?'selected':'' }}>{{ $fuelOpt }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:10px">
            <div class="form-group" style="margin:0">
              <label class="form-label">Model Year</label>
              <input class="form-input js-track" type="text" name="model_year" value="{{ $car->model_year }}" placeholder="2024">
              <div class="current-val">📍 {{ $car->model_year }}</div>
            </div>
            <div class="form-group" style="margin:0">
              <label class="form-label">Luggage Space</label>
              <input class="form-input js-track" type="text" name="luggage" value="{{ $car->luggage }}" placeholder="e.g. 3 large bags">
              <div class="current-val">📍 {{ $car->luggage ?? '—' }}</div>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Rate Per KM (₹) *</label>
            <input class="form-input js-track" type="number" name="rate_per_km"
                   value="{{ $car->rate_per_km }}" min="1" max="999" step="0.5">
            <div class="current-val">📍 Currently: <strong>₹{{ $car->rate_per_km }}/km</strong></div>
          </div>
          <div class="form-group">
            <label class="form-label">Driver Allowance/Day (₹)</label>
            <input class="form-input js-track" type="number" name="driver_allowance"
                   value="{{ $car->driver_allowance }}" min="0">
            <div class="current-val">📍 Currently: <strong>₹{{ number_format($car->driver_allowance) }}/day</strong></div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Badge <span style="color:var(--t4);font-weight:400">(e.g. Most Popular)</span></label>
            <input class="form-input js-track" type="text" name="badge"
                   value="{{ $car->badge }}" placeholder="Leave blank for no badge">
            <div class="current-val">📍 Currently: <strong>{{ $car->badge ?: 'No badge' }}</strong></div>
          </div>
          <div class="form-group">
            <label class="form-label">Min KM Charge</label>
            <input class="form-input js-track" type="number" name="min_km"
                   value="{{ $car->min_km }}" min="0">
            <div class="current-val">📍 Currently: <strong>{{ $car->min_km }} km minimum</strong></div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Best For</label>
          <input class="form-input js-track" type="text" name="best_for"
                 value="{{ $car->best_for }}" placeholder="e.g. Large families, Group tours">
          <div class="current-val">📍 Currently: <strong>{{ \Str::limit($car->best_for,60) }}</strong></div>
        </div>

        <div class="form-group">
          <label class="form-label">Features <span style="color:var(--t4);font-weight:400">(comma separated)</span></label>
          <input class="form-input js-track" type="text" name="features"
                 value="{{ is_array($car->features) ? implode(', ',$car->features) : $car->features }}"
                 placeholder="AC, GPS, USB Charging, Music System">
          <div class="current-val">📍 Currently: <strong>{{ is_array($car->features) ? implode(', ',$car->features) : 'Not set' }}</strong></div>
        </div>

        {{-- IMAGE & VISUAL --}}
        <div style="background:var(--bg);border-radius:var(--r2);padding:14px;margin-bottom:14px;border:1px solid var(--border)">
          <div style="font-family:var(--ff-h);font-size:10px;font-weight:700;color:var(--t4);text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px">Image & Visual</div>
          <div style="display:grid;grid-template-columns:60px 1fr 1fr;gap:10px;align-items:start">
            <div class="form-group" style="margin:0">
              <label class="form-label">Emoji</label>
              <input class="form-input js-track" type="text" name="emoji"
                     value="{{ $car->emoji }}" maxlength="5"
                     style="font-size:20px;text-align:center;padding:6px">
              <div class="current-val">📍 {{ $car->emoji }}</div>
            </div>
            <div class="form-group" style="margin:0">
              <label class="form-label">Card Background</label>
              <select class="form-select js-track" name="bg_class">
                @foreach(['fleet-innova'=>'Dark Blue','fleet-creta'=>'Warm Beige','fleet-ertiga'=>'Light Green','fleet-dzire'=>'Golden'] as $val=>$lbl)
                <option value="{{ $val }}" {{ $car->bg_class===$val?'selected':'' }}>{{ $lbl }}</option>
                @endforeach
              </select>
              <div class="current-val">📍 {{ $car->bg_class }}</div>
            </div>
            <div class="form-group" style="margin:0">
              <label class="form-label">Car Image <span style="color:var(--t4);font-weight:400">(max 4MB)</span></label>
              <input type="file" name="car_image" accept="image/jpg,image/jpeg,image/png,image/webp"
                     style="font-size:12px;padding:5px;width:100%">
              @if($car->featured_image)
              <div style="display:flex;align-items:center;gap:8px;margin-top:6px">
                <img src="{{ asset('storage/'.$car->featured_image) }}"
                     style="width:70px;height:50px;object-fit:cover;border-radius:var(--r);border:1px solid var(--border)">
                <span style="font-size:10px;color:var(--t4)">Current image<br>Upload new to replace</span>
              </div>
              @else
              <div class="current-val">📍 No image — showing emoji</div>
              @endif
            </div>
          </div>
        </div>

        {{-- Utilisation --}}
        <div style="margin-bottom:14px">
          <div style="display:flex;justify-content:space-between;margin-bottom:4px">
            <span style="font-size:11px;color:var(--t3);font-family:var(--ff-h);font-weight:600;text-transform:uppercase">This Month Utilisation</span>
            <span style="font-size:11px;font-weight:700;color:var(--navy)">{{ $car->utilisation ?? 0 }}%</span>
          </div>
          <div style="background:var(--bg);border-radius:4px;height:6px;overflow:hidden">
            <div style="height:100%;border-radius:4px;background:var(--navy);width:{{ $car->utilisation ?? 0 }}%"></div>
          </div>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <label class="toggle">
              <input type="checkbox" name="is_active" {{ $car->is_active?'checked':'' }}>
              <span class="toggle__slider"></span>
            </label>
            <span style="font-size:13px;color:var(--t2)">Active on website</span>
          </label>
          <button type="submit" class="btn btn--gold">💾 Save {{ $car->name }}</button>
        </div>
      </form>
    </div>
  </div>
  @endforeach
</div>

{{-- ADD CAR MODAL --}}
<div class="modal-backdrop" id="addCarModal">
  <div class="modal modal--lg">
    <div class="modal__header"><div class="modal__title">➕ Add New Car to Fleet</div><button class="modal__close" onclick="closeModal('addCarModal')">✕</button></div>
    <form action="{{ route('cms.fleet.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal__body">
        <div class="form-row">
          <div class="form-group"><label class="form-label">Car Name *</label><input class="form-input" name="name" required placeholder="e.g. Toyota Fortuner"></div>
          <div class="form-group"><label class="form-label">Type *</label><input class="form-input" name="type" required placeholder="e.g. Full-size SUV"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Fuel Type *</label>
            <select class="form-select" name="fuel">
              <option>Diesel</option><option>Petrol</option><option>CNG/Petrol</option><option>Petrol/Diesel</option>
            </select>
          </div>
          <div class="form-group"><label class="form-label">Seats *</label><input class="form-input" type="number" name="seats" required placeholder="7" min="1" max="20"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Model Year</label><input class="form-input" name="model_year" placeholder="2024" value="{{ date('Y') }}"></div>
          <div class="form-group"><label class="form-label">Luggage Space</label><input class="form-input" name="luggage" placeholder="e.g. 3 large bags"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Rate Per KM (₹) *</label><input class="form-input" type="number" name="rate_per_km" required placeholder="14" min="1" step="0.5"></div>
          <div class="form-group"><label class="form-label">Driver Allowance/Day (₹)</label><input class="form-input" type="number" name="driver_allowance" placeholder="2200" min="0"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Minimum KM</label><input class="form-input" type="number" name="min_km" value="250" min="0"></div>
          <div class="form-group"><label class="form-label">Badge</label><input class="form-input" name="badge" placeholder="e.g. Premium · Leave blank for none"></div>
        </div>
        <div class="form-group">
          <label class="form-label">Car Image <span style="color:var(--t4);font-weight:400">(optional · 800×300px · max 4MB · jpg/png/webp)</span></label>
          <input type="file" name="car_image" accept="image/jpg,image/jpeg,image/png,image/webp"
                 style="font-size:13px;padding:6px;width:100%;border:1.5px solid var(--border);border-radius:var(--r);background:var(--bg)">
          <div style="font-size:11px;color:var(--t4);margin-top:3px">If no image uploaded, emoji is shown instead</div>
        </div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Emoji</label><input class="form-input" name="emoji" placeholder="🚙" maxlength="5" style="text-align:center;font-size:20px"></div>
          <div class="form-group">
            <label class="form-label">Card Background Style</label>
            <select class="form-select" name="bg_class">
              <option value="fleet-innova">Dark Blue (Innova style)</option>
              <option value="fleet-creta">Warm Beige (Creta style)</option>
              <option value="fleet-ertiga">Light Green (Ertiga style)</option>
              <option value="fleet-dzire">Golden (Dzire style)</option>
            </select>
          </div>
        </div>
        <div class="form-group"><label class="form-label">Features (comma separated)</label><input class="form-input" name="features" placeholder="AC, GPS, USB Charging, Music System"></div>
        <div class="form-group"><label class="form-label">Best For</label><input class="form-input" name="best_for" placeholder="e.g. Large families, Hill stations, Long tours"></div>
        <div class="form-group"><label class="form-label">Description</label><textarea class="form-textarea" name="description" rows="3" placeholder="Short description shown on the car detail page..."></textarea></div>
      </div>
      <div class="modal__footer">
        <button type="button" class="btn btn--outline" onclick="closeModal('addCarModal')">Cancel</button>
        <button type="submit" class="btn btn--gold">➕ Add Car to Fleet</button>
      </div>
    </form>
  </div>
</div>

<form id="deleteCarForm" method="POST" style="display:none">@csrf @method('DELETE')</form>
@endsection
@push('scripts')
<script>
document.querySelectorAll('.js-track').forEach(i=>{const o=i.value;i.addEventListener('input',()=>i.classList.toggle('field-changed',i.value!==o));});
function deleteCar(id,name){
  if(!confirm(`Remove "${name}" from fleet?\nAll bookings history will remain. This cannot be undone.`))return;
  const f=document.getElementById('deleteCarForm');
  f.action=`/cms/fleet/${id}`;f.submit();
}
</script>
@endpush
