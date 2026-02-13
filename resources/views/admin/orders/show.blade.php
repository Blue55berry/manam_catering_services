@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Order #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order Items</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>{{ $item->menuItem->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Customer Details</h6>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>Phone:</strong> {{ $order->phone }}</p>
                    <p><strong>Address:</strong></p>
                    <address>
                        {{ $order->address_1 }}<br>
                        @if ($order->address_2)
                            {{ $order->address_2 }}<br>
                        @endif
                        {{ $order->city }}, {{ $order->state }} {{ $order->zip }}
                    </address>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Event Details</h6>
                </div>
                <div class="card-body">
                    <p><strong>Event Type:</strong> {{ $order->event_type ?? 'N/A' }}</p>
                    <p><strong>Event Date:</strong> {{ $order->event_date ? \Carbon\Carbon::parse($order->event_date)->format('m/d/Y') : 'N/A' }}</p>
                    <p><strong>Food Requirements:</strong></p>
                    <p class="text-muted">{{ $order->food_requirements ?? 'No specific requirements provided.' }}</p>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order Summary</h6>
                </div>
                <div class="card-body">
                    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                    <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('m/d/Y H:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
