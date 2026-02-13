@extends('layouts.app')

@section('title', 'South Indian Menu - Dakshin Flavors')

@section('content')

<style>
    /* ROYAL THEME FOR MENU PAGE */

    /* 1. Animated Background Pattern */
    .dakshin-menu-section {
        position: relative;
        background-color: #FAFAF5 !important; /* Royal Cream Base */
        z-index: 1;
        overflow: hidden;
        padding-top: 60px;
        padding-bottom: 80px;
    }

    .dakshin-menu-section::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset("assets/images/bg-leaf.svg") }}'); 
        background-size: 60px 60px;
        background-repeat: repeat;
        opacity: 0.4; /* Increased Visibility */
        z-index: -1; 
        pointer-events: none;
        animation: leafVerticalAnim 10s linear infinite; /* Vertical Animation from Home */
    }

    @keyframes leafVerticalAnim {
        0% { background-position: 0 0; }
        100% { background-position: 0 60px; } 
    }

    /* 2. Typography */
    .dakshin-menu-title h2 {
        font-family: 'Playfair Display', serif !important;
        font-weight: 700;
        color: #1B4D3E !important; /* Royal Green */
        margin-bottom: 10px;
    }
    .dakshin-menu-title p {
        color: #DAA520 !important; /* Gold */
        font-family: 'Inter', sans-serif;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    /* 3. Royal Toggle Buttons */
    .dakshin-toggle-container {
        background: #FFFDF5;
        border: 1px solid rgba(218, 165, 32, 0.3);
        padding: 5px;
        border-radius: 50px;
        display: inline-flex;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .dakshin-toggle-btn {
        background: transparent;
        color: #1B4D3E;
        border: none;
        padding: 10px 30px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .dakshin-toggle-btn.active {
        background: #1B4D3E; /* Royal Green */
        color: #DAA520; /* Royal Gold */
        box-shadow: 0 4px 10px rgba(27, 77, 62, 0.3);
    }
    .dakshin-toggle-btn:hover:not(.active) {
        color: #DAA520;
    }

    /* 4. Menu Cards - Royal Parchment Style */
    .dakshin-card {
        background-color: #FFFDF5 !important; /* Milder Cream Parchment */
        border: 1px solid rgba(218, 165, 32, 0.25) !important;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        height: 100%;
    }
    
    .card-content {
        padding: 20px;
        background-color: #FFFDF5 !important;
        transition: background 0.3s ease;
    }

    /* Hover Effect: Gradient from Bottom */
    .dakshin-card:hover .card-content {
        background: linear-gradient(to top, #ffeac2 0%, #FFFDF5 80%) !important;
    }
    .dakshin-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        border-color: rgba(218, 165, 32, 0.6) !important;
    }

    /* Card Typography */
    .card-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: #1B4D3E;
        font-size: 1.25rem;
    }
    .card-desc {
        color: #555;
        font-size: 0.9rem;
        line-height: 1.6;
    }
    .diet-icon.veg { color: #4CAF50; }
    .diet-icon.non-veg { color: #D32F2F; }
    
    .badge-pop {
        background: #DAA520 !important;
        color: #1B4D3E !important;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 5px 10px;
        text-transform: uppercase;
        border-radius: 4px;
    }
    
    .spice-level {
        color: #DAA520;
        font-size: 0.85rem;
        font-weight: 600;
        margin-top: 10px;
    }
</style>

@php
// Reusable images for repeated use if item has no image
$dummyImages = [
    '01.png', '02.png', '03.png', '04.png', '05.png', '06.png', '07.png', '08.png', '09.png', '10.png'
];
@endphp

<section class="dakshin-menu-section">
    <div class="container">
        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <div class="dakshin-menu-title">
                    <h2 class="modern">Manam Catering Service</h2>
                    <p>Authentic Royal Menu</p>
                </div>
            </div>
        </div>

        <!-- Main Layout: Sidebar & Content -->
        <div class="row mt-5">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="menu-sidebar sticky-top" style="top: 100px; max-height: 80vh; overflow-y: auto; padding-right: 10px;">
                    <h5 class="sidebar-title mb-4" style="font-family: 'Playfair Display', serif; color: #1B4D3E; border-bottom: 2px solid #DAA520; padding-bottom: 10px;">Menu Categories</h5>
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach($menuCategories as $category)
                            <button class="nav-link text-start mb-2 dakshin-toggle-btn {{ $loop->first ? 'active' : '' }}" 
                                    data-filter="{{ $category->slug }}"
                                    style="border-radius: 5px; font-weight: 500; font-family: 'Inter', sans-serif;">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Mobile Dropdown for Categories (Visible only on small screens) -->
            <div class="col-12 d-lg-none mb-4">
                <select class="form-select mobile-cat-select" onchange="filterItems(this.value)">
                    @foreach($menuCategories as $category)
                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Menu Grid Content -->
            <div class="col-lg-9">
                <div class="dakshin-grid">             
                    @php $imgIndex = 0; @endphp
                    @foreach($menuCategories as $category)
                        @foreach($category->activeMenuItems as $item)
                        @php 
                            // Use item image if available, else cycle through dummy images
                            if ($item->image) {
                                $imgSrc = asset($item->image);
                            } else {
                                $imgName = $dummyImages[$imgIndex % count($dummyImages)];
                                $imgSrc = asset('assets/images/main/static-menu-images/' . $imgName);
                                $imgIndex++;
                            }
                        @endphp
                        <div class="dakshin-card-col" data-category="{{ $category->slug }}">
                            <div class="dakshin-card">
                                <div class="card-image-wrapper">
                                    <img src="{{ $imgSrc }}" alt="{{ $item->name }}" class="card-img">
                                </div>
                                <div class="card-content">
                                    <div class="card-header-row">
                                        <h3 class="card-title">
                                            {{ $item->name }}
                                            @if(Str::lower($item->type) === 'veg')
                                                <i class="fa fa-circle text-success ms-2" style="font-size: 10px; border: 1px solid green; padding: 1px; border-radius: 2px;" title="Veg"></i>
                                            @elseif(Str::lower($item->type) === 'non-veg')
                                                <i class="fa fa-circle text-danger ms-2" style="font-size: 10px; border: 1px solid red; padding: 1px; border-radius: 2px;" title="Non-Veg"></i>
                                            @endif
                                        </h3>
                                    </div>
                                    <p class="card-desc">{{ $item->description ?? 'Delicious option prepared with authentic spices.' }}</p>
                                    <div class="spice-level">
                                        <i class="fa fa-tag" style="color:#DAA520"></i> <span class="fw-bold text-dark">₹{{ $item->price }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Custom Scrollbar for Sidebar */
    .menu-sidebar::-webkit-scrollbar {
        width: 5px;
    }
    .menu-sidebar::-webkit-scrollbar-track {
        background: #f1f1f1; 
    }
    .menu-sidebar::-webkit-scrollbar-thumb {
        background: #DAA520; 
        border-radius: 5px;
    }

    /* Sidebar Link Styles */
    .nav-link.dakshin-toggle-btn {
        color: #555;
        background: transparent;
        transition: all 0.3s;
        border: 1px solid transparent;
    }
    .nav-link.dakshin-toggle-btn:hover {
        background-color: rgba(218, 165, 32, 0.1);
        color: #1B4D3E;
        padding-left: 20px; /* Slight movement effect */
    }
    .nav-link.dakshin-toggle-btn.active {
        background-color: #1B4D3E !important;
        color: #DAA520 !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtns = document.querySelectorAll('.dakshin-toggle-btn');
        const menuItems = document.querySelectorAll('.dakshin-card-col');

        // Initial Filter (First category)
        const firstCategory = "{{ $menuCategories->isNotEmpty() ? $menuCategories->first()->slug : '' }}";
        if (firstCategory) {
            filterItems(firstCategory);
        }

        toggleBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all
                toggleBtns.forEach(b => b.classList.remove('active'));
                // Add active to clicked
                this.classList.add('active');
                
                const filterValue = this.getAttribute('data-filter');
                filterItems(filterValue);
            });
        });

        function filterItems(category) {
            const grid = document.querySelector('.dakshin-grid');
            
            // Create a small loader for the grid if it doesn't exist
            let loader = document.getElementById('tab-loader');
            if (!loader) {
                loader = document.createElement('div');
                loader.id = 'tab-loader';
                loader.innerHTML = '<div class="minimal-loader mx-auto my-5"></div>';
                grid.parentNode.insertBefore(loader, grid);
            }
            
            grid.style.display = 'none';
            loader.style.display = 'block';
            
            setTimeout(() => {
                menuItems.forEach(item => {
                    const itemCategory = item.getAttribute('data-category');
                    if (itemCategory === category) {
                        item.style.display = 'block';
                        item.classList.add('animate__animated', 'animate__fadeIn');
                    } else {
                        item.style.display = 'none';
                        item.classList.remove('animate__animated', 'animate__fadeIn');
                    }
                });
                
                loader.style.display = 'none';
                grid.style.display = 'grid';
            }, 150);
        }
    });
</script>
@endsection
