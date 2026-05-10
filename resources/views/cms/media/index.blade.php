@extends('cms.layouts.app')
@section('title','Media Library')
@section('page-title','Media Library')
@section('page-subtitle','Upload and manage images')
@push('header-actions')
<button class="header-btn header-btn--gold" onclick="document.getElementById('uploadInput').click()">⬆️ Upload Images</button>
<input type="file" id="uploadInput" multiple accept="image/*" style="display:none" onchange="handleUpload(this)">
@endpush
@section('content')
<div class="card" style="margin-bottom:16px">
  <div class="card__body" style="padding:14px 20px">
    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
      <div class="search-bar" style="flex:1;min-width:200px"><span class="search-bar__icon">🔍</span><input type="text" placeholder="Search images..."></div>
      <div class="filter-row" style="margin:0">
        @foreach(['All','Fleet','Routes','Blog','General'] as $folder)
        <button class="filter-chip {{ $folder==='All' ? 'active' : '' }}">{{ $folder }}</button>
        @endforeach
      </div>
    </div>
  </div>
</div>
<div class="card">
  <div class="card__header">
    <div class="card__title">🖼️ {{ count($media) }} Images</div>
    <span style="font-size:12px;color:var(--t4)">Click to copy URL · Select multiple for bulk actions</span>
  </div>
  <div class="card__body">
    <div class="media-grid">
      @forelse($media as $item)
      <div class="media-item" onclick="selectMedia('{{ $item['url'] }}')" title="{{ $item['name'] }}">
        <div class="media-item__check">✓</div>
        @if(in_array(pathinfo($item['name'],PATHINFO_EXTENSION),['jpg','jpeg','png','webp']))
        <img src="{{ $item['url'] }}" alt="{{ $item['name'] }}" style="width:100%;height:100%;object-fit:cover">
        @else
        <span style="font-size:28px">📄</span>
        @endif
      </div>
      @empty
      @foreach(range(1,10) as $i)
      <div class="media-item" style="background:var(--bg)">
        <span style="font-size:24px;opacity:.3">🖼️</span>
      </div>
      @endforeach
      @endforelse
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
function selectMedia(url) {
  navigator.clipboard.writeText(url).then(() => showToast('Image URL copied!','success'));
}
function handleUpload(input) {
  showToast('Uploading ' + input.files.length + ' file(s)...','info');
}
</script>
@endpush
