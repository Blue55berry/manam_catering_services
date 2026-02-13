<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Manam Catering Service</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/admin-modern.css') }}">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <!-- Sidebar Header -->
            <div class="sidebar-header">
                <div class="sidebar-logo" style="width: auto; height: auto; background: transparent;">
                     <img src="{{ asset('assets/images/main/logo.png') }}" alt="Manam Logo" style="max-width: 60px; height: 60px;" class="rounded-circle object-fit-cover">
                </div>
                <div class="sidebar-brand">
                    <h3>Manam</h3>
                    <p>Catering Service</p>
                </div>
                <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="admin-nav">
                <ul>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fa fa-tachometer"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.menu-items.index') }}" class="{{ request()->routeIs('admin.menu-items.*') ? 'active' : '' }}">
                            <i class="fa fa-cutlery"></i>
                            <span>Menu Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.packages.index') }}" class="{{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
                            <i class="fa fa-gift"></i>
                            <span>Packages</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                            <i class="fa fa-calendar-check-o"></i>
                            <span>Event Bookings</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                            <i class="fa fa-picture-o"></i>
                            <span>Event Gallery</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.hero-banners.index') }}" class="{{ request()->routeIs('admin.hero-banners.*') ? 'active' : '' }}">
                            <i class="fa fa-sliders"></i>
                            <span>Manage Sliders</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.contacts.index') }}" class="{{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                            <i class="fa fa-envelope"></i>
                            <span>Enquiries</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.blogs.index') }}" class="{{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                            <i class="fa fa-book"></i>
                            <span>Blog Management</span>
                        </a>
                    </li>
                    <!-- Quotations Dropdown -->
                    <li class="has-submenu {{ request()->routeIs('admin.quotations.*') || request()->routeIs('admin.client-quotations.index') ? 'open' : '' }}">
                        <a href="#" class="submenu-toggle {{ request()->routeIs('admin.quotations.*') || request()->routeIs('admin.client-quotations.index') ? 'active' : '' }}">
                            <i class="fa fa-file-text-o"></i>
                            <span>Quotations</span>
                            <i class="fa fa-angle-down submenu-arrow"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('admin.quotations.index') }}" class="{{ request()->routeIs('admin.quotations.index') ? 'active' : '' }}">
                                    <i class="fa fa-list"></i> All Quotations
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.quotations.create') }}" class="{{ request()->routeIs('admin.quotations.create') ? 'active' : '' }}">
                                    <i class="fa fa-plus"></i> Create New Quotation
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Customers Dropdown -->
                    <li class="has-submenu {{ request()->routeIs('admin.customers.*') ? 'open' : '' }}">
                        <a href="#" class="submenu-toggle {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                            <i class="fa fa-address-book"></i>
                            <span>Customers</span>
                            <i class="fa fa-angle-down submenu-arrow"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('admin.customers.create') }}" class="{{ request()->routeIs('admin.customers.create') ? 'active' : '' }}">
                                    <i class="fa fa-user-plus"></i> Add New Customer
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.customers.index') }}" class="{{ request()->routeIs('admin.customers.index') || request()->routeIs('admin.customers.edit') ? 'active' : '' }}">
                                    <i class="fa fa-list"></i> Manage Customers
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <!-- Sidebar Footer -->
            <div class="sidebar-footer">
                <div class="admin-user-profile">
                    <div class="user-avatar">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="user-info">
                        <h4>Admin</h4>
                        <p>Administrator</p>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-outline-light w-100 btn-sm" style="opacity: 0.8;">
                        <i class="fa fa-sign-out"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Top Header -->
            <header class="admin-header">
                <div class="header-title">
                    <button class="mobile-menu-toggle" id="mobileMenuToggle">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h1>@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="header-actions">
                    <div class="header-search">
                        <i class="fa fa-search"></i>
                        <input type="text" placeholder="Search...">
                    </div>
                    <div class="header-notifications">
                        <i class="fa fa-bell"></i>
                        <span class="notification-badge"></span>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    
    <!-- Sidebar Toggle Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('adminSidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        
        // Desktop toggle
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
            });
        }

        // Mobile toggle
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
            });
        }

        // Submenu toggle functionality
        const submenuToggles = document.querySelectorAll('.submenu-toggle');
        submenuToggles.forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const parentLi = this.closest('.has-submenu');
                parentLi.classList.toggle('open');
            });
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 1024) {
                if (!sidebar.contains(event.target) && !mobileMenuToggle.contains(event.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });
    });
    </script>

    @stack('scripts')
</body>
</html>
