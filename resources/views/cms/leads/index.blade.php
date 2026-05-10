@extends('cms.layouts.app')
@section('title','Leads & Enquiries')
@section('page-title','Leads & Enquiries')
@section('page-subtitle','Manage all customer enquiries and booking requests')

@push('header-actions')
<button class="header-btn header-btn--outline" onclick="exportLeads()">⬇️ Export CSV</button>
@endpush

@section('content')

{{-- ── FILTERS ── --}}
<div class="card" style="margin-bottom:16px">
  <div class="card__body" style="padding:14px 20px">
    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
      <div class="search-bar" style="flex:1;min-width:220px">
        <span class="search-bar__icon">🔍</span>
        <input type="text" id="leadSearch" placeholder="Search by name, phone, route..." oninput="filterLeads()">
      </div>
      <div class="filter-row" style="margin:0">
        @foreach(['all'=>'All','new'=>'New','contacted'=>'Contacted','quoted'=>'Quoted','confirmed'=>'Confirmed','completed'=>'Completed','cancelled'=>'Cancelled'] as $val=>$label)
        <button class="filter-chip {{ $currentStatus === $val ? 'active' : '' }}"
                onclick="setFilter('{{ $val }}')">{{ $label }}</button>
        @endforeach
      </div>
      <form method="GET" id="filterForm" style="display:none">
        <input type="hidden" name="status" id="filterStatus" value="{{ $currentStatus }}">
      </form>
    </div>
  </div>
</div>

{{-- ── LEADS TABLE ── --}}
<div class="card">
  <div class="card__header">
    <div class="card__title">
      📋 Leads
      <span style="font-size:12px;font-weight:400;color:var(--t4);margin-left:6px">{{ $total }} total</span>
    </div>
    <div style="font-size:12px;color:var(--t4)">Page {{ $page }} of {{ $totalPages }}</div>
  </div>
  <div class="table-wrap">
    <table id="leadsTable">
      <thead>
        <tr>
          <th>#</th>
          <th>Customer</th>
          <th>Route</th>
          <th>Car</th>
          <th>Date</th>
          <th>Source</th>
          <th>Status</th>
          <th>Fare</th>
          <th style="width:130px">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($leads as $lead)
        <tr>
          <td style="color:var(--t4);font-size:12px">#{{ $lead['id'] }}</td>
          <td>
            <div style="font-weight:600;color:var(--t1)">{{ $lead['name'] }}</div>
            <div style="font-size:11px;color:var(--t4)">{{ $lead['phone'] }}</div>
          </td>
          <td>
            <div style="font-size:13px;font-weight:600;color:var(--t1)">{{ $lead['from_city'] }} → {{ $lead['to_city'] }}</div>
            @if($lead['travel_date'])
            <div style="font-size:11px;color:var(--t4)">📅 {{ date('d M Y', strtotime($lead['travel_date'])) }}</div>
            @endif
          </td>
          <td>
            <span style="font-size:11px;background:var(--bg);padding:3px 8px;border-radius:20px;color:var(--t3)">
              {{ str_replace('_',' ',ucwords($lead['car_type'] ?? 'Any','_')) }}
            </span>
          </td>
          <td style="font-size:12px;color:var(--t3)">{{ $lead['time_ago'] }}</td>
          <td>
            <span style="font-size:11px;text-transform:capitalize;color:var(--t3)">
              {{ str_replace('_',' ',$lead['source'] ?? 'website') }}
            </span>
          </td>
          <td>
            <select class="status-select" data-id="{{ $lead['id'] }}"
                    onchange="updateStatus({{ $lead['id'] }}, this.value)"
                    style="background:none;border:none;outline:none;font-family:var(--ff-h);font-size:11px;font-weight:600;cursor:pointer;color:var(--t2)">
              @foreach(['new','contacted','quoted','confirmed','completed','cancelled'] as $s)
              <option value="{{ $s }}" {{ ($lead['status']===$s)?'selected':'' }}>{{ ucfirst($s) }}</option>
              @endforeach
            </select>
          </td>
          <td>
            @if($lead['estimated_fare'])
            <span style="font-family:var(--ff-h);font-size:13px;font-weight:700;color:var(--navy)">
              ₹{{ number_format($lead['estimated_fare']) }}
            </span>
            @else
            <span style="font-size:12px;color:var(--t4)">—</span>
            @endif
          </td>
          <td>
            <div style="display:flex;gap:4px">
              <a href="tel:{{ $lead['phone'] }}" class="icon-btn icon-btn--success" title="Call">📞</a>
              <a href="https://wa.me/91{{ $lead['phone'] }}?text={{ urlencode('Namaste '.$lead['name'].' ji! Your quote for '.$lead['from_city'].' → '.$lead['to_city'].'. Please call us for details. — RK Shah +91 93245 55165') }}"
                 class="icon-btn" title="WhatsApp" target="_blank">💬</a>
              <a href="{{ route('cms.leads.show', $lead['id']) }}" class="icon-btn" title="View Details">👁️</a>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9">
            <div class="empty-state">
              <div class="empty-state__icon">📭</div>
              <div class="empty-state__title">No leads found</div>
              <div class="empty-state__desc">New leads will appear here when customers submit the booking form</div>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if($totalPages > 1)
  <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border)">
    <span style="font-size:12px;color:var(--t4)">Showing {{ ($page-1)*20+1 }}–{{ min($page*20,$total) }} of {{ $total }}</span>
    <div style="display:flex;gap:6px">
      @if($page > 1)
      <a href="?page={{ $page-1 }}&status={{ $currentStatus }}" class="btn btn--sm btn--outline">← Prev</a>
      @endif
      @for($p=max(1,$page-2); $p<=min($totalPages,$page+2); $p++)
      <a href="?page={{ $p }}&status={{ $currentStatus }}"
         class="btn btn--sm {{ $p===$page ? 'btn--primary' : 'btn--outline' }}">{{ $p }}</a>
      @endfor
      @if($page < $totalPages)
      <a href="?page={{ $page+1 }}&status={{ $currentStatus }}" class="btn btn--sm btn--outline">Next →</a>
      @endif
    </div>
  </div>
  @endif
</div>

@endsection

@push('scripts')
<script>
function setFilter(val) {
  document.getElementById('filterStatus').value = val;
  document.getElementById('filterForm').submit();
}
function filterLeads() {
  const q = document.getElementById('leadSearch').value.toLowerCase();
  document.querySelectorAll('#leadsTable tbody tr').forEach(row => {
    row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
  });
}
function updateStatus(id, status) {
  fetch(`/cms/leads/${id}/status`, {
    method: 'PATCH',
    headers: {'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},
    body: JSON.stringify({status})
  }).then(() => showToast('Status updated to ' + status, 'success'))
    .catch(() => showToast('Update failed', 'error'));
}
function exportLeads() { window.location = '/cms/leads/export'; }
</script>
@endpush
