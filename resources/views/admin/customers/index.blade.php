@extends('layouts.admin')

@section('title', 'Manage Customers')
@section('page-title', 'Customers')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">
            <i class="fa fa-users"></i> Manage Customers
        </h2>
        <a href="{{ route('admin.customers.create') }}" class="btn-modern btn-modern-primary">
            <i class="fa fa-plus"></i> Add New Customer
        </a>
    </div>

    <!-- Search Bar -->
    <div class="modern-card mb-4">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="row g-3">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Search by name, email, phone, or city..." 
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn-modern btn-modern-primary w-100">
                    <i class="fa fa-search"></i> Search
                </button>
                @if(request('search'))
                <a href="{{ route('admin.customers.index') }}" class="btn-modern w-100 mt-2" style="background: #6b7280; color: white;">
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

    @if($customers->count() > 0)
        <div class="modern-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td>
                                <strong>{{ $customer->name }}</strong>
                            </td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->city ?? '-' }}</td>
                            <td>
                                @if($customer->is_active)
                                    <span class="badge-modern badge-success">Active</span>
                                @else
                                    <span class="badge-modern badge-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.customers.show', $customer) }}" 
                                       class="btn btn-sm btn-info text-white" title="View Details">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.customers.edit', $customer) }}" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.customers.destroy', $customer) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Are you sure you want to delete this customer?')" 
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
        </div>

        @if($customers->hasPages())
            <div class="mt-4">
                {{ $customers->links() }}
            </div>
        @endif
    @else
        <div class="modern-card text-center py-5">
            <i class="fa fa-users" style="font-size: 4rem; color: #d1d5db; margin-bottom: 1rem;"></i>
            <h4 class="text-muted mb-3">No Customers Found</h4>
            <p class="text-muted mb-4">Start by adding your first customer to the system.</p>
            <a href="{{ route('admin.customers.create') }}" class="btn-modern btn-modern-primary">
                <i class="fa fa-plus"></i> Add New Customer
            </a>
        </div>
    @endif
</div>
@endsection
