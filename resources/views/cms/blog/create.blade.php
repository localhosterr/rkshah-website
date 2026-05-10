@extends('cms.layouts.app')
@section('title', isset($post) ? 'Edit Post' : 'New Blog Post')
@section('page-title', isset($post) ? 'Edit: '.$post['title'] : 'New Blog Post')
@push('header-actions')
<a href="{{ route('cms.blog') }}" class="header-btn header-btn--outline">← Back</a>
<button form="blogForm" type="submit" class="header-btn header-btn--gold">💾 Save Post</button>
@endpush
@section('content')
<form id="blogForm" action="{{ isset($post) ? route('cms.blog.update', $post->slug) : route('cms.blog.store') }}" method="POST">
@if(isset($post)) @method('PATCH') @endif
  @csrf
  <div class="main-side">
    <div style="display:flex;flex-direction:column;gap:16px">
      <div class="card">
        <div class="card__header"><div class="card__title">Post Content</div></div>
        <div class="card__body">
          <div class="form-group">
            <label class="form-label">Post Title</label>
            <input class="form-input" type="text" name="title" value="{{ $post['title'] ?? '' }}" placeholder="Delhi to Agra: The Ultimate Guide" required style="font-size:16px;font-weight:600">
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">URL Slug</label>
              <input class="form-input" type="text" name="slug" value="{{ $post['slug'] ?? '' }}" placeholder="delhi-to-agra-guide">
            </div>
            <div class="form-group">
              <label class="form-label">Category</label>
              <select class="form-select" name="category">
                @foreach(['Route Guide','Travel Tips','Budget Guide','Destination','Seasonal Guide'] as $cat)
                <option value="{{ $cat }}" {{ ($post['category'] ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Excerpt (shown in listing)</label>
            <textarea class="form-textarea" name="excerpt" rows="2" placeholder="A short description that appears in the blog listing...">{{ $post['excerpt'] ?? '' }}</textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Full Content (HTML allowed)</label>
            <textarea class="form-textarea" name="content" rows="14" placeholder="Write your full blog post here...">{{ $post['content'] ?? '' }}</textarea>
            <div class="form-hint">You can use &lt;h2&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;strong&gt; tags for formatting</div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card__header"><div class="card__title">SEO Settings</div></div>
        <div class="card__body">
          <div class="form-group"><label class="form-label">SEO Title (max 60 chars)</label><input class="form-input" type="text" name="seo_title" value="{{ $post['seo_title'] ?? '' }}" maxlength="60" placeholder="Delhi to Agra Cab Guide 2025 — RK Shah Car Rental"></div>
          <div class="form-group"><label class="form-label">Meta Description (max 160 chars)</label><textarea class="form-textarea" name="seo_description" rows="2" maxlength="160">{{ $post['seo_description'] ?? '' }}</textarea></div>
        </div>
      </div>
    </div>
    <div style="display:flex;flex-direction:column;gap:16px">
      <div class="card">
        <div class="card__header"><div class="card__title">Publish</div></div>
        <div class="card__body" style="display:flex;flex-direction:column;gap:10px">
          <div class="form-group">
            <label class="form-label">Status</label>
            <select class="form-select" name="status">
              <option value="draft" {{ ($post['status'] ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
              <option value="published" {{ ($post['status'] ?? '') === 'published' ? 'selected' : '' }}>Published</option>
            </select>
          </div>
          <button type="submit" class="btn btn--gold btn--full">💾 Save Post</button>
          <button type="button" class="btn btn--primary btn--full" onclick="document.querySelector('select[name=status]').value='published';document.getElementById('blogForm').submit()">🚀 Publish Now</button>
        </div>
      </div>
      <div class="card">
        <div class="card__header"><div class="card__title">Post Details</div></div>
        <div class="card__body">
          <div class="form-group"><label class="form-label">Emoji (for listing)</label><input class="form-input" type="text" name="emoji" value="{{ $post['emoji'] ?? '✍️' }}" maxlength="5"></div>
          <div class="form-group"><label class="form-label">Read Time</label><input class="form-input" name="read_time" value="{{ $post['read_time'] ?? '5 min read' }}" placeholder="5 min read"></div>
          <div class="form-group"><label class="form-label">Featured Image URL</label><input class="form-input" type="url" name="featured_image" value="{{ $post['featured_image'] ?? '' }}" placeholder="https://..."></div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
