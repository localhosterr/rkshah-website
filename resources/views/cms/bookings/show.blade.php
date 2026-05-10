@extends('cms.layouts.app')
@section('title','Booking '.$booking['ref'])
@section('page-title',$booking['ref'])
@section('page-subtitle',$booking['name'].' · '.$booking['from'].' → '.$booking['to'])
@push('header-actions')
<a href="{{ route('cms.bookings') }}" class="header-btn header-btn--outline">← Back</a>
<a href="tel:{{ $booking['phone'] }}" class="header-btn header-btn--primary">📞 Call</a>
@endpush
@section('content')
<div class="main-side">
  <div class="card">
    <div class="card__header"><div class="card__title">📋 Booking Details</div><span class="badge badge--{{ $booking['status'] }}">{{ ucfirst($booking['status']) }}</span></div>
    <div class="card__body">
      <div class="two-col">
        @foreach([['Booking Ref',$booking['ref']],['Customer',$booking['name']],['Phone',$booking['phone']],['Route',$booking['from'].' → '.$booking['to']],['Travel Date',$booking['travel_date']],['Pickup Time',$booking['pickup_time'] ?? '—'],['Car',$booking['car']],['Driver',$booking['driver'] ?? 'Not assigned'],['Passengers',$booking['passengers'] ?? '—'],['Trip Type',ucfirst($booking['trip_type'] ?? 'one_way')],['Total Fare','₹'.number_format($booking['fare'])],['Advance Paid','₹'.number_format($booking['advance'])],['Balance Due','₹'.number_format($booking['fare']-$booking['advance'])],['Payment Method',ucfirst($booking['advance_method'] ?? 'Cash')]] as $row)
        <div style="padding:10px;background:var(--bg);border-radius:var(--r)">
          <div style="font-size:9px;font-family:var(--ff-h);font-weight:600;color:var(--t4);text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px">{{ $row[0] }}</div>
          <div style="font-size:13px;font-weight:600;color:var(--t1)">{{ $row[1] }}</div>
        </div>
        @endforeach
      </div>
      @if($booking['notes'] ?? null)
      <div style="margin-top:14px;padding:12px;background:var(--bg);border-radius:var(--r)">
        <div style="font-size:10px;font-family:var(--ff-h);font-weight:600;color:var(--t4);text-transform:uppercase;margin-bottom:4px">Notes</div>
        <div style="font-size:13px;color:var(--t2)">{{ $booking['notes'] }}</div>
      </div>
      @endif
    </div>
  </div>
  <div style="display:flex;flex-direction:column;gap:16px">
    <div class="card">
      <div class="card__header"><div class="card__title">Update Status</div></div>
      <div class="card__body">
        <form action="{{ route('cms.bookings.update',$booking['id']) }}" method="POST">
          @csrf @method('PATCH')
          <div class="form-group">
            <label class="form-label">Status</label>
            <select class="form-select" name="status">
              @foreach(['pending','confirmed','in_progress','completed','cancelled'] as $s)
              <option value="{{ $s }}" {{ $booking['status']===$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group"><label class="form-label">Assign Driver</label><input class="form-input" name="driver" value="{{ $booking['driver'] ?? '' }}" placeholder="Driver name"></div>
          <div class="form-group"><label class="form-label">Notes</label><textarea class="form-textarea" name="notes" rows="2">{{ $booking['notes'] ?? '' }}</textarea></div>
          <button type="submit" class="btn btn--primary btn--full">💾 Update Booking</button>
        </form>
      </div>
    </div>
    <div class="card">
      <div class="card__header"><div class="card__title">Actions</div></div>
      <div class="card__body" style="display:flex;flex-direction:column;gap:8px">
        <a href="tel:{{ $booking['phone'] }}" class="btn btn--primary btn--full">📞 Call Customer</a>
        <a href="https://wa.me/91{{ $booking['phone'] }}?text={{ urlencode('Dear '.$booking['name'].' ji, Your trip '.$booking['from'].' → '.$booking['to'].' is confirmed for '.$booking['travel_date'].'. Driver will contact you soon. — RK Shah') }}" class="btn btn--success btn--full" target="_blank">💬 WhatsApp Confirmation</a>
      </div>
    </div>
  </div>
</div>
@endsection
