@extends('cms.layouts.app')
@section('title','Bookings')
@section('page-title','Bookings')
@section('page-subtitle','All confirmed and upcoming trips')

@push('header-actions')
<a href="{{ route('cms.bookings.create') }}" class="header-btn header-btn--gold">+ New Booking</a>
@endpush

@section('content')

{{-- Status filter --}}
<div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px;align-items:center">
  @foreach(['all'=>'All','pending'=>'Pending','confirmed'=>'Confirmed','in_progress'=>'In Progress','completed'=>'Completed','cancelled'=>'Cancelled'] as $val=>$label)
  <a href="{{ route('cms.bookings', ['status'=>$val]) }}"
     style="padding:7px 14px;border-radius:20px;font-size:12px;font-weight:600;font-family:var(--ff-h);border:1.5px solid;text-decoration:none;
            border-color:{{ ($status??'all')===$val?'var(--navy)':'var(--border2)' }};
            background:{{ ($status??'all')===$val?'var(--navy)':'white' }};
            color:{{ ($status??'all')===$val?'white':'var(--t3)' }}">
    {{ $label }}
  </a>
  @endforeach
  <span style="margin-left:auto;font-size:12px;color:var(--t4)">{{ count($bookings) }} booking(s)</span>
</div>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Ref</th>
          <th>Customer</th>
          <th>Route</th>
          <th>Date</th>
          <th>Car</th>
          <th>Driver</th>
          <th>Fare</th>
          <th>Advance</th>
          <th>Balance</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($bookings as $b)
        <tr>
          <td>
            <span style="font-family:var(--ff-h);font-size:12px;font-weight:700;color:var(--navy)">
              {{ $b['ref'] }}
            </span>
          </td>
          <td>
            <div style="font-weight:600;color:var(--t1)">{{ $b['name'] }}</div>
            <div style="font-size:11px;color:var(--t4)">{{ $b['phone'] }}</div>
          </td>
          <td>
            <div style="font-size:12px;font-weight:600;color:var(--t1)">{{ $b['from'] }} → {{ $b['to'] }}</div>
          </td>
          <td style="font-size:12px;color:var(--t3);white-space:nowrap">{{ $b['travel_date'] }}</td>
          <td style="font-size:12px;color:var(--t3)">{{ $b['car'] }}</td>
          <td style="font-size:12px;color:var(--t3)">{{ $b['driver'] ?? '—' }}</td>
          <td>
            <span style="font-family:var(--ff-h);font-size:13px;font-weight:700;color:var(--t1)">
              ₹{{ number_format($b['fare']) }}
            </span>
          </td>
          <td style="font-size:12px;color:var(--green)">
            ₹{{ number_format($b['advance']) }}
          </td>
          <td>
            @php $balance = $b['fare'] - $b['advance']; @endphp
            <span style="font-size:12px;color:{{ $balance > 0 ? 'var(--red)' : 'var(--green)' }};font-weight:600">
              {{ $balance > 0 ? '₹'.number_format($balance).' due' : '✅ Paid' }}
            </span>
          </td>
          <td>
            <span class="badge badge--{{ $b['status'] }}">
              {{ ucfirst(str_replace('_',' ',$b['status'])) }}
            </span>
          </td>
          <td>
            <div style="display:flex;gap:4px">
              <a href="tel:{{ $b['phone'] }}" class="icon-btn icon-btn--success" title="Call">📞</a>
              <a href="{{ route('cms.bookings.show', $b['id']) }}" class="icon-btn" title="View">👁️</a>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="11">
            <div class="empty-state">
              <div class="empty-state__icon">📅</div>
              <div class="empty-state__title">No bookings found</div>
              <div class="empty-state__desc">
                Create a booking from a lead or click "+ New Booking" above
              </div>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
