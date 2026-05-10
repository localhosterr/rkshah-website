@extends('cms.layouts.app')
@section('title','Trip Calendar')
@section('page-title','Trip Calendar')
@section('page-subtitle',date('F Y'))
@section('content')
<div class="card">
  <div class="card__header">
    <div style="display:flex;align-items:center;gap:12px">
      <a href="?month={{ $prevMonth }}" class="btn btn--sm btn--outline">← Prev</a>
      <div class="card__title">{{ date('F Y', strtotime($currentMonth)) }}</div>
      <a href="?month={{ $nextMonth }}" class="btn btn--sm btn--outline">Next →</a>
    </div>
    <div style="display:flex;gap:8px;align-items:center;font-size:12px;color:var(--t3)">
      <span style="background:var(--gold-dim);border-radius:3px;padding:2px 8px;color:#92400E;font-family:var(--ff-h);font-weight:600">Outstation</span>
      <span style="background:var(--blue-bg);border-radius:3px;padding:2px 8px;color:#1D4ED8;font-family:var(--ff-h);font-weight:600">Airport</span>
      <span style="background:var(--green-bg);border-radius:3px;padding:2px 8px;color:#065F46;font-family:var(--ff-h);font-weight:600">Local</span>
    </div>
  </div>
  <div class="card__body">
    <div class="cal-grid">
      @foreach(['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $d)
      <div class="cal-day-head">{{ $d }}</div>
      @endforeach
      @for($i = 0; $i < $startOffset; $i++)
      <div class="cal-day cal-day--other"></div>
      @endfor
      @for($day = 1; $day <= $daysInMonth; $day++)
      <div class="cal-day {{ $day == date('j') && date('Y-m') == date('Y-m', strtotime($currentMonth)) ? 'cal-day--today' : '' }}">
        <div class="cal-day__num">{{ $day }}</div>
        @foreach($calendar[$day] ?? [] as $trip)
        <div class="cal-trip cal-trip--{{ $trip['type'] }}" title="{{ $trip['label'] }}">{{ $trip['label'] }}</div>
        @endforeach
      </div>
      @endfor
    </div>
  </div>
</div>
@endsection
