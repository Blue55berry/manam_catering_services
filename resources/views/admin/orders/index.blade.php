@extends('layouts.admin')

@section('title', 'Orders')
@section('page-title', 'Orders')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">
            <i class="fa fa-shopping-cart"></i> Orders
        </h2>
        <a href="#" class="btn-modern btn-modern-primary">
            <i class="fa fa-download"></i> Export Report
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Orders Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h3 class="modern-card-title">
                <i class="fa fa-list"></i> All Orders
            </h3>
            <div class="card-actions">
                <!-- Optional filters can go here -->
            </div>
        </div>
        <div class="modern-card-body">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table" id="ordersTable">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td><strong>#{{ $order->id }}</strong></td>
                                    <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                                    <td>{{ $order->email }}</td>
                                    <td class="text-primary font-weight-bold">₹{{ number_format($order->total, 2) }}</td>
                                    <td>
                                        @if($order->status == 'completed')
                                            <span class="badge-modern badge-success">Completed</span>
                                        @elseif($order->status == 'pending')
                                            <span class="badge-modern badge-warning">Pending</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge-modern badge-danger">Cancelled</span>
                                        @else
                                            <span class="badge-modern badge-info">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn-modern btn-modern-primary btn-sm" title="View Details">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-modern btn-sm" style="background: #ef4444; color: white;" 
                                                        onclick="return confirm('Are you sure you want to delete this order?')" title="Delete Order">
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
                
                <div class="mt-4 d-flex justify-content-end">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fa fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No orders found.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
