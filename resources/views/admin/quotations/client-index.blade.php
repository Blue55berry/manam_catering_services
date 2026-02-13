@extends('layouts.admin')

@section('title', 'Client Quotations')
@section('page-title', 'Client Quotations')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">
            <i class="fa fa-users"></i> Client Quotations
        </h2>
        <a href="{{ route('admin.bookings.index') }}" class="btn-modern shadow-sm" style="background: #6b7280; color: white;">
            <i class="fa fa-arrow-left"></i> Back to Bookings
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="modern-card">
        <div class="modern-card-header py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <!-- Search -->
            <div class="flex-grow-1" style="max-width: 400px;">
                <form action="{{ route('admin.client-quotations.index') }}" method="GET">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fa fa-search text-muted"></i></span>
                        <input type="text" 
                               name="search" 
                               class="form-control border-start-0 bg-light" 
                               placeholder="Search quotations..." 
                               value="{{ request('search') }}">
                         @if(request('search') || request('status'))
                            <a href="{{ route('admin.client-quotations.index') }}" class="btn btn-light border" title="Clear Filters">
                                <i class="fa fa-times text-danger"></i>
                            </a>
                        @endif
                    </div>
                    <!-- Hidden input to maintain status filter when searching -->
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                </form>
            </div>

            <!-- Status Filter Tabs (Visual) -->
            <div class="status-filters">
                <a href="{{ route('admin.client-quotations.index', array_merge(request()->except('status', 'page'), ['status' => 'all'])) }}" 
                   class="filter-pill {{ !request('status') || request('status') == 'all' ? 'active' : '' }}">
                   All
                </a>
                <a href="{{ route('admin.client-quotations.index', array_merge(request()->except('status', 'page'), ['status' => 'draft'])) }}" 
                   class="filter-pill {{ request('status') == 'draft' ? 'active' : '' }}">
                   Draft
                </a>
                <a href="{{ route('admin.client-quotations.index', array_merge(request()->except('status', 'page'), ['status' => 'sent'])) }}" 
                   class="filter-pill {{ request('status') == 'sent' ? 'active' : '' }}">
                   Sent
                </a>
                <a href="{{ route('admin.client-quotations.index', array_merge(request()->except('status', 'page'), ['status' => 'accepted'])) }}" 
                   class="filter-pill {{ request('status') == 'accepted' ? 'active' : '' }}">
                   Accepted
                </a>
                <a href="{{ route('admin.client-quotations.index', array_merge(request()->except('status', 'page'), ['status' => 'rejected'])) }}" 
                   class="filter-pill {{ request('status') == 'rejected' ? 'active' : '' }}">
                   Rejected
                </a>
            </div>
        </div>

        <div class="modern-card-body p-0">
            @if($quotations->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th width="5%">S.No</th>
                                <th width="10%">Date</th>
                                <th width="12%">Quotation #</th>
                                <th width="20%">Customer</th>
                                <th width="15%">Event</th>
                                <th width="10%" class="text-end">Amount</th>
                                <th width="10%" class="text-center">Status</th>
                                <th width="18%" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotations as $quotation)
                            <tr>
                                <td>
                                    <span class="text-muted fw-bold">{{ $loop->iteration + ($quotations->currentPage() - 1) * $quotations->perPage() }}</span>
                                </td>
                                <td>
                                    <span class="text-muted small">
                                        {{ $quotation->created_at->format('M d, Y') }}
                                        <br>
                                        {{ $quotation->created_at->format('h:i A') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $quotation->quotation_number }}</span>
                                    @if($quotation->booking)
                                        <br>
                                        <small class="text-success"><i class="fa fa-link"></i> Book #{{ $quotation->booking->id }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">{{ $quotation->customer_name }}</span>
                                        <small class="text-muted">{{ $quotation->customer_email }}</small>
                                        @if($quotation->customer_phone)
                                            <small class="text-muted">{{ $quotation->customer_phone }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span>{{ $quotation->event_type ?? 'N/A' }}</span>
                                        @if($quotation->event_date)
                                            <small class="text-muted"><i class="fa fa-calendar-o me-1"></i>{{ $quotation->event_date->format('M d, Y') }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold text-success">₹{{ number_format($quotation->total, 2) }}</span>
                                </td>
                                <td class="text-center">
                                    @if($quotation->status === 'sent')
                                        <span class="badge-modern badge-info">Sent</span>
                                    @elseif($quotation->status === 'accepted')
                                        <span class="badge-modern badge-success">Accepted</span>
                                    @elseif($quotation->status === 'rejected')
                                        <span class="badge-modern badge-danger">Rejected</span>
                                    @else
                                        <span class="badge-modern badge-secondary">Draft</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.quotations.show', $quotation) }}" 
                                           class="btn-icon btn-icon-primary" 
                                           title="View Details">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.quotations.edit', $quotation) }}" 
                                           class="btn-icon btn-icon-warning" 
                                           title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn-icon btn-icon-info" 
                                                onclick="openEmailModal('{{ route('admin.quotations.email', $quotation) }}', '{{ $quotation->customer_email }}')"
                                                title="Send Email">
                                            <i class="fa fa-envelope"></i>
                                        </button>
                                        <form action="{{ route('admin.quotations.destroy', $quotation) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn-icon btn-icon-danger" 
                                                    onclick="return confirm('Delete {{ $quotation->quotation_number }}?')" 
                                                    title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light" style="width: 80px; height: 80px;">
                            <i class="fa fa-users fa-2x text-muted"></i>
                        </div>
                    </div>
                    <h4 class="text-muted">No Client Quotations Found</h4>
                    <p class="text-muted mb-4" style="max-width: 400px; margin: 0 auto;">
                        Client quotations created from bookings will appear here. 
                        @if(request('search') || request('status'))
                        <br>Try adjusting your search or filters.
                        @endif
                    </p>
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.client-quotations.index') }}" class="btn-modern btn-modern-primary mt-3">
                            <i class="fa fa-refresh"></i> Clear Filters
                        </a>
                    @else
                        <a href="{{ route('admin.bookings.index') }}" class="btn-modern btn-modern-primary mt-3">
                            <i class="fa fa-calendar-check-o"></i> Go to Bookings
                        </a>
                    @endif
                </div>
            @endif
        </div>
        
        @if($quotations->hasPages())
        <div class="modern-card-footer">
            {{ $quotations->links() }}
        </div>
        @endif
    </div>
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
/* Filter Pills */
.status-filters {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.filter-pill {
    padding: 0.4rem 1rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    color: #6b7280;
    background-color: #f3f4f6;
    transition: all 0.2s;
    border: 1px solid transparent;
}

.filter-pill:hover {
    background-color: #e5e7eb;
    color: #374151;
}

.filter-pill.active {
    background-color: #1B4D3E; /* Primary Color */
    color: white;
    box-shadow: 0 2px 4px rgba(27, 77, 62, 0.2);
}

/* Action Buttons */
.btn-icon {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    border: none;
    background: #f3f4f6;
    color: #6b7280;
    transition: all 0.2s;
    text-decoration: none;
}

.btn-icon:hover {
    color: white;
    transform: translateY(-2px);
}

.btn-icon-primary:hover { background: #1B4D3E; }
.btn-icon-warning:hover { background: #f59e0b; }
.btn-icon-info:hover { background: #3b82f6; }
.btn-icon-danger:hover { background: #ef4444; }

/* Table Alignments */
.modern-table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
    background: #f9fafb;
    padding: 1rem;
}

.modern-table td {
    padding: 1rem;
    vertical-align: middle;
}
</style>
@endsection
