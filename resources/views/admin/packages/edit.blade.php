@extends('layouts.admin')

@section('title', 'Edit Package')

@section('content')
<div class="container-fluid p-4">
    <div class="mb-4">
        <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Back to Packages
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0 text-primary fw-bold">Edit Package: {{ $package->name }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.packages.update', $package->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <!-- Basic Details -->
                        <div class="mb-4">
                            <h5 class="text-muted border-bottom pb-2 mb-3">Basic Information</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Package Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $package->name) }}" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type') is-invalid @enderror" name="type" required>
                                        <option value="Veg" {{ $package->type == 'Veg' ? 'selected' : '' }}>Vegetarian</option>
                                        <option value="Non-Veg" {{ $package->type == 'Non-Veg' ? 'selected' : '' }}>Non-Vegetarian</option>
                                        <option value="Mixed" {{ $package->type == 'Mixed' ? 'selected' : '' }}>Mixed</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Price (₹) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $package->price) }}" required min="0" step="0.01">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="3">{{ old('description', $package->description) }}</textarea>
                                </div>
                                <div class="col-12 mb-3">
                                     <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="isActive" name="is_active" value="1" {{ $package->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="isActive">Active</label>
                                    </div>
                                </div>
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
                                
                                @if(!empty($package->menu_content))
                                    @foreach($package->menu_content as $index => $category)
                                        <div class="menu-category-item border rounded mb-3 bg-light menu-category-item-existing">
                                            <div class="d-flex align-items-center p-2 border-bottom">
                                                <div class="me-2 text-muted"><i class="fa fa-bars handle"></i></div>
                                                <select class="form-select form-select-sm fw-bold w-50 category-select-existing bg-white" name="menu_content[{{ $index }}][category]" data-value="{{ $category['category'] ?? '' }}" required>
                                                    <option value="">Select Category</option>
                                                </select>
                                                <div class="ms-auto">
                                                    <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-category"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                            <div class="p-2 ps-4 bg-white rounded-bottom">
                                                <div class="items-list">
                                                    @if(isset($category['items']) && is_array($category['items']))
                                                        @foreach($category['items'] as $item)
                                                            <div class="d-flex align-items-center mb-2 item-row">
                                                                <span class="text-muted me-2"><i class="fa fa-circle" style="font-size: 5px;"></i></span>
                                                                <select class="form-select form-select-sm item-select-existing" name="menu_content[{{ $index }}][items][]" data-value="{{ $item }}" required>
                                                                     <option value="">Select Item</option>
                                                                </select>
                                                                <button type="button" class="btn btn-link text-danger btn-sm ms-2 remove-item"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <button type="button" class="btn btn-sm btn-light text-primary border mt-2 add-item-btn-existing" data-cat-index="{{ $index }}">
                                                    <i class="fa fa-plus ms-1"></i> Add Item
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div id="emptyMenuMsg" class="text-muted text-center py-4" style="{{ !empty($package->menu_content) ? 'display:none;' : '' }}">
                                    <i class="fa fa-cutlery mb-2" style="font-size: 24px;"></i>
                                    <p class="mb-0">No menu categories added. Click "Add Category" to start building the menu.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Features -->
                        <div class="mb-4">
                            <h5 class="text-muted border-bottom pb-2 mb-3">Package Features</h5>
                            <div id="featuresList">
                                @if(!empty($package->features))
                                    @foreach($package->features as $feature)
                                        <div class="input-group mb-2 feature-item">
                                            <span class="input-group-text"><i class="fa fa-check text-success"></i></span>
                                            <input type="text" class="form-control" name="features[]" value="{{ $feature }}" placeholder="Feature">
                                            <button type="button" class="btn btn-outline-danger remove-feature"><i class="fa fa-times"></i></button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary w-100" id="addFeatureBtn">
                                <i class="fa fa-plus"></i> Add Feature
                            </button>
                        </div>
                    </div>
                </div>

                <div class="border-top pt-3 mt-3">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="fa fa-save"></i> Update Package
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
    // Existing data passed to PHP view is rendered directly, 
    // but for dynamic editing we need to make sure the selects work.
    // The existing PHP loop for filled data renders input[type=text].
    // We should probably replace that with selects too, but that's complex to re-render in PHP with all options.
    // EASIER APPROACH: Let JS handle the rendering of existing data too?
    // OR: Just keep the PHP loop but change input to select and populate options.
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
    
    // Start index comes from PHP count
    let categoryIndex = {{ !empty($package->menu_content) ? count($package->menu_content) + 1 : 0 }};

    // Helper to populate options
    function populateCategoryOptions(selectElement, selectedValue = null) {
        menuCategories.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat.name;
            option.textContent = cat.name;
            option.dataset.id = cat.id;
            if (selectedValue && cat.name === selectedValue) {
                option.selected = true;
            }
            selectElement.appendChild(option);
        });
    }

    function populateItemOptions(selectElement, categoryId, selectedValue = null) {
        const categoryData = menuCategories.find(c => c.id == categoryId);
        if (categoryData && categoryData.active_menu_items) {
             categoryData.active_menu_items.forEach(item => {
                const option = document.createElement('option');
                option.value = item.name;
                option.textContent = item.name;
                if (selectedValue && item.name === selectedValue) {
                    option.selected = true;
                }
                selectElement.appendChild(option);
             });
        }
    }

    // Initialize existing Categories (rendered via PHP loop in Edit View)
    // Actually, asking PHP to render Selects with all options is messy.
    // Better: Render empty selects in PHP loop, then use JS to populate them on load.
    
    // Let's grab all querySelectorAll('.category-select-existing')
    // Wait, I need to update the PHP loop first to use <select class="category-select-existing"> instead of input.
    // See the 'ReplacementContent' for the PHP loop below.

    addCategoryBtn.addEventListener('click', function() {
        document.getElementById('emptyMenuMsg').style.display = 'none';
        
        const clone = categoryTemplate.content.cloneNode(true);
        const card = clone.querySelector('.menu-category-item');
        
        // Update input names with unique index
        const catSelect = card.querySelector('.category-select');
        catSelect.name = catSelect.name.replace('INDEX', categoryIndex);
        
        populateCategoryOptions(catSelect);

        // Add item button handler specific to this category
        const addItemBtn = card.querySelector('.add-item-btn');
        const itemsList = card.querySelector('.items-list');
        const currentCatIndex = categoryIndex;

        // Handle Category Change
        catSelect.addEventListener('change', function() {
            const selectedCatId = this.options[this.selectedIndex].dataset.id;
             itemsList.innerHTML = '';
            if (selectedCatId) {
                addItemBtn.style.display = 'inline-block';
            } else {
                addItemBtn.style.display = 'none';
            }
        });

        addItemBtn.addEventListener('click', function() {
            const selectedCatId = catSelect.options[catSelect.selectedIndex].dataset.id;
            const itemClone = itemTemplate.content.cloneNode(true);
            const itemSelect = itemClone.querySelector('.item-select');
            itemSelect.name = itemSelect.name.replace('CAT_INDEX', currentCatIndex);
            
            populateItemOptions(itemSelect, selectedCatId);
            itemsList.appendChild(itemClone);
        });

        menuBuilder.appendChild(card);
        categoryIndex++;
    });

    menuBuilder.addEventListener('click', function(e) {
        if(e.target.closest('.remove-category')) {
            e.target.closest('.menu-category-item').remove();
            if(menuBuilder.querySelectorAll('.menu-category-item').length === 0) {
                document.getElementById('emptyMenuMsg').style.display = 'block';
            }
        }
        if(e.target.closest('.remove-item')) {
            e.target.closest('.item-row').remove();
        }
        
        // Handle "Add Item" for EXISTING categories (if we add logic for them)
        if(e.target.classList.contains('add-item-btn-existing')) {
            const btn = e.target;
            const card = btn.closest('.menu-category-item');
            const itemsList = card.querySelector('.items-list');
            const catSelect = card.querySelector('.category-select-existing');
            const catIndex = btn.dataset.catIndex;
            
            const selectedCatId = catSelect.options[catSelect.selectedIndex].dataset.id;
            
            const itemClone = itemTemplate.content.cloneNode(true);
            const itemSelect = itemClone.querySelector('.item-select');
            itemSelect.name = itemSelect.name.replace('CAT_INDEX', catIndex);
            
            populateItemOptions(itemSelect, selectedCatId);
            itemsList.appendChild(itemClone);
        }
    });

    // --- Initialize Existing Data ---
    document.querySelectorAll('.menu-category-item-existing').forEach(card => {
        const catSelect = card.querySelector('.category-select-existing');
        const initialValue = catSelect.getAttribute('data-value');
        
        populateCategoryOptions(catSelect, initialValue);
        
        // Find the selected ID
        const selectedOption = Array.from(catSelect.options).find(opt => opt.value === initialValue);
        const catId = selectedOption ? selectedOption.dataset.id : null;
        
        if (catId) {
             // Now populate existing items for this category
             card.querySelectorAll('.item-select-existing').forEach(itemSelect => {
                 const initialItemValue = itemSelect.getAttribute('data-value');
                 populateItemOptions(itemSelect, catId, initialItemValue);
             });
             
             // Handle future items added to this existing category
             card.querySelector('.add-item-btn-existing').style.display = 'inline-block';
             
             // Handle category change for existing
             catSelect.addEventListener('change', function() {
                 const newId = this.options[this.selectedIndex].dataset.id;
                 card.querySelector('.items-list').innerHTML = ''; // Clear items if cat changes
             });
        }
    });
});
</script>
@endsection
