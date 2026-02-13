@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card green">
        <div class="stat-card-header">
            <div>
                <div class="stat-label">Total Orders</div>
                <div class="stat-value">0</div>
                <div class="stat-change positive">
                    <i class="fa fa-arrow-up"></i> Live tracking
                </div>
            </div>
            <div class="stat-icon">
                <i class="fa fa-shopping-cart"></i>
            </div>
        </div>
    </div>

    <div class="stat-card blue">
        <div class="stat-card-header">
            <div>
                <div class="stat-label">Revenue</div>
                <div class="stat-value">₹0</div>
                <div class="stat-change positive">
                    <i class="fa fa-arrow-up"></i> All time
                </div>
            </div>
            <div class="stat-icon">
                <i class="fa fa-inr"></i>
            </div>
        </div>
    </div>

    <div class="stat-card orange">
        <div class="stat-card-header">
            <div>
                <div class="stat-label">Active Menus</div>
                <div class="stat-value">{{ \App\Models\MenuItem::where('is_active', true)->count() }}</div>
                <div class="stat-change positive">
                    <i class="fa fa-check"></i> Published
                </div>
            </div>
            <div class="stat-icon">
                <i class="fa fa-cutlery"></i>
            </div>
        </div>
    </div>

    <div class="stat-card purple">
        <div class="stat-card-header">
            <div>
                <div class="stat-label">Enquiries</div>
                <div class="stat-value">{{ \App\Models\Contact::count() }}</div>
                <div class="stat-change">
                    <i class="fa fa-envelope"></i> {{ \App\Models\Contact::where('is_read', false)->count() }} unread
                </div>
            </div>
            <div class="stat-icon">
                <i class="fa fa-comments"></i>
            </div>
        </div>
    </div>
</div>

