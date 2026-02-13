@extends('layouts.admin')

@section('title', 'Edit Quotation')

@section('content')
<div class="container-fluid p-4">
    <div class="mb-4">
        <a href="{{ route('admin.quotations.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Back to Quotations
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Edit Quotation - {{ $quotation->quotation_number }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.quotations.update', $quotation) }}" method="POST" id="quotationForm">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">Customer Information</h5>
                        
                        <div class="mb-3">
                            <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                   name="customer_name" value="{{ old('customer_name', $quotation->customer_name) }}" required>
                            @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                                   name="customer_email" value="{{ old('customer_email', $quotation->customer_email) }}" required>
                            @error('customer_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" 
                                   name="customer_phone" value="{{ old('customer_phone', $quotation->customer_phone) }}" required>
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
                                    <option value="{{ $event->title }}" {{ (old('event_type', $quotation->event_type) == $event->title) ? 'selected' : '' }}>{{ $event->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Event Date</label>
                            <input type="date" class="form-control" name="event_date" 
                                   value="{{ old('event_date', $quotation->event_date ? $quotation->event_date->format('Y-m-d') : '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Guest Count</label>
                            <input type="number" class="form-control" name="guest_count" 
                                   value="{{ old('guest_count', $quotation->guest_count) }}" min="1">
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
                    <!-- Items will be populated by JS -->
                </div>
                <button type="button" class="btn btn-secondary btn-sm mb-3" id="addItem">
                    <i class="fa fa-plus"></i> Add Item
                </button>

                <h5 class="mb-3 mt-4">Extra Charges</h5>
                <div id="extraChargesContainer">
                    <!-- Extra charges will be populated by JS -->
                </div>
                <button type="button" class="btn btn-warning btn-sm mb-3 text-white" id="addExtraCharge">
                    <i class="fa fa-plus"></i> Add Extra Charge
                </button>

                <hr class="my-4">

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="3">{{ old('notes', $quotation->notes) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="draft" {{ old('status', $quotation->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="sent" {{ old('status', $quotation->status) == 'sent' ? 'selected' : '' }}>Sent</option>
                                <option value="accepted" {{ old('status', $quotation->status) == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="rejected" {{ old('status', $quotation->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
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
                                    <span>Tax:</span>
                                    <input type="number" class="form-control form-control-sm w-50" name="tax" id="taxInput" 
                                           value="{{ old('tax', $quotation->tax) }}" min="0" step="0.01">
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Discount:</span>
                                    <input type="number" class="form-control form-control-sm w-50" name="discount" id="discountInput" 
                                           value="{{ old('discount', $quotation->discount) }}" min="0" step="0.01">
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
                            <i class="fa fa-save"></i> Update Quotation
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let itemIndex = 100;
let extraIndex = 2000;
const menuCategories = @json($categories);
const existingItems = @json(old('items', $quotation->items ?? []));

function getItemsForCategory(categoryId) {
    if (!categoryId) return [];
    const category = menuCategories.find(c => c.id == categoryId);
    return category ? category.items : [];
}

function findCategoryForItem(itemName) {
    for (const cat of menuCategories) {
        if (cat.items.some(i => i.name === itemName)) {
            return cat.id;
        }
    }
    return '';
}

function updateItemOptions(row, categoryId, selectedItemName = null) {
    const itemSelect = row.querySelector('.item-select');
    itemSelect.innerHTML = '<option value="">Select Item</option>';
    
    const items = getItemsForCategory(categoryId);
    items.forEach(item => {
        const option = document.createElement('option');
        option.value = item.name;
        option.textContent = item.name;
        option.dataset.price = item.price;
        if (selectedItemName && item.name === selectedItemName) {
            option.selected = true;
        }
        itemSelect.appendChild(option);
    });
}

function attachItemHandlers(row) {
    // Category Change
    const catSelect = row.querySelector('.item-category');
    if(catSelect) {
        catSelect.addEventListener('change', function() {
            updateItemOptions(row, this.value);
            // Reset price when category changes manually
            row.querySelector('.item-price').value = '';
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

function createItemRow(item = null, isExtra = false) {
    const index = isExtra ? extraIndex++ : itemIndex++; 
    const isRegularItem = !isExtra;
    
    const div = document.createElement('div');
    if (isExtra) {
        div.className = 'row mb-2 extra-charge-row item-row';
    } else {
        div.className = 'row mb-2 item-row';
    }

    const nameValue = item ? (item.name || '') : '';
    const quantityValue = item ? (item.quantity || 1) : 1;
    const priceValue = item ? (item.price || 0) : 0;

    if (isExtra) {
         div.innerHTML = `
            <div class="col-md-7">
                <input type="text" class="form-control" name="items[${index}][name]" value="${nameValue}" placeholder="Charge Description" required>
                <input type="hidden" name="items[${index}][quantity]" value="1" class="item-quantity">
                <input type="hidden" name="items[${index}][is_extra]" value="1">
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control item-price" name="items[${index}][price]" value="${priceValue}" placeholder="Amount" min="0" step="0.01" required>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm remove-item">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        `;
    } else {
        let categoryId = '';
        if (item) {
            categoryId = findCategoryForItem(nameValue);
        }

        let categoryOptions = '<option value="">Select Category</option>';
        menuCategories.forEach(cat => {
            const selected = (cat.id == categoryId) ? 'selected' : '';
            categoryOptions += `<option value="${cat.id}" ${selected}>${cat.name}</option>`;
        });

        div.innerHTML = `
            <div class="col-md-3">
                <select class="form-select item-category">
                    ${categoryOptions}
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-select item-select" name="items[${index}][name]">
                    <option value="">Select Item</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control item-quantity" name="items[${index}][quantity]" value="${quantityValue}" placeholder="Qty" min="1" required>
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control item-price" name="items[${index}][price]" value="${priceValue}" placeholder="Price" min="0" step="0.01" required>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm remove-item">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        `;
    }

    return div;
}

// Initialize Items
existingItems.forEach(item => {
    const isExtra = item.is_extra == 1 || item.is_extra === true || item.is_extra === "1";
    
    if (isExtra) {
        const row = createItemRow(item, true);
        document.getElementById('extraChargesContainer').appendChild(row);
        // Bind remove for extra
        row.querySelector('.remove-item').addEventListener('click', function() {
            row.remove();
            calculateTotal();
        });
        row.querySelector('.item-price').addEventListener('input', calculateTotal);
    } else {
        const row = createItemRow(item, false);
        document.getElementById('itemsContainer').appendChild(row);
        attachItemHandlers(row);
        
        // Populate items based on detected category
        const catSelect = row.querySelector('.item-category');
        if(catSelect.value) {
            updateItemOptions(row, catSelect.value, item.name);
        }
    }
});

// If no items, add one empty row
if (existingItems.length === 0) {
     const row = createItemRow(null, false);
     document.getElementById('itemsContainer').appendChild(row);
     attachItemHandlers(row);
}

document.getElementById('addItem').addEventListener('click', function() {
    const row = createItemRow(null, false);
    document.getElementById('itemsContainer').appendChild(row);
    attachItemHandlers(row);
});

document.getElementById('addExtraCharge').addEventListener('click', function() {
    const row = createItemRow(null, true);
    document.getElementById('extraChargesContainer').appendChild(row);
    // Bind remove
    row.querySelector('.remove-item').addEventListener('click', function() {
        row.remove();
        calculateTotal();
    });
    row.querySelector('.item-price').addEventListener('input', calculateTotal);
});


function calculateTotal() {
    let subtotal = 0;
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

calculateTotal();
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
