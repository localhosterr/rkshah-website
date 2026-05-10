@extends('cms.layouts.app')
@section('title','FAQ Manager')
@section('page-title','FAQ Manager')
@section('page-subtitle','All questions shown on the FAQ page — add, edit, delete freely')
@push('header-actions')
<button class="header-btn header-btn--gold" onclick="document.getElementById('addFaqModal').classList.add('open')">+ Add FAQ</button>
@endpush
@section('content')

<div class="card">
  <div class="card__body" style="padding:14px 20px">
    <div style="font-size:13px;color:var(--t3)">Total {{ $faqs->flatten()->count() }} questions across {{ $faqs->count() }} categories. Changes go live on the FAQ page instantly.</div>
  </div>
</div>

@foreach($faqs as $category => $items)
<div class="card" style="margin-bottom:16px">
  <div class="card__header">
    <div class="card__title">{{ $items->first()->category_icon }} {{ $category }}</div>
    <span style="font-size:12px;color:var(--t4)">{{ $items->count() }} questions</span>
  </div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>#</th><th>Question</th><th>Answer (preview)</th><th>Published</th><th>Actions</th></tr></thead>
      <tbody>
        @foreach($items as $faq)
        <tr>
          <td style="color:var(--t4);font-size:11px">{{ $faq->sort_order }}</td>
          <td style="font-weight:600;color:var(--t1);max-width:280px">{{ $faq->question }}</td>
          <td style="font-size:12px;color:var(--t3);max-width:320px">{{ \Str::limit($faq->answer, 100) }}</td>
          <td>
            <label class="toggle">
              <input type="checkbox" {{ $faq->is_published ? 'checked' : '' }}
                     onchange="toggleFaq({{ $faq->id }}, this.checked)">
              <span class="toggle__slider"></span>
            </label>
          </td>
          <td>
            <div style="display:flex;gap:4px">
              <button class="icon-btn" onclick="editFaq({{ $faq->id }},'{{ addslashes($faq->question) }}','{{ addslashes($faq->answer) }}','{{ $faq->category }}','{{ $faq->category_icon }}')">✏️</button>
              <button class="icon-btn icon-btn--danger" onclick="deleteFaq({{ $faq->id }})">🗑️</button>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endforeach

{{-- Add FAQ Modal --}}
<div class="modal-backdrop" id="addFaqModal">
  <div class="modal">
    <div class="modal__header"><div class="modal__title">Add New FAQ</div><button class="modal__close" onclick="closeModal('addFaqModal')">✕</button></div>
    <form action="{{ route('cms.faqs.store') }}" method="POST">
      @csrf
      <div class="modal__body">
        <div class="form-row">
          <div class="form-group"><label class="form-label">Category</label><select class="form-select" name="category"><option>Booking & Payment</option><option>Pricing & Charges</option><option>Cars & Drivers</option><option>Trips & Routes</option></select></div>
          <div class="form-group"><label class="form-label">Category Icon</label><input class="form-input" type="text" name="category_icon" placeholder="📋" maxlength="5"></div>
        </div>
        <div class="form-group"><label class="form-label">Question *</label><input class="form-input" type="text" name="question" required placeholder="Enter the question"></div>
        <div class="form-group"><label class="form-label">Answer *</label><textarea class="form-textarea" name="answer" required rows="4" placeholder="Enter the full answer"></textarea></div>
      </div>
      <div class="modal__footer"><button type="button" class="btn btn--outline" onclick="closeModal('addFaqModal')">Cancel</button><button type="submit" class="btn btn--gold">Add FAQ</button></div>
    </form>
  </div>
</div>

{{-- Edit FAQ Modal --}}
<div class="modal-backdrop" id="editFaqModal">
  <div class="modal">
    <div class="modal__header"><div class="modal__title">Edit FAQ</div><button class="modal__close" onclick="closeModal('editFaqModal')">✕</button></div>
    <form id="editFaqForm" method="POST">
      @csrf @method('PATCH')
      <div class="modal__body">
        <div class="form-group"><label class="form-label">Question</label><input class="form-input" type="text" id="editFaqQ" name="question" required></div>
        <div class="form-group"><label class="form-label">Answer</label><textarea class="form-textarea" id="editFaqA" name="answer" required rows="5"></textarea></div>
      </div>
      <div class="modal__footer"><button type="button" class="btn btn--outline" onclick="closeModal('editFaqModal')">Cancel</button><button type="submit" class="btn btn--gold">Save Changes</button></div>
    </form>
  </div>
</div>

@endsection
@push('scripts')
<script>
function toggleFaq(id, val) {
  fetch(`/cms/faqs/${id}`, {method:'PATCH',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},body:JSON.stringify({is_published:val})})
    .then(()=>showToast(val?'FAQ published':'FAQ hidden','success'));
}
function editFaq(id,q,a,cat,icon) {
  document.getElementById('editFaqQ').value=q;
  document.getElementById('editFaqA').value=a;
  document.getElementById('editFaqForm').action=`/cms/faqs/${id}`;
  document.getElementById('editFaqModal').classList.add('open');
}
function deleteFaq(id) {
  if(!confirm('Delete this FAQ? This cannot be undone.'))return;
  const f=document.createElement('form');f.method='POST';f.action=`/cms/faqs/${id}`;
  f.innerHTML=`<input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}"><input type="hidden" name="_method" value="DELETE">`;
  document.body.appendChild(f);f.submit();
}
</script>
@endpush
