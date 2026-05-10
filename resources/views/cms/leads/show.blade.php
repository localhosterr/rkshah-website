@extends('cms.layouts.app')
@section('title','Lead #'.$lead['id'])
@section('page-title','Lead #' . $lead['id'])
@section('page-subtitle',$lead['name'] . ' · ' . $lead['from_city'] . ' → ' . $lead['to_city'] . ' · ' . $lead['time_ago'])
@push('header-actions')
<a href="{{ route('cms.leads') }}" class="header-btn header-btn--outline">← Back to Leads</a>
<a href="tel:{{ $lead['phone'] }}" class="header-btn header-btn--primary">📞 Call Now</a>
<a href="https://wa.me/91{{ $lead['phone'] }}?text={{ urlencode('Namaste '.$lead['name'].' ji! Regarding your cab enquiry from '.$lead['from_city'].' to '.$lead['to_city'].'.') }}" class="header-btn header-btn--gold" target="_blank">💬 WhatsApp</a>
@endpush
@section('content')

<div class="main-side">
  {{-- Left: Lead details + Notes --}}
  <div style="display:flex;flex-direction:column;gap:16px">

    <div class="card">
      <div class="card__header"><div class="card__title">👤 Customer Details</div><span class="badge badge--{{ $lead['status'] }}">{{ ucfirst($lead['status']) }}</span></div>
      <div class="card__body">
        <div class="two-col">
          @foreach([
            ['Name',          $lead['name']],
            ['Phone',         $lead['phone']],
            ['From City',     $lead['from_city']],
            ['To City',       $lead['to_city']],
            ['Travel Date',   $lead['travel_date'] ? date('d M Y',strtotime($lead['travel_date'])) : '—'],
            ['Car Type',      $lead['car_label']],
            ['Passengers',    $lead['passengers'] ?? '—'],
            ['Source',        ucwords(str_replace('_',' ',$lead['source'] ?? 'website'))],
            ['Trip Type',     ucwords(str_replace('_',' ',$lead['trip_type'] ?? 'one_way'))],
            ['Received',      $lead['time_ago']],
          ] as $row)
          <div style="padding:11px 12px;background:var(--bg);border-radius:var(--r)">
            <div style="font-size:10px;font-family:var(--ff-h);font-weight:600;color:var(--t4);text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px">{{ $row[0] }}</div>
            <div style="font-size:14px;font-weight:600;color:var(--t1)">{{ $row[1] }}</div>
          </div>
          @endforeach
        </div>
        @if($lead['message'] ?? null)
        <div style="margin-top:12px;padding:12px;background:var(--bg);border-radius:var(--r)">
          <div style="font-size:10px;font-family:var(--ff-h);font-weight:600;color:var(--t4);text-transform:uppercase;margin-bottom:4px">Customer Message</div>
          <div style="font-size:13px;color:var(--t2);line-height:1.65">{{ $lead['message'] }}</div>
        </div>
        @endif
      </div>
    </div>

    <div class="card">
      <div class="card__header"><div class="card__title">📝 Follow-up Notes</div></div>
      <div class="card__body">
        @forelse($lead['notes'] ?? [] as $note)
        <div style="padding:12px;background:var(--bg);border-radius:var(--r);margin-bottom:8px">
          <div style="font-size:13px;color:var(--t1);margin-bottom:5px">{{ $note['text'] }}</div>
          <div style="font-size:11px;color:var(--t4)">{{ $note['author'] }} · {{ $note['time'] }}</div>
        </div>
        @empty
        <div class="empty-state" style="padding:20px"><div class="empty-state__title">No notes yet</div><div class="empty-state__desc">Add a note after calling the customer</div></div>
        @endforelse
        <form action="{{ route('cms.leads.note', $lead['id']) }}" method="POST" style="margin-top:12px">
          @csrf
          <div class="form-group">
            <label class="form-label">Add Note</label>
            <textarea class="form-textarea" name="note" rows="2" placeholder="e.g. Called customer. Interested in Innova. Confirmed date as 20 May..."></textarea>
          </div>
          <button type="submit" class="btn btn--primary btn--sm">Add Note</button>
        </form>
      </div>
    </div>

  </div>

  {{-- Right: Update form --}}
  <div style="display:flex;flex-direction:column;gap:16px">

    <div class="how-to-bar" style="margin-bottom:0">
      <span style="font-size:18px">💡</span>
      <div>
        <div class="how-to-bar__title" style="font-size:12px">Current values pre-filled</div>
        <div class="how-to-bar__text" style="font-size:11px">Edit what you need and save. Changed fields turn green.</div>
      </div>
    </div>

    <div class="card">
      <div class="card__header"><div class="card__title">✏️ Update Lead</div></div>
      <div class="card__body">
        <form action="{{ route('cms.leads.update', $lead['id']) }}" method="POST">
          @csrf @method('PATCH')

          <div class="form-group">
            <label class="form-label">Status</label>
            <select class="form-select js-track" name="status">
              @foreach(['new','contacted','quoted','confirmed','completed','cancelled'] as $s)
              <option value="{{ $s }}" {{ $lead['status']===$s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
              @endforeach
            </select>
            <div class="current-val">📍 Currently: <strong>{{ ucfirst($lead['status']) }}</strong></div>
          </div>

          <div class="form-group">
            <label class="form-label">Estimated Fare (₹)</label>
            <input class="form-input js-track" type="number" name="estimated_fare"
                   value="{{ $lead['estimated_fare'] ?? '' }}"
                   placeholder="e.g. 3500" min="0">
            <div class="current-val">📍 Currently: <strong>{{ $lead['estimated_fare'] ? '₹'.number_format($lead['estimated_fare']) : 'Not quoted yet' }}</strong></div>
          </div>

          <div class="form-group">
            <label class="form-label">Follow-up Date & Time</label>
            <input class="form-input js-track" type="datetime-local" name="follow_up_at"
                   value="{{ $lead['follow_up_at'] ?? '' }}">
            <div class="current-val">📍 Currently: <strong>{{ $lead['follow_up_at'] ? date('d M Y H:i',strtotime($lead['follow_up_at'])) : 'No follow-up set' }}</strong></div>
          </div>

          <button type="submit" class="btn btn--primary btn--full">💾 Update Lead</button>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card__header"><div class="card__title">🚀 Actions</div></div>
      <div class="card__body" style="display:flex;flex-direction:column;gap:8px">
        <a href="{{ route('cms.bookings.create', ['lead_id'=>$lead['id']]) }}"
           class="btn btn--gold btn--full">📅 Convert to Booking</a>
        <a href="tel:{{ $lead['phone'] }}" class="btn btn--primary btn--full">📞 Call {{ $lead['phone'] }}</a>
        <a href="https://wa.me/91{{ $lead['phone'] }}?text={{ urlencode('Namaste '.$lead['name'].' ji! Regarding your '.$lead['from_city'].' to '.$lead['to_city'].' cab enquiry. Please confirm your travel date so we can arrange your cab. — RK Shah +91 93245 55165') }}"
           class="btn btn--success btn--full" target="_blank">💬 WhatsApp Quote Message</a>
      </div>
    </div>

  </div>
</div>
@endsection
@push('scripts')<script>document.querySelectorAll('.js-track').forEach(i=>{const o=i.value;i.addEventListener('input',()=>{i.value.trim()!==''&&i.value!==o?i.classList.add('field-changed'):i.classList.remove('field-changed');});});document.querySelectorAll('select.js-track').forEach(s=>{const o=s.value;s.addEventListener('change',()=>{s.value!==o?s.classList.add('field-changed'):s.classList.remove('field-changed');});});</script>@endpush
