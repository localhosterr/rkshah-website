@extends('cms.layouts.app')
@section('title','Dashboard')
@section('page-title','Dashboard')
@section('page-subtitle','Welcome back, RK Shah · ' . date('l, d F Y'))

@push('header-actions')
<a href="{{ route('home') }}" target="_blank" class="header-btn header-btn--outline">🌐 View Site</a>
@endpush

@section('content')

{{-- ── STAT CARDS ── --}}
<div class="stats-grid">
  <div class="stat-card stat-card--blue">
    <div class="stat-card__icon">📋</div>
    <div class="stat-card__label">Total Leads</div>
    <div class="stat-card__value">{{ $stats['total_leads'] }}</div>
    <div class="stat-card__change stat-card__change--up">+{{ $stats['new_today'] }} today</div>
  </div>
  <div class="stat-card stat-card--green">
    <div class="stat-card__icon">✅</div>
    <div class="stat-card__label">Confirmed Trips</div>
    <div class="stat-card__value">{{ $stats['confirmed'] }}</div>
    <div class="stat-card__change stat-card__change--up">This month</div>
  </div>
  <div class="stat-card stat-card--gold">
    <div class="stat-card__icon">💰</div>
    <div class="stat-card__label">Est. Revenue</div>
    <div class="stat-card__value">₹{{ number_format($stats['revenue']) }}</div>
    <div class="stat-card__change stat-card__change--up">This month</div>
  </div>
  <div class="stat-card stat-card--purple">
    <div class="stat-card__icon">⭐</div>
    <div class="stat-card__label">Google Rating</div>
    <div class="stat-card__value">4.9★</div>
    <div class="stat-card__change stat-card__change--up">180+ reviews</div>
  </div>
</div>

{{-- ── LEAD PIPELINE ── --}}
<div class="card" style="margin-bottom:16px">
  <div class="card__header">
    <div class="card__title">📊 Lead Pipeline</div>
    <a href="{{ route('cms.leads') }}" class="btn btn--sm btn--outline">View All</a>
  </div>
  <div class="card__body">
    <div class="pipeline">
      @foreach($pipeline as $stage)
      <div class="pipeline-col">
        <div class="pipeline-col__head" style="background:{{ $stage['color'] }}20;color:{{ $stage['color'] }}">
          <span>{{ $stage['label'] }}</span>
          <span class="pipeline-col__count">{{ count($stage['leads']) }}</span>
        </div>
        <div class="pipeline-col__body">
          @forelse($stage['leads'] as $lead)
          <div class="pipeline-card" onclick="openLeadModal({{ $lead['id'] }})">
            <div class="pipeline-card__name">{{ $lead['name'] }}</div>
            <div class="pipeline-card__route">{{ $lead['from_city'] }} → {{ $lead['to_city'] }}</div>
            <div class="pipeline-card__meta">
              <span class="pipeline-card__phone">📞 {{ $lead['phone'] }}</span>
              <span class="pipeline-card__date">{{ $lead['time_ago'] }}</span>
            </div>
          </div>
          @empty
          <div style="text-align:center;padding:16px;font-size:11px;color:var(--t4)">No leads</div>
          @endforelse
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

{{-- ── MAIN + SIDE ── --}}
<div class="main-side">

  {{-- Recent Leads Table --}}
  <div class="card">
    <div class="card__header">
      <div class="card__title">🆕 Recent Leads</div>
      <div style="display:flex;gap:8px">
        <a href="{{ route('cms.leads') }}" class="btn btn--sm btn--outline">View All →</a>
      </div>
    </div>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Customer</th>
            <th>Route</th>
            <th>Car</th>
            <th>Status</th>
            <th>Time</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($recentLeads as $lead)
          <tr>
            <td>
              <div style="font-weight:600;color:var(--t1)">{{ $lead['name'] }}</div>
              <div style="font-size:11px;color:var(--t4)">{{ $lead['phone'] }}</div>
            </td>
            <td>
              <div style="font-size:12px;font-weight:600">{{ $lead['from_city'] }} → {{ $lead['to_city'] }}</div>
            </td>
            <td>
              <span style="font-size:11px;color:var(--t3)">{{ str_replace('_',' ',ucwords($lead['car_type'],'_')) }}</span>
            </td>
            <td>
              <span class="badge badge--{{ $lead['status'] }}">{{ ucfirst($lead['status']) }}</span>
            </td>
            <td><span style="font-size:11px;color:var(--t4)">{{ $lead['time_ago'] }}</span></td>
            <td>
              <div style="display:flex;gap:4px">
                <a href="tel:{{ $lead['phone'] }}" class="icon-btn icon-btn--success" title="Call">📞</a>
                <a href="https://wa.me/91{{ $lead['phone'] }}" class="icon-btn" title="WhatsApp" target="_blank">💬</a>
                <a href="{{ route('cms.leads.show', $lead['id']) }}" class="icon-btn" title="View">👁️</a>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="6"><div class="empty-state"><div class="empty-state__icon">📭</div><div class="empty-state__title">No leads yet</div></div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Sidebar widgets --}}
  <div style="display:flex;flex-direction:column;gap:16px">

    {{-- Live Activity --}}
    <div class="card">
      <div class="card__header">
        <div class="card__title">⚡ Live Activity</div>
        <div style="width:8px;height:8px;border-radius:50%;background:var(--green);animation:pulse 2s infinite"></div>
      </div>
      <div class="card__body" style="padding:0 20px">
        @foreach($activity as $item)
        <div class="activity-item">
          <div class="activity-dot activity-dot--{{ $item['type'] }}">{{ $item['icon'] }}</div>
          <div class="activity-content">
            <div class="activity-content__title">{{ $item['title'] }}</div>
            <div class="activity-content__meta">{{ $item['meta'] }} · {{ $item['time'] }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    {{-- Quick Stats --}}
    <div class="card">
      <div class="card__header"><div class="card__title">📈 This Month</div></div>
      <div class="card__body" style="padding:16px 20px">
        @foreach([
          ['label'=>'New Leads',   'value'=>$stats['total_leads'],  'bar'=>70, 'color'=>'var(--blue)'],
          ['label'=>'Confirmed',   'value'=>$stats['confirmed'],     'bar'=>45, 'color'=>'var(--green)'],
          ['label'=>'Completed',   'value'=>$stats['completed'],     'bar'=>30, 'color'=>'var(--navy)'],
          ['label'=>'Cancelled',   'value'=>$stats['cancelled'],     'bar'=>10, 'color'=>'var(--red)'],
        ] as $row)
        <div class="chart-bar-row">
          <div class="chart-bar-label">{{ $row['label'] }}</div>
          <div class="chart-bar-track">
            <div class="chart-bar-fill" style="width:{{ $row['bar'] }}%;background:{{ $row['color'] }}"></div>
          </div>
          <div class="chart-bar-val">{{ $row['value'] }}</div>
        </div>
        @endforeach
      </div>
    </div>

    {{-- Quick Actions --}}
    <div class="card">
      <div class="card__header"><div class="card__title">⚡ Quick Actions</div></div>
      <div class="card__body" style="display:flex;flex-direction:column;gap:8px">
        <a href="{{ route('cms.leads') }}" class="btn btn--primary btn--full">📋 View All Leads</a>
        <a href="{{ route('cms.bookings.create') }}" class="btn btn--gold btn--full">📅 New Booking</a>
        <a href="{{ route('cms.blog.create') }}" class="btn btn--outline btn--full">✍️ Write Blog Post</a>
      </div>
    </div>

  </div>
</div>

@endsection