<!-- Content Cards -->
<div class="row">
    <!-- Main Column -->
    <div class="col-lg-8 mb-4">
        <!-- Monthly Activity Chart -->
        <div class="modern-card mb-4">
            <div class="modern-card-header">
                <h3 class="modern-card-title">
                    <i class="fa fa-line-chart"></i> Monthly Activity Trend
                </h3>
            </div>
            <div class="modern-card-body">
                <canvas id="activityChart" height="100"></canvas>
            </div>
        </div>

        <!-- Recent Enquiries -->
        <div class="modern-card">
            <div class="modern-card-header">
                <h3 class="modern-card-title">
                    <i class="fa fa-envelope"></i> Recent Enquiries
                </h3>
                <a href="{{ route('admin.contacts.index') }}" class="btn-modern btn-modern-primary btn-sm">
                    View All <i class="fa fa-arrow-right"></i>
                </a>
            </div>
            <div class="modern-card-body">
                @php
                    $recentContacts = \App\Models\Contact::orderBy('created_at', 'desc')->limit(5)->get();
                @endphp
                
                @if($recentContacts->count() > 0)
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentContacts as $contact)
                            <tr>
                                <td><strong>{{ $contact->name }}</strong></td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->phone }}</td>
                                <td>{{ $contact->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if($contact->is_read)
                                        <span class="badge-modern badge-success">
                                            <i class="fa fa-check"></i> Read
                                        </span>
                                    @else
                                        <span class="badge-modern badge-warning">
                                            <i class="fa fa-eye-slash"></i> New
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-5">
                        <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No enquiries yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bookings Analytics (Side Column) -->
    <div class="col-lg-4 mb-4">
        <div class="modern-card">
            <div class="modern-card-header">
                <h3 class="modern-card-title">
                    <i class="fa fa-pie-chart"></i> Bookings Overview
                </h3>
            </div>
            <div class="modern-card-body">
                <canvas id="bookingsChart" height="200"></canvas>
                <hr class="my-4">
                <h6 class="text-muted mb-3 font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase;">Booking Status</h6>
                <canvas id="statusChart" height="150"></canvas>
            </div>
        </div>

        <!-- System Info -->
        <div class="modern-card mt-4">
            <div class="modern-card-header">
                <h3 class="modern-card-title">
                    <i class="fa fa-info-circle"></i> System Info
                </h3>
            </div>
            <div class="modern-card-body">
                <div class="mb-3">
                    <small class="text-muted">Total Menu Items</small>
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>{{ \App\Models\MenuItem::count() }}</strong>
                        <span class="badge-modern badge-info">
                            {{ \App\Models\MenuItem::where('is_active', true)->count() }} Active
                        </span>
                    </div>
                </div>
                <hr>
                <div class="mb-3">
                    <small class="text-muted">Blog Posts</small>
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>{{ \App\Models\Blog::count() }}</strong>
                        <span class="badge-modern badge-success">
                            {{ \App\Models\Blog::where('status', 'published')->count() }} Published
                        </span>
                    </div>
                </div>
                <hr>
                <div>
                    <small class="text-muted">Team Members</small>
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>{{ \App\Models\TeamMember::count() }}</strong>
                        <span class="badge-modern badge-info">Chefs</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Menu Items -->
<div class="modern-card">
    <div class="modern-card-header">
        <h3 class="modern-card-title">
            <i class="fa fa-cutlery"></i> Recent Menu Items
        </h3>
        <a href="{{ route('admin.menu-items.index') }}" class="btn-modern btn-modern-primary btn-sm">
            Manage Menu <i class="fa fa-arrow-right"></i>
        </a>
    </div>
    <div class="modern-card-body">
        @php
            $recentMenuItems = \App\Models\MenuItem::orderBy('created_at', 'desc')->limit(6)->get();
        @endphp
        
        @if($recentMenuItems->count() > 0)
            <div class="row">
                @foreach($recentMenuItems as $item)
                <div class="col-md-4 col-lg-2 mb-3">
                    <div class="text-center">
                        <img src="{{ $item->display_image }}" 
                             alt="{{ $item->name }}" 
                             class="img-fluid rounded mb-2" 
                             style="height: 80px; width: 80px; object-fit: cover;">
                        <h6 class="mb-1" style="font-size: 13px;">{{ Str::limit($item->name, 15) }}</h6>
                        <small class="text-muted">₹{{ number_format($item->price, 2) }}</small>
                        <div class="mt-1">
                            @if($item->is_active)
                                <span class="badge-modern badge-success" style="font-size: 10px;">Active</span>
                            @else
                                <span class="badge-modern badge-danger" style="font-size: 10px;">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fa fa-cutlery fa-3x text-muted mb-3"></i>
                <p class="text-muted">No menu items yet</p>
                <a href="{{ route('admin.menu-items.create') }}" class="btn-modern btn-modern-primary mt-2">
                    <i class="fa fa-plus"></i> Add First Menu Item
                </a>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
     document.addEventListener('DOMContentLoaded', function() {
        // Bookings by Event Type (Doughnut Chart)
        const eventTypeData = @json($bookingsByEventType);
        const eventLabels = Object.keys(eventTypeData);
        const eventValues = Object.values(eventTypeData);

        new Chart(document.getElementById('bookingsChart'), {
            type: 'doughnut',
            data: {
                labels: eventLabels,
                datasets: [{
                    data: eventValues,
                    backgroundColor: [
                        '#2d5016', // Primary Green
                        '#10b981', // Accent Green
                        '#3b82f6', // Blue
                        '#f59e0b', // Amber
                        '#ef4444'  // Red
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                }
            }
        });

        // Booking Status (Bar Chart)
        const statusData = @json($bookingsByStatus);
        const statusLabels = Object.keys(statusData).map(s => s.charAt(0).toUpperCase() + s.slice(1));
        const statusValues = Object.values(statusData);

        new Chart(document.getElementById('statusChart'), {
            type: 'bar',
            data: {
                labels: statusLabels,
                datasets: [{
                    label: 'Bookings',
                    data: statusValues,
                    backgroundColor: '#2d5016',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Monthly Activity (XY Line Graph)
        const monthlyData = @json($monthlyBookings);
        const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        
        new Chart(document.getElementById('activityChart'), {
            type: 'line',
            data: {
                labels: monthNames,
                datasets: [{
                    label: 'Bookings per Month',
                    data: Object.values(monthlyData),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3b82f6',
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4 // Makes the line curved (smooth XY graph)
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        grid: {
                            color: '#f3f4f6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                }
            }
        });
    });
</script>
@endpush
