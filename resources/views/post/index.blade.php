@extends('layouts.default')

@section('title', 'All Reviews Management')

@section('content')

<div class="admin-container container py-5">
    <div class="admin-header text-center mb-5">
        <h1 class="admin-title">All Reviews Management</h1>
        <p class="text-white-50">You have <span id="total-count">{{ $posts->total() }}</span> total customer reviews</p>
        <hr class="mx-auto" style="width: 50px; height: 3px; background: var(--main-color); border: 0; opacity: 1;">
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            @foreach ($posts as $post)
            <div class="review-admin-card card shadow-sm mb-4 border-0 rounded-4 overflow-hidden" id="post-row-{{ $post->id }}">
                <div class="card-body p-4">
                    <div class="row align-items-start">
                        <div class="col-md-4 border-end">
                            <div class="mb-2">
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem;">Customer</small>
                                <h6 class="fw-bold mb-0"><i class="bi bi-person-circle me-1"></i> {{ $post->user->name }}</h6>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem;">Product</small>
                                <span class="badge bg-light text-primary border">{{ $post->product->name }}</span>
                            </div>
                            <div class="d-flex gap-2 mt-3">
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-3 px-3 btn-edit"
                                    data-id="{{ $post->id }}"
                                    data-text="{{ $post->text }}">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                                
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-3 px-3 btn-delete"
                                    data-id="{{ $post->id }}"
                                    onclick="ajaxDeletePost('{{ $post->id }}')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                        <div class="col-md-8 ps-md-4 mt-3 mt-md-0">
                            <small class="text-muted d-block text-uppercase fw-bold mb-2" style="font-size: 0.65rem;">Review Content</small>
                            <div class="review-content-box p-3 rounded-3 bg-light position-relative">
                                <i class="bi bi-quote fs-2 text-secondary opacity-25 position-absolute top-0 end-0 me-2"></i>
                                <h5 class="fw-normal mb-0" id="text-display-{{ $post->id }}" style="line-height: 1.6; color: #444; transition: opacity 0.3s ease;">{{ $post->text }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="admin-pagination d-flex justify-content-center mt-5">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modal-post-id">
                <textarea id="modal-post-text" class="form-control rounded-3" rows="5" style="resize: none;"></textarea>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" id="saveBtn" onclick="ajaxUpdatePost()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-body text-center p-4">
                <div class="text-danger mb-3">
                    <i class="bi bi-exclamation-octagon" style="font-size: 3.5rem;"></i>
                </div>
                <h5 class="fw-bold">Are you sure?</h5>
                <p class="text-muted small">This review will be permanently removed.</p>
                
                <input type="hidden" id="delete-post-id">

                <div class="d-flex gap-2 justify-content-center mt-4">
                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger rounded-pill px-3 fw-bold" id="confirmDeleteBtn" onclick="confirmAjaxDelete()">Delete Now</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Підключаємо JS в самому кінці --}}
<script src="{{ asset('js/post.js') }}"></script>
@endsection