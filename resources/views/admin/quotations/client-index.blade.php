@extends('layouts.admin')

@section('title', 'Client Quotations')
@section('page-title', 'Client Quotations')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">
            <i class="fa fa-users"></i> Client Quotations
        </h2>
        <a href="{{ route('admin.bookings.index') }}" class="btn-modern" style="background: #6b7280; color: white;">
            <i class="fa fa-arrow-left"></i> Back to Bookings
        </a>
    </div>

    <!-- Search Bar -->
    <div class="modern-card mb-4">
        <form action="{{ route('admin.client-quotations.index') }}" method="GET" class="row g-3">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Search by quotation number, customer name, email, or event type..." 
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn-modern btn-modern-primary w-100">
                    <i class="fa fa-search"></i> Search
                </button>
                @if(request('search'))
                <a href="{{ route('admin.client-quotations.index') }}" class="btn-modern w-100 mt-2" style="background: #6b7280; color: white;">
                    <i class="fa fa-times"></i> Clear
                </a>
                @endif
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($quotations->count() > 0)
        <div class="row g-4">
            @foreach($quotations as $quotation)
                <div class="col-lg-4 col-md-6">
                    <div class="quotation-card modern-card">
                        <div class="quotation-card-header">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="quotation-number mb-1">
                                        #{{ $loop->iteration + ($quotations->currentPage() - 1) * $quotations->perPage() }}
                                        <span class="text-muted fw-normal" style="font-size: 0.8rem;">({{ $quotation->quotation_number }})</span>
                                    </h5>
                                    <small class="text-muted">{{ $quotation->created_at->format('M d, Y') }}</small>
                                    @if($quotation->booking)
                                        <div class="mt-1">
                                            <span class="badge" style="background: #8B6F47; color: white; font-size: 0.75rem;">
                                                <i class="fa fa-link"></i> Booking #{{ $quotation->booking->id }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    @if($quotation->status === 'sent')
                                        <span class="badge-modern badge-info">Sent</span>
                                    @elseif($quotation->status === 'accepted')
                                        <span class="badge-modern badge-success">Accepted</span>
                                    @elseif($quotation->status === 'rejected')
                                        <span class="badge-modern badge-danger">Rejected</span>
                                    @else
                                        <span class="badge-modern badge-secondary">Draft</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="quotation-card-body">
                            <div class="customer-info mb-3">
                                <i class="fa fa-user text-muted me-2"></i>
                                <strong>{{ $quotation->customer_name }}</strong>
                            </div>
                            <div class="customer-info mb-3">
                                <i class="fa fa-envelope text-muted me-2"></i>
                                <small>{{ $quotation->customer_email }}</small>
                            </div>
                            
                            @if($quotation->event_type)
                            <div class="event-info mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted"><i class="fa fa-calendar me-1"></i> Event</span>
                                    <strong>{{ $quotation->event_type }}</strong>
                                </div>
                                @if($quotation->event_date)
                                <div class="d-flex justify-content-between mt-1">
                                    <span class="text-muted"><i class="fa fa-clock me-1"></i> Date</span>
                                    <span>{{ $quotation->event_date->format('M d, Y') }}</span>
                                </div>
                                @endif
                                @if($quotation->guest_count)
                                <div class="d-flex justify-content-between mt-1">
                                    <span class="text-muted"><i class="fa fa-users me-1"></i> Guests</span>
                                    <span>{{ $quotation->guest_count }}</span>
                                </div>
                                @endif
                            </div>
                            @endif

                            <div class="quotation-total">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Total Amount</span>
                                    <h4 class="mb-0 text-success">₹{{ number_format($quotation->total, 2) }}</h4>
                                </div>
                            </div>
                        </div>

                        <div class="quotation-card-footer">
                            <div class="row g-2">
                                <div class="col-3">
                                    <a href="{{ route('admin.quotations.show', $quotation) }}" 
                                       class="btn-modern btn-modern-primary btn-sm w-100" title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </div>
                                <div class="col-3">
                                    <a href="{{ route('admin.quotations.edit', $quotation) }}" 
                                       class="btn-modern btn-sm w-100" 
                                       style="background: #f59e0b; color: white;" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </div>
                                <div class="col-3">
                                    <button type="button" 
                                            class="btn-modern btn-sm w-100" 
                                            style="background: #3b82f6; color: white;" 
                                            onclick="openEmailModal('{{ route('admin.quotations.email', $quotation) }}', '{{ $quotation->customer_email }}')"
                                            title="Email">
                                        <i class="fa fa-envelope"></i>
                                    </button>
                                </div>
                                <div class="col-3">
                                    <form action="{{ route('admin.quotations.destroy', $quotation) }}" 
                                          method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn-modern btn-sm w-100" 
                                                style="background: #ef4444; color: white;"
                                                onclick="return confirm('Are you sure you want to delete this quotation?')" 
                                                title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($quotations->hasPages())
            <div class="mt-4">
                {{ $quotations->links() }}
            </div>
        @endif
    @else
        <div class="modern-card text-center py-5">
            <i class="fa fa-users" style="font-size: 4rem; color: #d1d5db; margin-bottom: 1rem;"></i>
            <h4 class="text-muted mb-3">No Client Quotations Found</h4>
            <p class="text-muted mb-4">Client quotations are automatically created when you generate quotations from event bookings.</p>
            <a href="{{ route('admin.bookings.index') }}" class="btn-modern btn-modern-primary">
                <i class="fa fa-calendar-check-o"></i> View Event Bookings
            </a>
        </div>
    @endif
</div>

<!-- Email Modal -->
<div class="modal fade" id="emailListModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="emailListForm" action="" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Send Quotation via Email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Recipient Email</label>
                        <input type="email" class="form-control" name="email" id="emailListInput" required>
                    </div>
                    <div class="alert alert-info mb-0">
                        <small><i class="fa fa-info-circle me-1"></i>The quotation will be sent as a PDF attachment.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-modern btn-modern-primary">
                        <i class="fa fa-send"></i> Send Email
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEmailModal(actionUrl, email) {
    document.getElementById('emailListForm').action = actionUrl;
    document.getElementById('emailListInput').value = email;
    new bootstrap.Modal(document.getElementById('emailListModal')).show();
}
</script>

<style>
.quotation-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.quotation-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.quotation-card-header {
    padding: 1.25rem;
    border-bottom: 1px solid #e5e7eb;
}

.quotation-number {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1B4D3E;
}

.quotation-card-body {
    padding: 1.25rem;
    flex-grow: 1;
}

.customer-info, .event-info {
    font-size: 0.9rem;
}

.quotation-total {
    padding-top: 1rem;
    border-top: 2px dashed #e5e7eb;
    margin-top: 1rem;
}

.quotation-card-footer {
    padding: 1rem 1.25rem;
    background-color: #f9fafb;
    border-top: 1px solid #e5e7eb;
}

.badge-info {
    background-color: #3b82f6;
}
</style>
@endsection
