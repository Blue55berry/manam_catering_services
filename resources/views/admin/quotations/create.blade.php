@extends('layouts.admin')

@section('title', 'Create Quotation')

@section('content')
<div class="container-fluid p-4">
    <div class="mb-4">
        <a href="{{ route('admin.quotations.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Back to Quotations
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Create New Quotation</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.quotations.store') }}" method="POST" id="quotationForm">
                @csrf
                
                @if(isset($customer))
                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">Customer Information</h5>

                        <div class="mb-3">
                            <label class="form-label text-muted">Select Existing Customer (Optional)</label>
                            <select class="form-select" id="customerSelect">
                                <option value="">-- Create New / Manual Entry --</option>
                                @foreach($customers as $c)
                                    <option value="{{ $c->id }}" 
                                            data-name="{{ $c->name }}" 
                                            data-email="{{ $c->email }}" 
                                            data-phone="{{ $c->phone_number }}">
                                        {{ $c->name }} ({{ $c->phone_number ?? 'No Phone' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                   id="customerNameInput"
                                   name="customer_name" value="{{ old('customer_name', $booking->name ?? ($customer->name ?? '')) }}" required>
                            @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                                   name="customer_email" value="{{ old('customer_email', $booking->email ?? ($customer->email ?? '')) }}" required>
                            @error('customer_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" 
                                   name="customer_phone" value="{{ old('customer_phone', $booking->contact_number ?? ($customer->phone ?? '')) }}" required>
                            @error('customer_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="mb-3">Event Details</h5>
                        
                        <div class="mb-3">
                            <label class="form-label">Event Type</label>
                            <select class="form-select" name="event_type">
                                <option value="">Select Event Type</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->title }}" {{ (old('event_type') == $event->title) ? 'selected' : '' }}>{{ $event->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Event Date</label>
                            <input type="date" class="form-control" name="event_date" value="{{ old('event_date', isset($booking->event_date) ? \Carbon\Carbon::parse($booking->event_date)->format('Y-m-d') : '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Guest Count</label>
                            <input type="number" class="form-control" name="guest_count" value="{{ old('guest_count', $booking->guest_count ?? ($customer->guest_count ?? '')) }}" min="1">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Select Catering Package</label>
                        <select class="form-select" id="packageSelect">
                            <option value="">-- No Package / Custom Only --</option>
                            @foreach($packages as $package)
                                <option value="{{ $package->id }}" data-name="{{ $package->name }}" data-price="{{ $package->price }}">
                                    {{ $package->name }} (₹{{ number_format($package->price, 2) }} per guest)
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Selecting a package will add it as a line item. You can still add custom items below.</div>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3">Items</h5>
                <div class="row mb-2 fw-bold text-muted small text-uppercase">
                    <div class="col-md-3">Food Category</div>
                    <div class="col-md-4">Food Item</div>
                    <div class="col-md-2">Qty</div>
                    <div class="col-md-2">Price</div>
                    <div class="col-md-1"></div>
                </div>
                <div id="itemsContainer">
                    <div class="row mb-2 item-row">
                        <div class="col-md-3">
                            <select class="form-select item-category">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select item-select" name="items[0][name]">
                                <option value="">Select Item</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control item-quantity" name="items[0][quantity]" placeholder="Qty" min="1" value="1" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control item-price" name="items[0][price]" placeholder="Price" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm remove-item">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm mb-3" id="addItem">
                    <i class="fa fa-plus"></i> Add Item
                </button>

                <h5 class="mb-3 mt-4">Extra Charges</h5>
                <div id="extraChargesContainer">
                    <!-- Extra charges will be added here -->
                </div>
                <button type="button" class="btn btn-warning btn-sm mb-3 text-white" id="addExtraCharge">
                    <i class="fa fa-plus"></i> Add Extra Charge
                </button>

                <hr class="my-4">

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="3">{{ old('notes') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="draft" selected>Draft</option>
                                <option value="sent">Sent</option>
                                <option value="accepted">Accepted</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Pricing Summary</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <strong id="subtotalDisplay">₹0.00</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax (0%):</span>
                                    <input type="number" class="form-control form-control-sm w-50" name="tax" id="taxInput" value="0" min="0" step="0.01">
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Discount:</span>
                                    <input type="number" class="form-control form-control-sm w-50" name="discount" id="discountInput" value="0" min="0" step="0.01">
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <strong>Total:</strong>
                                    <strong id="totalDisplay" class="text-success">₹0.00</strong>
                                </div>
                                <input type="hidden" name="subtotal" id="subtotalInput" value="0">
                                <input type="hidden" name="total" id="totalInput" value="0">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 mt-3">
                            <i class="fa fa-save"></i> Create Quotation
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let itemIndex = 1;
let extraIndex = 1000; // Start high to avoid collision with items
const menuCategories = @json($categories);

function getItemsForCategory(categoryId) {
    if (!categoryId) return [];
    const category = menuCategories.find(c => c.id == categoryId);
    return category ? category.items : [];
}

function updateItemOptions(row, categoryId) {
    const itemSelect = row.querySelector('.item-select');
    itemSelect.innerHTML = '<option value="">Select Item</option>';
    
    const items = getItemsForCategory(categoryId);
    items.forEach(item => {
        const option = document.createElement('option');
        option.value = item.name;
        option.textContent = item.name;
        option.dataset.price = item.price;
        itemSelect.appendChild(option);
    });
}

function attachItemHandlers(row) {
    // Category Change
    const catSelect = row.querySelector('.item-category');
    if(catSelect) {
        catSelect.addEventListener('change', function() {
            updateItemOptions(row, this.value);
        });
    }

    // Item Change (Update Price)
    const itemSelect = row.querySelector('.item-select');
    if(itemSelect) {
        itemSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.dataset.price;
            if(price) {
                row.querySelector('.item-price').value = price;
                calculateTotal();
            }
        });
    }

    // Remove Handler
    const removeBtn = row.querySelector('.remove-item');
    if(removeBtn) {
        removeBtn.addEventListener('click', function() {
            row.remove();
            calculateTotal();
        });
    }

    // Input changes for calculation
    row.querySelectorAll('input, select').forEach(input => {
        input.addEventListener('input', calculateTotal);
        input.addEventListener('change', calculateTotal);
    });
}


document.getElementById('addItem').addEventListener('click', function() {
    const container = document.getElementById('itemsContainer');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2 item-row';
    
    let categoryOptions = '<option value="">Select Category</option>';
    menuCategories.forEach(cat => {
        categoryOptions += `<option value="${cat.id}">${cat.name}</option>`;
    });

    newRow.innerHTML = `
        <div class="col-md-3">
            <select class="form-select item-category">
                ${categoryOptions}
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-select item-select" name="items[${itemIndex}][name]">
                <option value="">Select Item</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" class="form-control item-quantity" name="items[${itemIndex}][quantity]" placeholder="Qty" min="1" value="1" required>
        </div>
        <div class="col-md-2">
            <input type="number" class="form-control item-price" name="items[${itemIndex}][price]" placeholder="Price" min="0" step="0.01" required>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-sm remove-item">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
    attachItemHandlers(newRow);
    itemIndex++;
});

// Extra Charges Handler
document.getElementById('addExtraCharge').addEventListener('click', function() {
    const container = document.getElementById('extraChargesContainer');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2 extra-charge-row item-row'; // Add item-row class for calculation
    
    newRow.innerHTML = `
        <div class="col-md-7">
            <input type="text" class="form-control" name="items[${extraIndex}][name]" placeholder="Charge Description (e.g. Cleaning, Travel)" required>
            <input type="hidden" name="items[${extraIndex}][quantity]" value="1" class="item-quantity">
            <input type="hidden" name="items[${extraIndex}][is_extra]" value="1">
        </div>
        <div class="col-md-4">
            <input type="number" class="form-control item-price" name="items[${extraIndex}][price]" placeholder="Amount" min="0" step="0.01" required>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-sm remove-item">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
    
    // Attach remove listener manually since it's simple
    newRow.querySelector('.remove-item').addEventListener('click', function() {
        newRow.remove();
        calculateTotal();
    });
    
    newRow.querySelector('.item-price').addEventListener('input', calculateTotal);
    
    extraIndex++;
});

function calculateTotal() {
    let subtotal = 0;
    
    // Calculate regular items and extra charges (both have .item-row class)
    document.querySelectorAll('.item-row').forEach(row => {
        const qtyInput = row.querySelector('.item-quantity');
        const priceInput = row.querySelector('.item-price');
        
        const qty = qtyInput ? (parseFloat(qtyInput.value) || 0) : 1;
        const price = priceInput ? (parseFloat(priceInput.value) || 0) : 0;
        
        subtotal += qty * price;
    });
    
    const tax = parseFloat(document.getElementById('taxInput').value) || 0;
    const discount = parseFloat(document.getElementById('discountInput').value) || 0;
    const total = subtotal + tax - discount;
    
    document.getElementById('subtotalDisplay').textContent = '₹' + subtotal.toFixed(2);
    document.getElementById('totalDisplay').textContent = '₹' + total.toFixed(2);
    document.getElementById('subtotalInput').value = subtotal.toFixed(2);
    document.getElementById('totalInput').value = total.toFixed(2);
}

document.getElementById('taxInput').addEventListener('input', calculateTotal);
document.getElementById('discountInput').addEventListener('input', calculateTotal);

// Initialize handlers for the first default row
const firstRow = document.querySelector('.item-row');
if(firstRow) {
    attachItemHandlers(firstRow);
}

calculateTotal();

// Customer Selection Handler
const customerSelect = document.getElementById('customerSelect');
if(customerSelect) {
    customerSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if(selectedOption.value) {
            document.getElementById('customerNameInput').value = selectedOption.dataset.name || '';
            document.querySelector('input[name="customer_email"]').value = selectedOption.dataset.email || '';
            document.querySelector('input[name="customer_phone"]').value = selectedOption.dataset.phone || '';
        }
    });
}
// Package Selection Handler
const packageSelect = document.getElementById('packageSelect');
if(packageSelect) {
    packageSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if(!selectedOption.value) return;

        const name = selectedOption.dataset.name;
        const price = parseFloat(selectedOption.dataset.price) || 0;
        const guests = parseInt(document.querySelector('input[name="guest_count"]').value) || 1;

        // Add a new row for the package
        const container = document.getElementById('itemsContainer');
        const newRow = document.createElement('div');
        newRow.className = 'row mb-2 item-row';
        
        newRow.innerHTML = `
            <div class="col-md-3">
                <input type="text" class="form-control" value="Catering Package" readonly>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control item-select" name="items[${itemIndex}][name]" value="${name}" required>
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control item-quantity" name="items[${itemIndex}][quantity]" placeholder="Qty" min="1" value="${guests}" required>
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control item-price" name="items[${itemIndex}][price]" placeholder="Price" min="0" step="0.01" value="${price}" required>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm remove-item">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newRow);
        
        // Attach remove listener and calculation handlers
        newRow.querySelector('.remove-item').addEventListener('click', function() {
            newRow.remove();
            calculateTotal();
        });
        
        newRow.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', calculateTotal);
        });

        itemIndex++;
        calculateTotal();
        
        // Reset selection
        this.value = '';
    });
}
</script>
@endsection
