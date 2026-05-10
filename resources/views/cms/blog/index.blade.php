@extends('cms.layouts.app')
@section('title','Blog Manager')
@section('page-title','Blog Manager')
@section('page-subtitle','Create and manage travel articles')
@push('header-actions')
<a href="{{ route('cms.blog.create') }}" class="header-btn header-btn--gold">+ New Post</a>
@endpush
@section('content')
<div class="card">
  <div class="card__header">
    <div class="card__title">✍️ Blog Posts</div>
    <div class="filter-row" style="margin:0">
      <button class="filter-chip active">All</button>
      <button class="filter-chip">Published</button>
      <button class="filter-chip">Draft</button>
    </div>
  </div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Title</th><th>Category</th><th>Author</th><th>Status</th><th>Views</th><th>Date</th><th>Actions</th></tr></thead>
      <tbody>
        @foreach($posts as $post)
        <tr>
          <td>
            <div style="font-weight:600;color:var(--t1)">{{ $post->title }}</div>
            <div style="font-size:11px;color:var(--t4)">{{ $post->read_time }}</div>
          </td>
          <td><span style="font-size:11px;background:var(--bg);padding:3px 8px;border-radius:20px;color:var(--t3)">{{ $post->category }}</span></td>
          <td style="font-size:12px;color:var(--t3)">RK Shah</td>
          <td><span class="badge badge--{{ $post->status ?? 'draft' }}">{{ ucfirst($post->status ?? 'Draft') }}</span></td>
          <td style="font-size:12px;color:var(--t3)">{{ number_format($post->views ?? 0) }}</td>
          <td style="font-size:12px;color:var(--t4)">{{ $post->short_date ?? ($post->published_at ? $post->published_at->format('d M Y') : 'Draft') }}</td>
          <td>
            <div style="display:flex;gap:4px">
              <a href="{{ route('cms.blog.edit',$post->slug) }}" class="icon-btn">✏️</a>
              <a href="{{ route('blog.show',$post->slug) }}" class="icon-btn" target="_blank">🔗</a>
              <button class="icon-btn icon-btn--danger" onclick="confirmDelete('{{ $post->slug }}')">🗑️</button>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
