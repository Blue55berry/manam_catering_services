@extends('layouts.admin')

@section('title', 'Enquiry Details')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0"><i class="fa fa-envelope-open"></i> Enquiry Details</h2>
        <a href="{{ route('admin.contacts.index') }}" class="btn-modern">
            <i class="fa fa-arrow-left"></i> Back to Enquiries
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Enquiry Card -->
            <div class="modern-card mb-4">
                <div class="modern-card-header">
                    <h5 class="modern-card-title {{ $contact->is_read ? 'text-success' : 'text-warning' }}">
                        <i class="fa fa-{{ $contact->is_read ? 'check-circle' : 'exclamation-circle' }} me-2"></i>
                        {{ $contact->is_read ? 'Read Enquiry' : 'New Enquiry' }}
                    </h5>
                </div>
                <div class="modern-card-body">
                    <!-- Subject -->
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold mb-1">Subject</label>
                        <h4 class="text-dark mb-2">{{ $contact->subject ?? 'Contact Enquiry' }}</h4>
                        <small class="text-muted">
                            <i class="fa fa-clock-o text-success me-1"></i> Received on {{ $contact->created_at->format('F d, Y \a\t h:i A') }}
                        </small>
                    </div>

                    <hr class="my-4" style="border-color: #f3f4f6;">

                    <!-- Message -->
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold mb-3"><i class="fa fa-comment me-1"></i> Message</label>
                        <div class="bg-light p-4 rounded" style="border: 1px solid #f3f4f6;">
                            <p class="mb-0 text-dark" style="white-space: pre-wrap; line-height: 1.6;">{{ $contact->message }}</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-2 mt-4">
                        @if(!$contact->is_read)
                            <form action="{{ route('admin.contacts.mark-read', $contact) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-modern btn-modern-success">
                                    <i class="fa fa-check"></i> Mark as Read
                                </button>
                            </form>
                        @endif
                        
                        <a href="mailto:{{ $contact->email }}" class="btn-modern btn-modern-primary">
                            <i class="fa fa-reply"></i> Reply via Email
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Customer Info Card -->
            <div class="modern-card">
                <div class="modern-card-header">
                    <h5 class="modern-card-title"><i class="fa fa-user me-2"></i> Customer Information</h5>
                </div>
                <div class="modern-card-body">
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold mb-1">Name</label>
                        <p class="mb-0 fs-5 fw-bold text-dark">{{ $contact->name }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold mb-1">Email Address</label>
                        <p class="mb-0">
                            <a href="mailto:{{ $contact->email }}" class="text-decoration-none text-primary fw-medium">{{ $contact->email }}</a>
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold mb-1">Phone Number</label>
                        <p class="mb-0">
                            <a href="tel:{{ $contact->phone }}" class="text-decoration-none text-dark fw-bold">{{ $contact->phone }}</a>
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold mb-1">Status</label>
                        <p class="mb-0">
                            @if($contact->is_read)
                                <span class="badge-modern badge-success"><i class="fa fa-check-circle me-1"></i> Read</span>
                            @else
                                <span class="badge-modern badge-warning"><i class="fa fa-clock-o me-1"></i> Unread</span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="mb-0">
                        <label class="text-muted small text-uppercase fw-bold mb-1">Submitted</label>
                        <p class="mb-0 text-muted">{{ $contact->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
