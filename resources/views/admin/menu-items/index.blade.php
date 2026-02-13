@extends('layouts.admin')

@section('title', 'Menu Items')
@section('page-title', 'Menu Management')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-gray-800"><i class="fa fa-cutlery"></i> Menu Management</h2>
        <div class="d-flex gap-3">
            <a href="{{ route('admin.menu-items.create') }}" class="btn-modern btn-modern-primary shadow-sm">
                <i class="fa fa-plus"></i> Add New Item
            </a>
            <a href="{{ route('admin.menu-items.export-excel') }}" class="btn-modern shadow-sm text-white" style="background: #10b981;">
                <i class="fa fa-file-excel-o"></i> Excel
            </a>
            <a href="{{ route('admin.menu-items.export-pdf') }}" target="_blank" class="btn-modern shadow-sm text-white" style="background: #ef4444;">
                <i class="fa fa-file-pdf-o"></i> PDF
            </a>
            <a href="{{ route('admin.menu-items.import') }}" class="btn-modern shadow-sm" style="background: #0ea5e9; color: white;">
                <i class="fa fa-file-import"></i> Import Items
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="dashboard-widget mb-4">
        <div class="search-container">
            <i class="fa fa-search search-icon"></i>
            <input type="text" 
                   id="menuSearch" 
                   class="form-control search-input" 
                   placeholder="Search dishes by name, category, or price..."
                   autocomplete="off">
            <button type="button" class="btn-clear-search" id="clearSearch" style="display: none;">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <div id="searchResults" class="search-results"></div>
    </div>

    <!-- Modern Tab Navigation -->
    <div class="dashboard-widget">
        <ul class="nav nav-tabs modern-tabs" id="menuTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual-items" 
                        type="button" role="tab" aria-controls="manual-items" aria-selected="true">
                    <i class="fa fa-cutlery"></i> Food Items 
                    <span class="badge badge-count ms-2">{{ $menuItems->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" 
                        type="button" role="tab" aria-controls="categories" aria-selected="false">
                    <i class="fa fa-folder"></i> Food Categories
                    <span class="badge badge-count ms-2">{{ $categories->count() }}</span>
                </button>
            </li>
        </ul>

        <div class="tab-content p-4" id="menuTabContent">
            <!-- Menu Items Tab -->
            <div class="tab-pane fade show active" id="manual-items" role="tabpanel" aria-labelledby="manual-tab">
                @if($menuItems->count() > 0)
                    <div class="modern-card">
                        <div class="modern-card-body">
                            <div class="table-responsive">
                                <table class="modern-table" id="manualItemsTable">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Created Date</th>
                                            <th>Image</th>
                                            <th>Food Name</th>
                                            <th>Category</th>
                                            <th>Type</th>
                                            <th>Price</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($menuItems as $item)
                                        <tr>
                                            <td><span class="fw-bold text-muted">{{ $loop->iteration }}</span></td>
                                            <td>
                                                <span class="text-muted small">
                                                    <i class="fa fa-calendar-alt me-1"></i>
                                                    {{ $item->created_at ? $item->created_at->format('d M Y') : 'N/A' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($item->image)
                                                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" style="height: 50px; width: 50px; object-fit: cover; border-radius: 8px;">
                                                @else
                                                    <div style="height: 50px; width: 50px; background: #f3f4f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                                        <i class="fa fa-cutlery"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="fw-bold text-dark">{{ $item->name }}</td>
                                            <td>
                                                <span class="badge-modern badge-info">{{ $item->category->name ?? 'Uncategorized' }}</span>
                                            </td>
                                            <td>
                                                @if(Str::lower($item->type) === 'veg')
                                                    <span class="badge-modern" style="background-color: #d1fae5; color: #065f46;"><i class="fa fa-leaf me-1"></i> Veg</span>
                                                @elseif(Str::lower($item->type) === 'non-veg')
                                                    <span class="badge-modern" style="background-color: #fee2e2; color: #991b1b;"><i class="fa fa-drumstick-bite me-1"></i> Non-Veg</span>
                                                @else
                                                    <span class="badge-modern" style="background-color: #d1fae5; color: #065f46;"><i class="fa fa-leaf me-1"></i> Veg</span>
                                                @endif
                                            </td>
                                            <td class="fw-bold text-primary">₹{{ number_format($item->price, 0) }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.menu-items.edit', $item) }}" class="btn-modern btn-modern-primary btn-sm" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.menu-items.destroy', $item) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-modern btn-sm" style="background: #ef4444; color: white;" 
                                                                onclick="return confirm('Delete {{ $item->name }}?')" title="Delete">
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
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fa fa-cutlery fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No menu items found. Click "Add New Item" to create one or "Import Items" to upload list.</p>
                    </div>
                @endif
            </div>

            <!-- Categories Tab -->
            <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="categories-tab">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="modern-card-title mb-0"><i class="fa fa-folder"></i> Food Categories</h3>
                    <a href="{{ route('admin.menu-categories.create') }}" class="btn-modern btn-modern-primary">
                        <i class="fa fa-plus"></i> Add New Category
                    </a>
                </div>

                @if($categories->count() > 0)
                <div class="modern-card">
                    <div class="modern-card-body">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr>
                                        <td>
                                            <span class="fw-bold text-muted">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark">{{ $category->name }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.menu-categories.edit', $category) }}" class="btn-modern btn-modern-primary btn-sm" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.menu-categories.destroy', $category) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-modern btn-sm" style="background: #ef4444; color: white;" 
                                                            onclick="return confirm('Delete {{ $category->name }}?')" title="Delete">
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
                </div>
                @else
                    <div class="text-center py-5">
                        <i class="fa fa-folder-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No categories found. Click "Add New Category" to create one.</p>
                    </div>
                @endif
            </div>
        </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('menuSearch');
    const clearBtn = document.getElementById('clearSearch');
    const searchResults = document.getElementById('searchResults');

    if (!searchInput) return;

    // Tab Activation from URL Hash or Redirect
    const hash = window.location.hash;
    if (hash) {
        const triggerEl = document.querySelector(`.nav-link[data-bs-target="${hash}"]`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    }

    // Search functionality
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();

        // Show/hide clear button
        clearBtn.style.display = query ? 'block' : 'none';

        if (!query) {
            // Reset: show all rows
            const allRows = document.querySelectorAll('.modern-table tbody tr');
            allRows.forEach(row => {
                row.style.display = '';
            });
            searchResults.innerHTML = '';
            
            // Show all category sections if hidden (legacy support, though now we typically have one table)
            document.querySelectorAll('.category-section').forEach(sec => sec.style.display = '');
            return;
        }

        // Filter rows
        let visibleCount = 0;
        const allRows = document.querySelectorAll('.modern-table tbody tr');
        
        allRows.forEach(row => {
            // Updated indices due to Serial Number and Type column addition:
            // 1: Serial
            // 2: Created Date
            // 3: Image
            // 4: Food Name (Name)
            // 5: Category
            // 6: Type
            // 7: Price
            const name = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';
            const category = row.querySelector('td:nth-child(5)')?.textContent.toLowerCase() || '';
            const type = row.querySelector('td:nth-child(6)')?.textContent.toLowerCase() || '';
            const price = row.querySelector('td:nth-child(7)')?.textContent.toLowerCase() || '';
            
            // Allow searching by column text
            const textContent = row.textContent.toLowerCase();

            if (textContent.includes(query)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update results text
        if (visibleCount === 0) {
            searchResults.innerHTML = `
                <div class="no-results">
                    <i class="fa fa-search"></i>
                    <p class="mb-0">No dishes found matching "<strong>${escapeHtml(query)}</strong>"</p>
                </div>
            `;
        } else {
            searchResults.innerHTML = `
                <span class="text-success">
                    <i class="fa fa-check-circle"></i> Found ${visibleCount} dish${visibleCount !== 1 ? 'es' : ''}
                </span>
            `;
        }
    });

    // Clear search
    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        searchInput.dispatchEvent(new Event('input'));
        searchInput.focus();
    });

    // Clear on Escape
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            clearBtn.click();
        }
    });

    // Helper function to escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});
</script>
@endsection
