@extends('layouts.admin')

@section('title', 'Add New Customer')
@section('page-title', 'Add New Customer')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">
            <i class="fa fa-user-plus"></i> Add New Customer
        </h2>
        <a href="{{ route('admin.customers.index') }}" class="btn-modern" style="background: #6b7280; color: white;">
            <i class="fa fa-arrow-left"></i> Back to Customers
        </a>
    </div>

    <div class="modern-card">
        <form action="{{ route('admin.customers.store') }}" method="POST">
            @csrf
            
            <div class="row g-3">
                <!-- Name -->
                <div class="col-md-6">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
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
                           value="{{ old('email') }}" 
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
                           value="{{ old('phone') }}" 
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
                           value="{{ old('guest_count') }}"
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
                           value="{{ old('city') }}">
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
                           value="{{ old('state') }}">
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
                           value="{{ old('pincode') }}">
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
                              rows="3">{{ old('address') }}</textarea>
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
                              rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Food Preferences -->
                <div class="col-12">
                    <h5 class="mb-3 mt-2"><i class="fa fa-cutlery"></i> Food Preferences</h5>
                    <div class="bg-light p-4 rounded border">
                        <div id="foodPreferencesContainer">
                            <div class="row g-2 mb-2 food-pref-row">
                                <div class="col-md-4">
                                    <select class="form-select pref-category" name="food_preferences[0][category_id]">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <select class="form-select pref-item" name="food_preferences[0][name]">
                                        <option value="">Select Dish</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-sm remove-pref w-100">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-secondary mt-2" id="addPref">
                            <i class="fa fa-plus"></i> Add Item
                        </button>
                    </div>
                </div>

                <!-- Active Status -->
                <!-- <div class="col-12 mt-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                </div> -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    let prefIndex = 1;
    const menuCategories = @json($categories);

    function getItemsForCategory(categoryId) {
        if (!categoryId) return [];
        const category = menuCategories.find(c => c.id == categoryId);
        return category ? category.items : [];
    }

    function updateItemOptions(row, categoryId) {
        const itemSelect = row.querySelector('.pref-item');
        itemSelect.innerHTML = '<option value="">Select Dish</option>';
        
        const items = getItemsForCategory(categoryId);
        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item.name;
            option.textContent = item.name;
            itemSelect.appendChild(option);
        });
    }

    function createPrefRow(index) {
        const div = document.createElement('div');
        div.className = 'row g-2 mb-2 food-pref-row';
        
        let categoryOptions = '<option value="">Select Category</option>';
        menuCategories.forEach(cat => {
            categoryOptions += `<option value="${cat.id}">${cat.name}</option>`;
        });

        div.innerHTML = `
            <div class="col-md-4">
                <select class="form-select pref-category" name="food_preferences[${index}][category_id]">
                    ${categoryOptions}
                </select>
            </div>
            <div class="col-md-7">
                <select class="form-select pref-item" name="food_preferences[${index}][name]">
                    <option value="">Select Dish</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm remove-pref w-100">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        `;
        return div;
    }

    function attachHandlers(row) {
        // Remove handler
        row.querySelector('.remove-pref').addEventListener('click', function() {
            if(document.querySelectorAll('.food-pref-row').length > 1) {
                row.remove();
            } else {
                // If it's the last row, just clear values
                row.querySelector('.pref-category').value = '';
                row.querySelector('.pref-item').innerHTML = '<option value="">Select Dish</option>';
            }
        });

        // Category change handler
        const categorySelect = row.querySelector('.pref-category');
        categorySelect.addEventListener('change', function() {
            updateItemOptions(row, this.value);
        });
    }

    document.getElementById('addPref').addEventListener('click', function() {
        const container = document.getElementById('foodPreferencesContainer');
        const newRow = createPrefRow(prefIndex);
        container.appendChild(newRow);
        attachHandlers(newRow);
        prefIndex++;
    });

    // Initialize first row
    const firstRow = document.querySelector('.food-pref-row');
    if (firstRow) attachHandlers(firstRow);
});
</script>

                <!-- Submit Button -->
                <div class="col-12">
                    <button type="submit" class="btn-modern btn-modern-primary">
                        <i class="fa fa-save"></i> Save Customer
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
