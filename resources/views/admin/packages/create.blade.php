@extends('layouts.admin')

@section('title', 'Create Package')

@section('content')
<div class="container-fluid p-4">
    <div class="mb-4">
        <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Back to Packages
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0 text-primary fw-bold">Create New Package</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.packages.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <!-- Basic Details -->
                        <div class="mb-4">
                            <h5 class="text-muted border-bottom pb-2 mb-3">Basic Information</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Package Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="e.g. Royal Veg Package">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type') is-invalid @enderror" name="type" required>
                                        <option value="Veg">Vegetarian</option>
                                        <option value="Non-Veg">Non-Vegetarian</option>
                                        <option value="Mixed">Mixed</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Price (₹) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" required min="0" step="0.01">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="3" placeholder="Brief description of the package...">{{ old('description') }}</textarea>
                                </div>
                                <!-- <div class="col-12 mb-3">
                                     <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="isActive" name="is_active" value="1" checked>
                                        <label class="form-check-label" for="isActive">Active</label>
                                    </div>
                                </div> -->
                            </div>
                        </div>

                        <!-- Menu Builder -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                                <h5 class="text-muted mb-0">Menu Structure</h5>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="addCategoryBtn">
                                    <i class="fa fa-plus"></i> Add Category
                                </button>
                            </div>
                            <div id="menuBuilder" class="bg-light p-3 rounded">
                                <p class="text-muted text-center small fst-italic" id="emptyMenuMsg">No menu categories added yet.</p>
                                <!-- Categories will be added here -->
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Features -->
                        <div class="mb-4">
                            <h5 class="text-muted border-bottom pb-2 mb-3">Package Features</h5>
                            <small class="text-muted d-block mb-2">Bullet points shown on the card (e.g., "3 Starters")</small>
                            <div id="featuresList">
                                <!-- Feature Inputs -->
                                <div class="input-group mb-2 feature-item">
                                    <span class="input-group-text"><i class="fa fa-check text-success"></i></span>
                                    <input type="text" class="form-control" name="features[]" placeholder="Feature (e.g. Welcome Drink)">
                                    <button type="button" class="btn btn-outline-danger remove-feature"><i class="fa fa-times"></i></button>
                                </div>
                                <div class="input-group mb-2 feature-item">
                                    <span class="input-group-text"><i class="fa fa-check text-success"></i></span>
                                    <input type="text" class="form-control" name="features[]" placeholder="Feature">
                                    <button type="button" class="btn btn-outline-danger remove-feature"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary w-100" id="addFeatureBtn">
                                <i class="fa fa-plus"></i> Add Feature
                            </button>
                        </div>
                    </div>
                </div>

                <div class="border-top pt-3 mt-3">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="fa fa-save"></i> Save Package
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<template id="categoryTemplate">
    <div class="menu-category-item border rounded mb-3 bg-light">
        <div class="d-flex align-items-center p-2 border-bottom">
            <div class="me-2 text-muted"><i class="fa fa-bars handle"></i></div>
            <select class="form-select form-select-sm fw-bold w-50 category-select bg-white" name="menu_content[INDEX][category]" required>
                <option value="">Select Category</option>
                <!-- Options populated via JS -->
            </select>
            <div class="ms-auto">
                <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-category" title="Remove Category"><i class="fa fa-trash"></i></button>
            </div>
        </div>
        <div class="p-2 ps-4 bg-white rounded-bottom">
            <div class="items-list">
                <!-- Items go here -->
            </div>
            <button type="button" class="btn btn-sm btn-light text-primary border mt-2 add-item-btn" style="display:none;">
                <i class="fa fa-plus ms-1"></i> Add Item
            </button>
        </div>
    </div>
</template>

<template id="itemTemplate">
    <div class="d-flex align-items-center mb-2 item-row">
        <span class="text-muted me-2"><i class="fa fa-circle" style="font-size: 5px;"></i></span>
        <select class="form-select form-select-sm item-select" name="menu_content[CAT_INDEX][items][]" required>
            <option value="">Select Item</option>
             <!-- Options populated via JS -->
        </select>
        <button type="button" class="btn btn-link text-danger btn-sm ms-2 remove-item"><i class="fa fa-times"></i></button>
    </div>
