@extends('layouts.admin')

@section('title', 'Booking Details')

@section('content')
<div class="container-fluid">
    <!-- Header with Actions -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-3">
            <h1 class="h4 mb-0"><i class="fa fa-calendar-check-o text-success"></i> Booking #{{ $booking->id }}</h1>
            @if($booking->status === 'pending')
                <span class="badge bg-warning text-dark">Pending</span>
            @elseif($booking->status === 'confirmed')
                <span class="badge bg-success">Confirmed</span>
            @else
                <span class="badge bg-danger">Cancelled</span>
            @endif
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa fa-arrow-left"></i> Back
            </a>
            <form action="{{ route('admin.quotations.generate', $booking) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-file-text-o"></i> Generate Quote
                </button>
            </form>
            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2 mb-3" role="alert">
            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-3">
        <!-- Left Column: Details -->
        <div class="col-lg-8">
            <div class="row g-3">
                <!-- Customer & Event Summary -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-2 border-bottom-0">
                            <h6 class="mb-0 fw-bold text-success"><i class="fa fa-user me-2"></i> Customer Details</h6>
                        </div>
                        <div class="card-body pt-0">
                            <ul class="list-unstyled mb-0 small">
                                <li class="mb-2 d-flex align-items-center">
                                    <span class="text-muted w-25">Name:</span>
                                    <span class="fw-bold">{{ $booking->name }}</span>
                                </li>
                                <li class="mb-2 d-flex align-items-center">
                                    <span class="text-muted w-25">Email:</span>
                                    <a href="mailto:{{ $booking->email }}" class="text-decoration-none">{{ $booking->email }}</a>
                                </li>
                                <li class="mb-2 d-flex align-items-center">
                                    <span class="text-muted w-25">Phone:</span>
                                    <a href="tel:{{ $booking->contact_number }}" class="text-decoration-none">{{ $booking->contact_number }}</a>
                                </li>
                                <li class="d-flex align-items-center">
                                    <span class="text-muted w-25">Country:</span>
                                    <span>{{ $booking->country }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-2 border-bottom-0">
                            <h6 class="mb-0 fw-bold text-success"><i class="fa fa-calendar me-2"></i> Event Details</h6>
                        </div>
                        <div class="card-body pt-0">
                            <ul class="list-unstyled mb-0 small">
                                <li class="mb-2 d-flex align-items-center">
                                    <span class="text-muted w-25">Type:</span>
                                    <span class="badge bg-light text-dark border">{{ $booking->event_type }}</span>
                                </li>
                                <li class="mb-2 d-flex align-items-center">
                                    <span class="text-muted w-25">Date:</span>
                                    <span class="fw-bold">{{ \Carbon\Carbon::parse($booking->event_date)->format('M d, Y') }}</span>
                                </li>
                                <li class="mb-2 d-flex align-items-center">
                                    <span class="text-muted w-25">Time:</span>
                                    <span>{{ \Carbon\Carbon::parse($booking->event_time, 'UTC')->format('h:i A') }}</span>
                                </li>
                                <li class="mb-2 d-flex align-items-center">
                                    <span class="text-muted w-25">Guests:</span>
                                    <span class="fw-bold">{{ number_format($booking->guest_count) }}</span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <span class="text-muted w-25">Food:</span>
                                    <span class="badge {{ $booking->food_preference == 'Vegetarian' ? 'bg-success' : ($booking->food_preference == 'Non-Vegetarian' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                        {{ ucfirst($booking->food_preference) }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Menu & Requests -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-2 border-bottom-0">
                            <h6 class="mb-0 fw-bold text-success"><i class="fa fa-cutlery me-2"></i> Menu & Requirements</h6>
                        </div>
                        <div class="card-body pt-0">
                            @if($booking->selected_items)
                                <div class="mb-3">
                                    <label class="small text-muted d-block mb-1">Selected Items:</label>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach(explode(',', $booking->selected_items) as $item)
                                            <span class="badge bg-light text-dark border fw-normal">{{ trim($item) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <div class="row g-3">
                                @if($booking->dish_suggestions)
                                <div class="col-md-6">
                                    <label class="small text-muted d-block mb-1">Dish Suggestions:</label>
                                    <p class="small bg-light p-2 rounded mb-0">{{ $booking->dish_suggestions }}</p>
                                </div>
                                @endif
                                
                                @if($booking->special_requests)
                                <div class="col-md-6">
                                    <label class="small text-muted d-block mb-1">Special Requests:</label>
                                    <p class="small bg-light p-2 rounded mb-0">{{ $booking->special_requests }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Management -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-2 border-bottom-0">
                    <h6 class="mb-0 fw-bold text-success"><i class="fa fa-cog me-2"></i> Update Status</h6>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="input-group input-group-sm mb-2">
                            <select name="status" class="form-select form-select-sm" required>
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-2 border-bottom-0">
                    <h6 class="mb-0 fw-bold text-success"><i class="fa fa-history me-2"></i> Timeline</h6>
                </div>
                <div class="card-body pt-0">
                    <ul class="list-unstyled mb-0 small timeline-list">
                        <li class="position-relative pb-3 ps-3 border-start">
                            <i class="fa fa-circle text-success position-absolute start-0 translate-middle-x bg-white" style="top: 0;"></i>
                            <strong>Created</strong>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ $booking->created_at->format('M d, Y h:i A') }}</div>
                        </li>
                        @if($booking->updated_at != $booking->created_at)
                        <li class="position-relative ps-3 border-start border-white">
                            <i class="fa fa-circle text-warning position-absolute start-0 translate-middle-x bg-white" style="top: 0;"></i>
                            <strong>Updated</strong>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ $booking->updated_at->format('M d, Y h:i A') }}</div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05) !important;
}
.badge {
    font-weight: 500;
}
</style>
@endsection
