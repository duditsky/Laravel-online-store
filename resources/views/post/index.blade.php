@extends('layouts.default')

@section('title', 'All Reviews Management')

@section('content')
<div class="admin-container container py-5">
    <div class="admin-header text-center mb-5">
        <h1 class="admin-title">All Reviews Management</h1>
        <p class="text-white-50">Moderate and edit customer feedback</p>
        <hr class="mx-auto" style="width: 50px; height: 3px; background: var(--main-color); border: 0; opacity: 1;">
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            @foreach ($posts as $post)
                <div class="review-admin-card card shadow-sm mb-4 border-0 rounded-4 overflow-hidden">
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
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-outline-primary rounded-3 px-3">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded-3 px-3" type="submit">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-8 ps-md-4 mt-3 mt-md-0">
                                <small class="text-muted d-block text-uppercase fw-bold mb-2" style="font-size: 0.65rem;">Review Content</small>
                                <div class="review-content-box p-3 rounded-3 bg-light position-relative">
                                    <i class="bi bi-quote fs-2 text-secondary opacity-25 position-absolute top-0 end-0 me-2"></i>
                                    <h5 class="fw-normal mb-0" style="line-height: 1.6; color: #444;">{{ $post->text }}</h5>
                                </div>
                                <div class="text-end mt-2">
                                    <small class="text-muted italic" style="font-size: 0.75rem;">Posted on: {{ $post->created_at->format('M d, Y') }}</small>
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
@endsection