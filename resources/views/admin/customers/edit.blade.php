@extends('layouts.admin')

@section('title', 'Edit Customer')
@section('page-title', 'Edit Customer')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">
            <i class="fa fa-edit"></i> Edit Customer
        </h2>
        <a href="{{ route('admin.customers.index') }}" class="btn-modern" style="background: #6b7280; color: white;">
            <i class="fa fa-arrow-left"></i> Back to Customers
        </a>
    </div>

    <div class="modern-card">
        <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-3">
                <!-- Name -->
                <div class="col-md-6">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $customer->name) }}" 
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $customer->email) }}" 
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone', $customer->phone) }}" 
                           required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Guest Count -->
                <div class="col-md-6">
                    <label for="guest_count" class="form-label">Guest Count</label>
                    <input type="number" 
                           class="form-control @error('guest_count') is-invalid @enderror" 
                           id="guest_count" 
                           name="guest_count" 
                           value="{{ old('guest_count', $customer->guest_count) }}"
                           min="1">
                    @error('guest_count')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- City -->
                <div class="col-md-6">
                    <label for="city" class="form-label">City</label>
                    <input type="text" 
                           class="form-control @error('city') is-invalid @enderror" 
                           id="city" 
                           name="city" 
                           value="{{ old('city', $customer->city) }}">
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- State -->
                <div class="col-md-6">
                    <label for="state" class="form-label">State</label>
                    <input type="text" 
                           class="form-control @error('state') is-invalid @enderror" 
                           id="state" 
                           name="state" 
                           value="{{ old('state', $customer->state) }}">
                    @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pincode -->
                <div class="col-md-6">
                    <label for="pincode" class="form-label">Pincode</label>
                    <input type="text" 
                           class="form-control @error('pincode') is-invalid @enderror" 
                           id="pincode" 
                           name="pincode" 
                           value="{{ old('pincode', $customer->pincode) }}">
                    @error('pincode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Address -->
                <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                              id="address" 
                              name="address" 
                              rows="3">{{ old('address', $customer->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="col-12">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                              id="notes" 
                              name="notes" 
                              rows="3">{{ old('notes', $customer->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', $customer->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-12">
                    <button type="submit" class="btn-modern btn-modern-primary">
                        <i class="fa fa-save"></i> Update Customer
                    </button>
                    <a href="{{ route('admin.customers.index') }}" class="btn-modern" style="background: #6b7280; color: white;">
                        <i class="fa fa-times"></i> Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
