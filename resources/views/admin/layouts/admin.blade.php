<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') | AURA Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #1a1d23;
            --sidebar-hover: #2a2d35;
            --sidebar-active: #3a3d45;
            --primary-color: #8B5CF6;
            --primary-hover: #7C3AED;
            --dark-bg: #f4f6f9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--dark-bg);
            overflow-x: hidden;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: var(--sidebar-bg);
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: #555;
            border-radius: 2px;
        }

        .sidebar-brand {
            padding: 20px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 70px;
        }

        .sidebar-brand .brand-icon {
            width: 38px;
            height: 38px;
            background: var(--primary-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .sidebar-brand .brand-text {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .sidebar-brand .brand-text small {
            display: block;
            font-size: 10px;
            font-weight: 400;
            color: rgba(255,255,255,0.5);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-nav {
            padding: 16px 12px;
        }

        .sidebar-nav .nav-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255,255,255,0.35);
            padding: 12px 12px 6px;
            font-weight: 600;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 2px;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-size: 14px;
            font-weight: 500;
            position: relative;
        }

        .sidebar-nav .nav-link:hover {
            color: #fff;
            background: var(--sidebar-hover);
        }

        .sidebar-nav .nav-link.active {
            color: #fff;
            background: var(--primary-color);
        }

        .sidebar-nav .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .sidebar-nav .nav-link .badge {
            margin-left: auto;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .sidebar-nav .nav-link .arrow {
            margin-left: auto;
            font-size: 10px;
            transition: transform 0.2s;
        }

        .sidebar-nav .nav-link[aria-expanded="true"] .arrow {
            transform: rotate(90deg);
        }

        .sidebar-nav .sub-menu {
            padding-left: 44px;
            list-style: none;
            margin: 2px 0;
        }

        .sidebar-nav .sub-menu .nav-link {
            font-size: 13px;
            padding: 6px 12px;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Navbar */
        .top-navbar {
            background: #fff;
            padding: 0 32px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e9ecef;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .top-navbar .navbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .top-navbar .sidebar-toggle {
            background: none;
            border: none;
            font-size: 20px;
            color: #6c757d;
            cursor: pointer;
            padding: 4px;
            display: none;
        }

        .top-navbar .search-box {
            position: relative;
            width: 320px;
        }

        .top-navbar .search-box input {
            width: 100%;
            padding: 8px 16px 8px 40px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            background: #f8f9fa;
            transition: all 0.2s;
        }

        .top-navbar .search-box input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(139,92,246,0.1);
        }

        .top-navbar .search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
            font-size: 14px;
        }

        .top-navbar .navbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .top-navbar .navbar-right .btn-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: none;
            background: transparent;
            color: #6c757d;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.2s;
        }

        .top-navbar .navbar-right .btn-icon:hover {
            background: #f1f3f5;
            color: var(--sidebar-bg);
        }

        .top-navbar .navbar-right .btn-icon .dot {
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            position: absolute;
            top: 8px;
            right: 8px;
            border: 2px solid #fff;
        }

        .top-navbar .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 12px 4px 4px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            color: inherit;
        }

        .top-navbar .admin-profile:hover {
            background: #f1f3f5;
        }

        .top-navbar .admin-profile .avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
        }

        .top-navbar .admin-profile .info {
            line-height: 1.3;
        }

        .top-navbar .admin-profile .info .name {
            font-size: 14px;
            font-weight: 600;
            color: var(--sidebar-bg);
        }

        .top-navbar .admin-profile .info .role {
            font-size: 11px;
            color: #6c757d;
        }

        /* Page Content */
        .page-content {
            padding: 28px 32px;
            flex: 1;
        }

        .page-header {
            margin-bottom: 28px;
        }

        .page-header h4 {
            font-weight: 700;
            color: var(--sidebar-bg);
            margin: 0;
        }

        .page-header .breadcrumb {
            margin: 4px 0 0;
            font-size: 13px;
            background: none;
            padding: 0;
        }

        .page-header .breadcrumb-item a {
            color: #6c757d;
            text-decoration: none;
        }

        .page-header .breadcrumb-item a:hover {
            color: var(--primary-color);
        }

        .page-header .breadcrumb-item.active {
            color: var(--primary-color);
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            transition: all 0.2s;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            padding: 16px 24px;
            font-weight: 600;
            font-size: 15px;
            border-radius: 12px 12px 0 0 !important;
        }

        .card-body {
            padding: 24px;
        }

        .card-footer {
            background: #fff;
            border-top: 1px solid #e9ecef;
            padding: 16px 24px;
            border-radius: 0 0 12px 12px !important;
        }

        /* Stats Card */
        .stat-card {
            padding: 24px;
            border-radius: 12px;
            background: #fff;
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: all 0.2s;
        }

        .stat-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .stat-card .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .stat-card .stat-icon.purple {
            background: rgba(139,92,246,0.12);
            color: var(--primary-color);
        }

        .stat-card .stat-icon.blue {
            background: rgba(59,130,246,0.12);
            color: #3b82f6;
        }

        .stat-card .stat-icon.green {
            background: rgba(16,185,129,0.12);
            color: #10b981;
        }

        .stat-card .stat-icon.orange {
            background: rgba(245,158,11,0.12);
            color: #f59e0b;
        }

        .stat-card .stat-icon.red {
            background: rgba(239,68,68,0.12);
            color: #ef4444;
        }

        .stat-card .stat-icon.indigo {
            background: rgba(99,102,241,0.12);
            color: #6366f1;
        }

        .stat-card .stat-info {
            flex: 1;
        }

        .stat-card .stat-info .stat-label {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .stat-card .stat-info .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--sidebar-bg);
            line-height: 1.2;
        }

        .stat-card .stat-info .stat-change {
            font-size: 12px;
            margin-top: 4px;
        }

        .stat-card .stat-info .stat-change.positive {
            color: #10b981;
        }

        .stat-card .stat-info .stat-change.negative {
            color: #ef4444;
        }

        /* Tables */
        .table {
            margin-bottom: 0;
        }

        .table th {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            font-weight: 600;
            border-bottom: 2px solid #e9ecef;
            padding: 12px 16px;
        }

        .table td {
            padding: 12px 16px;
            vertical-align: middle;
            font-size: 14px;
            color: #495057;
        }

        .table-hover tbody tr:hover {
            background: rgba(139,92,246,0.03);
        }

        /* Status Badges */
        .badge-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-status.active, .badge-status.completed, .badge-status.delivered {
            background: rgba(16,185,129,0.12);
            color: #059669;
        }

        .badge-status.pending {
            background: rgba(245,158,11,0.12);
            color: #d97706;
        }

        .badge-status.processing, .badge-status.shipped {
            background: rgba(59,130,246,0.12);
            color: #2563eb;
        }

        .badge-status.cancelled, .badge-status.inactive {
            background: rgba(239,68,68,0.12);
            color: #dc2626;
        }

        .badge-status.draft {
            background: rgba(108,117,125,0.12);
            color: #6c757d;
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-soft {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-soft-primary {
            background: rgba(139,92,246,0.12);
            color: var(--primary-color);
            border: none;
        }

        .btn-soft-primary:hover {
            background: rgba(139,92,246,0.2);
            color: var(--primary-hover);
        }

        .btn-soft-danger {
            background: rgba(239,68,68,0.12);
            color: #ef4444;
            border: none;
        }

        .btn-soft-danger:hover {
            background: rgba(239,68,68,0.2);
            color: #dc2626;
        }

        .btn-soft-success {
            background: rgba(16,185,129,0.12);
            color: #10b981;
            border: none;
        }

        .btn-soft-success:hover {
            background: rgba(16,185,129,0.2);
            color: #059669;
        }

        .btn-soft-warning {
            background: rgba(245,158,11,0.12);
            color: #f59e0b;
            border: none;
        }

        .btn-soft-warning:hover {
            background: rgba(245,158,11,0.2);
            color: #d97706;
        }

        /* Forms */
        .form-control, .form-select {
            border: 1px solid #e2e8f0;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(139,92,246,0.1);
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-text {
            font-size: 12px;
            color: #9ca3af;
        }

        /* Toggle Switch */
        .form-switch .form-check-input {
            width: 44px;
            height: 24px;
            cursor: pointer;
        }

        .form-switch .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Image Upload */
        .image-upload-wrapper {
            border: 2px dashed #e2e8f0;
            border-radius: 12px;
            padding: 40px 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .image-upload-wrapper:hover {
            border-color: var(--primary-color);
            background: rgba(139,92,246,0.03);
        }

        .image-upload-wrapper i {
            font-size: 48px;
            color: #d1d5db;
            margin-bottom: 12px;
        }

        .image-upload-wrapper p {
            font-size: 14px;
            color: #6c757d;
            margin: 0;
        }

        .image-preview {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 16px;
        }

        .image-preview .preview-item {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            border: 1px solid #e9ecef;
        }

        .image-preview .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview .preview-item .remove-btn {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: rgba(0,0,0,0.6);
            color: #fff;
            border: none;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* Modal */
        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
            padding: 20px 24px;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 16px 24px;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .top-navbar .sidebar-toggle {
                display: flex;
            }

            .top-navbar .search-box {
                width: 200px;
            }

            .page-content {
                padding: 20px;
            }
        }

        @media (max-width: 767.98px) {
            .top-navbar {
                padding: 0 16px;
            }

            .top-navbar .search-box {
                width: 140px;
            }

            .page-content {
                padding: 16px;
            }

            .top-navbar .admin-profile .info {
                display: none;
            }
        }

        /* Dropdown */
        .dropdown-menu {
            border: none;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
            padding: 6px;
        }

        .dropdown-menu .dropdown-item {
            border-radius: 6px;
            padding: 8px 14px;
            font-size: 14px;
            transition: all 0.15s;
        }

        .dropdown-menu .dropdown-item:hover {
            background: rgba(139,92,246,0.08);
            color: var(--primary-color);
        }

        .dropdown-menu .dropdown-item i {
            width: 20px;
            text-align: center;
        }

        .dropdown-divider {
            margin: 4px 0;
        }

        /* Pagination */
        .pagination {
            margin: 0;
        }

        .page-link {
            border: none;
            padding: 8px 14px;
            margin: 0 2px;
            border-radius: 8px !important;
            font-size: 14px;
            color: #6c757d;
            transition: all 0.2s;
        }

        .page-link:hover {
            background: rgba(139,92,246,0.08);
            color: var(--primary-color);
        }

        .page-item.active .page-link {
            background: var(--primary-color);
            color: #fff;
        }

        .page-item.disabled .page-link {
            color: #ced4da;
        }

        /* Order Timeline */
        .order-timeline {
            position: relative;
            padding-left: 28px;
        }

        .order-timeline::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 4px;
            bottom: 4px;
            width: 2px;
            background: #e9ecef;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 24px;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item .timeline-icon {
            position: absolute;
            left: -28px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid #e9ecef;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            top: 2px;
        }

        .timeline-item .timeline-icon.completed {
            background: #10b981;
            border-color: #10b981;
            color: #fff;
        }

        .timeline-item .timeline-icon.current {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: #fff;
        }

        .timeline-item .timeline-text {
            font-size: 14px;
            font-weight: 500;
        }

        .timeline-item .timeline-time {
            font-size: 12px;
            color: #9ca3af;
        }

        /* Chart Containers */
        .chart-container {
            position: relative;
            width: 100%;
        }

        .chart-container canvas {
            max-height: 300px;
        }

        /* Tab Navigation */
        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .nav-tabs .nav-link:hover {
            color: var(--sidebar-bg);
            background: #f1f3f5;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            background: rgba(139,92,246,0.08);
        }

        /* Color Input */
        .color-input-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .color-input-wrapper input[type="color"] {
            width: 48px;
            height: 48px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 2px;
            cursor: pointer;
        }

        /* Avatar */
        .avatar-sm {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 12px;
            color: #fff;
            background: var(--primary-color);
            flex-shrink: 0;
        }

        .avatar-md {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 16px;
            color: #fff;
            flex-shrink: 0;
        }

        .text-primary-custom {
            color: var(--primary-color);
        }

        /* Switches in table */
        .table .form-check-input:checked {
            background-color: #10b981;
            border-color: #10b981;
        }

        .table .form-check-input {
            cursor: pointer;
        }

        /* Tooltip */
        .action-btns {
            display: flex;
            gap: 4px;
        }

        .action-btns .btn {
            padding: 4px 10px;
            font-size: 13px;
            border-radius: 6px;
        }

        /* Loading spinner */
        .spinner-sm {
            width: 16px;
            height: 16px;
        }

        /* Footer */
        .admin-footer {
            padding: 16px 32px;
            border-top: 1px solid #e9ecef;
            font-size: 13px;
            color: #6c757d;
            background: #fff;
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="admin-wrapper">

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay d-lg-none" id="sidebarOverlay" onclick="toggleSidebar()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:999;"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">A</div>
            <div class="brand-text">
                AURA <small>Admin Panel</small>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">Menu</div>

            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="#productsSubmenu" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->routeIs('admin.products.*') ? 'true' : 'false' }}">
                    <i class="fas fa-tshirt"></i>
                    <span>Products</span>
                    <i class="fas fa-chevron-right arrow"></i>
                </a>
                <ul class="sub-menu collapse {{ request()->routeIs('admin.products.*') ? 'show' : '' }}" id="productsSubmenu">
                    <li>
                        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.index') && !request()->routeIs('admin.products.create') ? 'active' : '' }}">
                            <i class="fas fa-list"></i>
                            <span>All Products</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.create') }}" class="nav-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                            <i class="fas fa-plus-circle"></i>
                            <span>Add Product</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    <span>Categories</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.collections.index') }}" class="nav-link {{ request()->routeIs('admin.collections.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i>
                    <span>Collections</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                    @php $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count(); @endphp
                    @if($pendingOrdersCount > 0)
                        <span class="badge bg-warning text-dark ms-auto">{{ $pendingOrdersCount }}</span>
                    @endif
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Customers</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i>
                    <span>Reviews</span>
                    @php $pendingReviewsCount = \App\Models\Review::where('is_approved', false)->count(); @endphp
                    @if($pendingReviewsCount > 0)
                        <span class="badge bg-danger ms-auto">{{ $pendingReviewsCount }}</span>
                    @endif
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                    <i class="fas fa-percent"></i>
                    <span>Coupons</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.banners.index') }}" class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                    <i class="fas fa-images"></i>
                    <span>Banners</span>
                </a>
            </div>

            <div class="nav-label">System</div>

            <div class="nav-item">
                <a href="{{ route('admin.reports') }}" class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('dashboard.profile') }}" class="nav-link {{ request()->routeIs('dashboard.profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link text-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">

        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="navbar-left">
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" placeholder="Search anything..." id="globalSearch">
                </div>
            </div>

            <div class="navbar-right">
                <a href="{{ route('home') }}" class="btn btn-soft-primary me-2" title="Back to Website" style="padding:6px 14px;font-size:13px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                    <i class="fas fa-globe"></i>
                    <span class="d-none d-md-inline">Back to Website</span>
                </a>
                <button class="btn-icon" title="Notifications">
                    <i class="fas fa-bell"></i>
                    <span class="dot"></span>
                </button>
                <button class="btn-icon" title="Messages">
                    <i class="fas fa-envelope"></i>
                </button>
                <button class="btn-icon" title="Fullscreen" onclick="toggleFullscreen()">
                    <i class="fas fa-expand"></i>
                </button>

                <div class="dropdown">
                    <a href="#" class="admin-profile" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar">A</div>
                        <div class="info">
                            <div class="name">Admin</div>
                            <div class="role">Super Admin</div>
                        </div>
                        <i class="fas fa-chevron-down" style="font-size:10px;color:#adb5bd;margin-left:4px;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('dashboard.profile') }}"><i class="far fa-user"></i> My Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="far fa-cog"></i> Account Settings</a></li>
                        <li><a class="dropdown-item" href="#"><i class="far fa-chart-bar"></i> Activity Log</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </header>

        <!-- Page Content -->
        <div class="page-content">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="admin-footer">
            <div class="d-flex justify-content-between align-items-center">
                <span>&copy; {{ date('Y') }} AURA. All rights reserved.</span>
                <span>v1.0.0</span>
            </div>
        </footer>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('show');
        overlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
    }

    function toggleFullscreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
        } else {
            document.exitFullscreen();
        }
    }

    $(document).ready(function() {
        // Auto-hide alerts
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Global search redirect (demo)
        $('#globalSearch').on('keypress', function(e) {
            if (e.which === 13) {
                const query = $(this).val().trim();
                if (query.length > 0) {
                    alert('Search functionality will be implemented: ' + query);
                }
            }
        });

        // Close sidebar on outside click (mobile)
        $(document).on('click', function(e) {
            if ($(window).width() < 992) {
                if (!$(e.target).closest('.sidebar, .sidebar-toggle').length) {
                    $('#adminSidebar').removeClass('show');
                    $('#sidebarOverlay').hide();
                }
            }
        });
    });

    @stack('scripts')
</script>

</body>
</html>
