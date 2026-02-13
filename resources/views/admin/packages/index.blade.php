@extends('layouts.admin')

@section('title', 'Manage Packages')

@section('content')
<div class="container-fluid p-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800"><i class="fa fa-gift"></i> Package Management</h2>
        <a href="{{ route('admin.packages.create') }}" class="btn-modern btn-modern-primary shadow-sm">
            <i class="fa fa-plus-circle me-2"></i> Create New Package
        </a>
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
                   id="packageSearch" 
                   class="form-control search-input" 
                   placeholder="Search packages by name, type, or price..."
                   autocomplete="off">
            <button type="button" class="btn-clear-search text-muted" id="clearSearch" style="display: none; border:none; background:none;">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <div id="searchResults" class="search-results"></div>
    </div>

    <!-- Modern Tab Navigation -->
    <div class="dashboard-widget">
        <ul class="nav nav-tabs modern-tabs" id="packageTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-packages" 
                        type="button" role="tab" aria-controls="all-packages" aria-selected="true">
                    <i class="fa fa-list"></i> All Packages
                    <span class="badge badge-count ms-2">{{ $packages->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="veg-tab" data-bs-toggle="tab" data-bs-target="#veg-packages" 
                        type="button" role="tab" aria-controls="veg-packages" aria-selected="false">
                    <i class="fa fa-leaf text-success"></i> Veg
                    <span class="badge badge-count ms-2">{{ $packages->where('type', 'Veg')->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="nonveg-tab" data-bs-toggle="tab" data-bs-target="#nonveg-packages" 
                        type="button" role="tab" aria-controls="nonveg-packages" aria-selected="false">
                    <i class="fa fa-drumstick-bite text-danger"></i> Non-Veg
                    <span class="badge badge-count ms-2">{{ $packages->where('type', 'Non-Veg')->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="mixed-tab" data-bs-toggle="tab" data-bs-target="#mixed-packages" 
                        type="button" role="tab" aria-controls="mixed-packages" aria-selected="false">
                    <i class="fa fa-cutlery text-warning"></i> Mixed
                    <span class="badge badge-count ms-2">{{ $packages->where('type', 'Mixed')->count() }}</span>
                </button>
            </li>
        </ul>

        <div class="tab-content p-4" id="packageTabContent">
            @foreach(['all' => $packages, 'veg' => $packages->where('type', 'Veg'), 'nonveg' => $packages->where('type', 'Non-Veg'), 'mixed' => $packages->where('type', 'Mixed')] as $key => $items)
                <div class="tab-pane fade {{ $key === 'all' ? 'show active' : '' }}" id="{{ $key }}-packages" role="tabpanel" aria-labelledby="{{ $key }}-tab">
                    @if($items->count() > 0)
                        <div class="modern-card">
                            <div class="modern-card-body">
                                <div class="table-responsive">
                                    <table class="modern-table package-table">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Created Date</th>
                                                <th>Image</th>
                                                <th>Package Name</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Price</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($items as $package)
                                            <tr>
                                                <td><span class="fw-bold text-muted">{{ $loop->iteration }}</span></td>
                                                <td>
                                                    <span class="text-muted small">
                                                        <i class="fa fa-calendar-alt me-1"></i>
                                                        {{ $package->created_at ? $package->created_at->format('d M Y') : 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($package->image)
                                                        <img src="{{ asset($package->image) }}" alt="{{ $package->name }}" style="height: 50px; width: 50px; object-fit: cover; border-radius: 8px;">
                                                    @else
                                                        <div style="height: 50px; width: 50px; background: #f3f4f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                                            <i class="fa fa-gift"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="fw-bold text-dark">{{ $package->name }}</td>
                                                <td>
                                                    @if($package->type === 'Veg')
                                                        <span class="badge-modern" style="background-color: #d1fae5; color: #065f46;"><i class="fa fa-leaf me-1"></i> Veg</span>
                                                    @elseif($package->type === 'Non-Veg')
                                                        <span class="badge-modern" style="background-color: #fee2e2; color: #991b1b;"><i class="fa fa-drumstick-bite me-1"></i> Non-Veg</span>
                                                    @else
                                                        <span class="badge-modern" style="background-color: #fef3c7; color: #92400e;"><i class="fa fa-cutlery me-1"></i> Mixed</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($package->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="fw-bold text-primary">₹{{ number_format($package->price, 2) }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('admin.packages.edit', $package) }}" class="btn-modern btn-modern-primary btn-sm" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn-modern btn-sm" style="background: #ef4444; color: white;" 
                                                                    onclick="return confirm('Delete {{ $package->name }}?')" title="Delete">
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
                            <i class="fa fa-gift fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No packages found in this category.</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('packageSearch');
    const clearBtn = document.getElementById('clearSearch');

    if (!searchInput) return;

    // Search functionality
    function performSearch() {
        const query = searchInput.value.toLowerCase().trim();
        clearBtn.style.display = query ? 'block' : 'none';

        const activePane = document.querySelector('.tab-pane.active');
        if(!activePane) return;
        
        const rows = activePane.querySelectorAll('tbody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(query)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', performSearch);

    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        searchInput.dispatchEvent(new Event('input'));
        searchInput.focus();
    });
    
    // Re-run search when tab is switched
    const tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]');
    tabEls.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (event) {
            performSearch();
        });
    });
});
</script>
@endsection
