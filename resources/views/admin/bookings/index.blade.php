@extends('layouts.admin')

@section('title', 'Event Bookings')
@section('page-title', 'Event Bookings')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="section-title"><i class="fa fa-calendar-check-o"></i> Event Bookings</h2>
            <p class="text-muted mb-0">Manage all customer event booking requests</p>
        </div>
        <div>
            <span class="badge-modern badge-success fs-6 px-3 py-2">
                <i class="fa fa-calendar"></i> {{ $bookings->count() }} Bookings
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Modern Filter Card -->
    <div class="modern-card mb-4">
        <div class="modern-card-body">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fa fa-filter text-success"></i>
                        </span>
                        <select class="form-select border-start-0 ps-0" id="filterEventType">
                            <option value="">All Event Types</option>
                            <option value="Wedding">Wedding</option>
                            <option value="Corporate Event">Corporate Event</option>
                            <option value="Celebration">Celebration</option>
                            <option value="Social Gathering">Social Gathering</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fa fa-calendar text-success"></i>
                        </span>
                        <select class="form-select border-start-0 ps-0" id="filterStatus">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fa fa-search text-success"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0" id="searchBooking" placeholder="Search by name or email...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Bookings Table -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h3 class="modern-card-title">
                <i class="fa fa-list"></i> Booking Requests
            </h3>
        </div>
        <div class="modern-card-body p-0">
            <div class="table-responsive">
                <table class="modern-table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Event Type</th>
                            <th>Event Date</th>
                            <th>Guests</th>
                            <th>Package</th>
                            <th>Preference</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr data-event-type="{{ $booking->event_type }}" data-status="{{ $booking->status }}" data-name="{{ strtolower($booking->name) }}" data-email="{{ strtolower($booking->email) }}">
                                <td>
                                    <span class="fw-bold text-muted">{{ $booking->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">{{ $booking->name }}</span>
                                        @if($booking->event)
                                            <small class="text-muted">
                                                {{ $booking->event->title ?? ucfirst($booking->event->category) }}
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-modern badge-info">
                                        {{ $booking->event_type }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted small">
                                        <i class="fa fa-calendar-alt me-1"></i>
                                        {{ $booking->event_date->format('d M Y') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">
                                        {{ number_format($booking->guest_count) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-modern badge-info">
                                        <i class="fa fa-tag me-1"></i> {{ $booking->package->name ?? 'Custom' }}
                                    </span>
                                </td>
                                <td>
                                    @if($booking->food_preference == 'Vegetarian' || $booking->food_preference == 'Veg')
                                        <span class="badge-modern" style="background-color: #d1fae5; color: #065f46;">
                                            <i class="fa fa-leaf me-1"></i> Veg
                                        </span>
                                    @elseif($booking->food_preference == 'Non-Vegetarian' || $booking->food_preference == 'Non-Veg')
                                        <span class="badge-modern" style="background-color: #fee2e2; color: #991b1b;">
                                            <i class="fa fa-drumstick-bite me-1"></i> Non-Veg
                                        </span>
                                    @else
                                        <span class="badge-modern badge-info">
                                            <i class="fa fa-utensils me-1"></i> {{ $booking->food_preference ?? 'Both' }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-muted">{{ $booking->email }}</small>
                                        <small class="text-muted">{{ $booking->contact_number }}</small>
                                    </div>
                                </td>
                                <td>
                                    @if($booking->status === 'pending')
                                        <span class="badge-modern badge-warning">
                                            <i class="fa fa-clock-o"></i> Pending
                                        </span>
                                    @elseif($booking->status === 'confirmed')
                                        <span class="badge-modern badge-success">
                                            <i class="fa fa-check-circle"></i> Confirmed
                                        </span>
                                    @else
                                        <span class="badge-modern badge-danger">
                                            <i class="fa fa-times-circle"></i> Cancelled
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $booking->created_at->diffForHumans() }}
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.bookings.show', $booking) }}" class="btn-modern btn-modern-primary btn-sm">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn-modern btn-sm" 
                                                    style="background: #ef4444; color: white;"
                                                    onclick="return confirm('Are you sure you want to delete this booking?')" 
                                                    title="Delete">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-state">
                                <td colspan="10" class="text-center py-5">
                                    <i class="fa fa-calendar-times-o fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">No bookings found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const eventFilter = document.getElementById('filterEventType');
    const statusFilter = document.getElementById('filterStatus');
    const searchInput = document.getElementById('searchBooking');
    const rows = document.querySelectorAll('tbody tr:not(.empty-state)');

    function filterRows() {
        const eventValue = eventFilter.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();
        const searchValue = searchInput.value.toLowerCase();

        rows.forEach(row => {
            const eventType = row.dataset.eventType?.toLowerCase() || '';
            const status = row.dataset.status?.toLowerCase() || '';
            const name = row.dataset.name?.toLowerCase() || '';
            const email = row.dataset.email?.toLowerCase() || '';

            const matchesEvent = !eventValue || eventType.includes(eventValue);
            const matchesStatus = !statusValue || status === statusValue;
            const matchesSearch = !searchValue || name.includes(searchValue) || email.includes(searchValue);

            row.style.display = matchesEvent && matchesStatus && matchesSearch ? '' : 'none';
        });
    }

    if(eventFilter) eventFilter.addEventListener('change', filterRows);
    if(statusFilter) statusFilter.addEventListener('change', filterRows);
    if(searchInput) searchInput.addEventListener('input', filterRows);
});
</script>
@endsection
