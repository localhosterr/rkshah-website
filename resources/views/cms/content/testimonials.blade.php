@extends('cms.layouts.app')
@section('title','Testimonials')
@section('page-title','Testimonials Manager')
@section('page-subtitle','Add, publish, and remove customer reviews shown on homepage')
@push('header-actions')
<button class="header-btn header-btn--gold" onclick="document.getElementById('addReviewModal').classList.add('open')">+ Add Review</button>
@endpush
@section('content')
<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Customer</th><th>Rating</th><th>Review</th><th>Route</th><th>Car</th><th>Source</th><th>Published</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($testimonials as $t)
        <tr>
          <td><div style="font-weight:600;color:var(--t1)">{{ $t->customer_name }}</div><div style="font-size:11px;color:var(--t4)">{{ $t->initials }}</div></td>
          <td style="color:#F59E0B">{{ str_repeat('★',$t->rating) }}</td>
          <td style="font-size:12px;color:var(--t3);max-width:260px">{{ \Str::limit($t->review_text,90) }}</td>
          <td style="font-size:12px;color:var(--t3)">{{ $t->trip_route ?? '—' }}</td>
          <td style="font-size:12px;color:var(--t3)">{{ $t->car_used ?? '—' }}</td>
          <td><span style="font-size:11px;background:var(--bg);padding:2px 8px;border-radius:10px">{{ $t->source }}</span></td>
          <td><label class="toggle"><input type="checkbox" {{ $t->is_published?'checked':'' }} onchange="toggleTestimonial({{ $t->id }},this.checked)"><span class="toggle__slider"></span></label></td>
          <td>
            <form action="{{ route('cms.testimonials.delete',$t->id) }}" method="POST" onsubmit="return confirm('Delete this review?')">
              @csrf @method('DELETE')
              <button type="submit" class="icon-btn icon-btn--danger">🗑️</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="8"><div class="empty-state"><div class="empty-state__icon">⭐</div><div class="empty-state__title">No reviews yet</div></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="modal-backdrop" id="addReviewModal">
  <div class="modal">
    <div class="modal__header"><div class="modal__title">Add Customer Review</div><button class="modal__close" onclick="closeModal('addReviewModal')">✕</button></div>
    <form action="{{ route('cms.testimonials.store') }}" method="POST">
      @csrf
      <div class="modal__body">
        <div class="form-row">
          <div class="form-group"><label class="form-label">Customer Name *</label><input class="form-input" type="text" name="customer_name" required></div>
          <div class="form-group"><label class="form-label">Rating *</label><select class="form-select" name="rating"><option value="5">★★★★★ (5)</option><option value="4">★★★★ (4)</option><option value="3">★★★ (3)</option></select></div>
        </div>
        <div class="form-group"><label class="form-label">Review Text *</label><textarea class="form-textarea" name="review_text" required rows="4" placeholder="What did the customer say?"></textarea></div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Trip Route</label><input class="form-input" type="text" name="trip_route" placeholder="Delhi → Agra"></div>
          <div class="form-group"><label class="form-label">Car Used</label><input class="form-input" type="text" name="car_used" placeholder="Innova Crysta"></div>
        </div>
        <div class="form-group"><label class="form-label">Source</label><select class="form-select" name="source"><option>Google Review</option><option>WhatsApp Review</option><option>Direct</option></select></div>
      </div>
      <div class="modal__footer"><button type="button" class="btn btn--outline" onclick="closeModal('addReviewModal')">Cancel</button><button type="submit" class="btn btn--gold">Add Review</button></div>
    </form>
  </div>
</div>
@endsection
@push('scripts')
<script>
function toggleTestimonial(id,val){fetch(`/cms/testimonials/${id}`,{method:'PATCH',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},body:JSON.stringify({is_published:val})}).then(()=>showToast(val?'Review published':'Review hidden','success'));}
</script>
@endpush