</template>

<script>
    // Pass categories data to JS from Controller
    const menuCategories = @json($categories);
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Features ---
    const featuresList = document.getElementById('featuresList');
    const addFeatureBtn = document.getElementById('addFeatureBtn');

    addFeatureBtn.addEventListener('click', function() {
        const div = document.createElement('div');
        div.className = 'input-group mb-2 feature-item';
        div.innerHTML = `
            <span class="input-group-text"><i class="fa fa-check text-success"></i></span>
            <input type="text" class="form-control" name="features[]" placeholder="Feature">
            <button type="button" class="btn btn-outline-danger remove-feature"><i class="fa fa-times"></i></button>
        `;
        featuresList.appendChild(div);
    });

    featuresList.addEventListener('click', function(e) {
        if(e.target.closest('.remove-feature')) {
            e.target.closest('.feature-item').remove();
        }
    });

    // --- Menu Builder ---
    const menuBuilder = document.getElementById('menuBuilder');
    const addCategoryBtn = document.getElementById('addCategoryBtn');
    const categoryTemplate = document.getElementById('categoryTemplate');
    const itemTemplate = document.getElementById('itemTemplate');
    let categoryIndex = 0;

    addCategoryBtn.addEventListener('click', function() {
        document.getElementById('emptyMenuMsg').style.display = 'none';
        
        const clone = categoryTemplate.content.cloneNode(true);
        const card = clone.querySelector('.menu-category-item');
        
        // Update input names with unique index
        const catSelect = card.querySelector('.category-select');
        catSelect.name = catSelect.name.replace('INDEX', categoryIndex);
        
        // Populate Category Dropdown
        menuCategories.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat.name; // Store Name for compatibility
            option.textContent = cat.name;
            option.dataset.id = cat.id; // Store ID for filtering items
            catSelect.appendChild(option);
        });

        // Add item button handler specific to this category
        const addItemBtn = card.querySelector('.add-item-btn');
        const itemsList = card.querySelector('.items-list');
        const currentCatIndex = categoryIndex; // Closure capture

        // Handle Category Change
        catSelect.addEventListener('change', function() {
            const selectedCatId = this.options[this.selectedIndex].dataset.id;
            
            // Clear existing items if category changes? Maybe warn user?
            // For now, just clear list to avoid mismatches.
            itemsList.innerHTML = '';
            
            if (selectedCatId) {
                addItemBtn.style.display = 'inline-block';
            } else {
                addItemBtn.style.display = 'none';
            }
        });

        addItemBtn.addEventListener('click', function() {
            const selectedCatId = catSelect.options[catSelect.selectedIndex].dataset.id;
            const categoryData = menuCategories.find(c => c.id == selectedCatId);
            
            if(!categoryData) return;

            const itemClone = itemTemplate.content.cloneNode(true);
            const itemSelect = itemClone.querySelector('.item-select');
            itemSelect.name = itemSelect.name.replace('CAT_INDEX', currentCatIndex);
            
            // Populate Item Dropdown based on selected Category
            if(categoryData.active_menu_items) {
                 categoryData.active_menu_items.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.name;
                    option.textContent = item.name;
                    itemSelect.appendChild(option);
                 });
            }

            itemsList.appendChild(itemClone);
        });

        menuBuilder.appendChild(card);
        categoryIndex++;
    });

    menuBuilder.addEventListener('click', function(e) {
        if(e.target.closest('.remove-category')) {
            e.target.closest('.menu-category-item').remove();
            if(menuBuilder.children.length <= 1) { // 1 because of the hidden p tag
                document.getElementById('emptyMenuMsg').style.display = 'block';
            }
        }
        if(e.target.closest('.remove-item')) {
            e.target.closest('.item-row').remove();
        }
    });
});
</script>
@endsection
