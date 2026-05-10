@extends('cms.layouts.app')
@section('title','New Booking')
@section('page-title','Create New Booking')
@section('page-subtitle','Convert a lead to a confirmed booking')
@push('header-actions')
<a href="{{ route('cms.bookings') }}" class="header-btn header-btn--outline">← Cancel</a>
<button form="bookingForm" class="header-btn header-btn--gold">📅 Confirm Booking</button>
@endpush
@section('content')

<div style="max-width:720px">

  @if($lead)
  <div style="background:var(--blue-bg);border:1px solid #BFDBFE;border-radius:var(--r2);padding:14px 18px;margin-bottom:16px;display:flex;align-items:center;gap:10px">
    <span style="font-size:18px">📋</span>
    <div>
      <div style="font-family:var(--ff-h);font-size:13px;font-weight:700;color:#1E40AF">Converting Lead #{{ $lead->id }}</div>
      <div style="font-size:12px;color:#1D4ED8">{{ $lead->name }} · {{ $lead->phone }} · {{ $lead->from_city }} → {{ $lead->to_city }}</div>
    </div>
  </div>
  @endif

  <div class="card">
    <div class="card__header"><div class="card__title">📅 Booking Details</div></div>
    <div class="card__body">
      <form id="bookingForm" action="{{ route('cms.bookings.store') }}" method="POST">
        @csrf
        @if($lead)
        <input type="hidden" name="lead_id" value="{{ $lead->id }}">
        @endif

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Customer Name *</label>
            <input class="form-input" name="customer_name" required
                   placeholder="Rajesh Sharma"
                   value="{{ $lead?->name ?? '' }}">
          </div>
          <div class="form-group">
            <label class="form-label">Phone Number *</label>
            <input class="form-input" name="customer_phone" required
                   pattern="[6-9][0-9]{9}" placeholder="98765 43210"
                   value="{{ $lead?->phone ?? '' }}">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">From City *</label>
            <input class="form-input" name="from_city" required
                   value="{{ $lead?->from_city ?? 'Delhi' }}">
          </div>
          <div class="form-group">
            <label class="form-label">To City *</label>
            <input class="form-input" name="to_city" required
                   placeholder="Agra, Jaipur..."
                   value="{{ $lead?->to_city ?? '' }}">
          </div>
        </div>

        <div class="form-row form-row--3">
          <div class="form-group">
            <label class="form-label">Travel Date *</label>
            <input class="form-input" type="date" name="travel_date" required
                   value="{{ $lead?->travel_date?->format('Y-m-d') ?? '' }}">
          </div>
          <div class="form-group">
            <label class="form-label">Pickup Time</label>
            <input class="form-input" type="time" name="pickup_time">
          </div>
          <div class="form-group">
            <label class="form-label">Trip Type</label>
            <select class="form-select" name="trip_type">
              <option value="one_way"    {{ ($lead?->trip_type ?? 'one_way') === 'one_way'    ? 'selected' : '' }}>One Way</option>
              <option value="round_trip" {{ ($lead?->trip_type ?? '') === 'round_trip' ? 'selected' : '' }}>Round Trip</option>
              <option value="airport"    {{ ($lead?->trip_type ?? '') === 'airport'    ? 'selected' : '' }}>Airport</option>
              <option value="hourly"     {{ ($lead?->trip_type ?? '') === 'hourly'     ? 'selected' : '' }}>Hourly</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Car Type *</label>
            {{-- name="car_type" sends the enum value directly to bookingStore --}}
            <select class="form-select" name="car_type" required>
              <option value="">Select car...</option>
              @foreach($cars as $car)
              <option value="{{ $car->slug === 'innova-crysta' ? 'innova_crysta' : ($car->slug === 'kia-creta' ? 'kia_creta' : str_replace('-','_',$car->slug)) }}"
                      {{ ($lead?->car_type ?? '') === ($car->slug === 'innova-crysta' ? 'innova_crysta' : ($car->slug === 'kia-creta' ? 'kia_creta' : str_replace('-','_',$car->slug))) ? 'selected' : '' }}>
                {{ $car->name }} — Starting ₹{{ $car->rate_per_km }}/km
              </option>
              @endforeach
            </select>
            @if($lead?->car_type)
            <div class="current-val">📍 Lead requested: <strong>{{ $lead->car_label }}</strong></div>
            @endif
          </div>
          <div class="form-group">
            <label class="form-label">Driver Name</label>
            <input class="form-input" name="driver_name" placeholder="Assign driver...">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Driver Phone</label>
            <input class="form-input" name="driver_phone" placeholder="Driver phone number">
          </div>
          <div class="form-group">
            <label class="form-label">Passengers</label>
            <input class="form-input" type="number" name="passengers"
                   min="1" max="20" placeholder="4"
                   value="{{ $lead?->passengers ?? '' }}">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Total Fare (₹) *</label>
            <input class="form-input" type="number" name="total_fare" required
                   placeholder="3500" min="0"
                   value="{{ $lead?->estimated_fare ?? '' }}">
            @if($lead?->estimated_fare)
            <div class="current-val">📍 Lead estimate: <strong>₹{{ number_format($lead->estimated_fare) }}</strong></div>
            @endif
          </div>
          <div class="form-group">
            <label class="form-label">Advance Paid (₹)</label>
            <input class="form-input" type="number" name="advance_paid" value="0" min="0">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Advance Payment Method</label>
          <select class="form-select" name="advance_method">
            <option value="upi">UPI (PhonePe / GPay / Paytm)</option>
            <option value="cash">Cash</option>
            <option value="bank_transfer">Bank Transfer</option>
            <option value="card">Card</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Notes</label>
          <textarea class="form-textarea" name="notes" rows="2"
                    placeholder="Any special requirements, drop location, etc..."></textarea>
        </div>

        <button type="submit" class="btn btn--gold btn--full" style="padding:14px;font-size:14px">
          📅 Confirm Booking
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
