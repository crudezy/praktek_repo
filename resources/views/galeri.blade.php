@extends('layouts.app')

@section('konten')

<body>

    <!-- Tambahan Sweet Alert -->
    @if (session('success'))
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            timer: 3000,
            showConfirmButton: false,
            background: 'rgba(255, 255, 255, 0.95)',
            backdrop: 'rgba(0, 0, 0, 0.4)',
            customClass: {
                popup: 'enhanced-swal'
            }
        });
    });
    </script>
    @endif
    <!-- Akhir Tambahan Sweet Alert -->

    <style>
    :root {
        --primary-gradient: linear-gradient(135deg, #a8d8ea 0%, #7fb3d3 100%);
        --card-bg: rgba(255, 255, 255, 0.95);
        --card-border: rgba(168, 216, 234, 0.3);
        --shadow-light: 0 4px 15px rgba(116, 185, 255, 0.1);
        --shadow-medium: 0 8px 25px rgba(116, 185, 255, 0.15);
        --shadow-strong: 0 12px 35px rgba(116, 185, 255, 0.25);
        --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --border-radius: 16px;
        --text-primary: #2c3e50;
        --text-secondary: #7f8c8d;
        --blue-primary: #74b9ff;
        --blue-secondary: #0984e3;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: var(--primary-gradient);
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background:
            radial-gradient(circle at 20% 80%, rgba(116, 185, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(168, 216, 234, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 40% 40%, rgba(135, 206, 235, 0.1) 0%, transparent 70%);
        pointer-events: none;
        z-index: -1;
    }

    /* Enhanced Header */
    header {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--card-border);
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: var(--shadow-light);
    }

    .main-logo img {
        max-height: 60px;
        filter: drop-shadow(0 4px 8px rgba(116, 185, 255, 0.2));
        transition: var(--transition-smooth);
    }

    .main-logo img:hover {
        transform: scale(1.05);
    }

    /* Section Title */
    .bootstrap-tabs .tabs-header h3 {
        color: #ffffff;
        font-weight: 700;
        font-size: 2.5rem;
        text-shadow: 0 4px 8px rgba(116, 185, 255, 0.3);
        margin-bottom: 0;
        position: relative;
    }

    .bootstrap-tabs .tabs-header h3::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 80px;
        height: 4px;
        background: linear-gradient(135deg, #87ceeb 0%, #5dade2 100%);
        border-radius: 2px;
    }

    /* Enhanced Product Cards */
    .product-item {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--border-radius);
        padding: 20px;
        margin-bottom: 30px;
        transition: var(--transition-smooth);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-light);
        backdrop-filter: blur(10px);
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .product-item:nth-child(1) {
        animation-delay: 0.1s;
    }

    .product-item:nth-child(2) {
        animation-delay: 0.2s;
    }

    .product-item:nth-child(3) {
        animation-delay: 0.3s;
    }

    .product-item:nth-child(4) {
        animation-delay: 0.4s;
    }

    .product-item:nth-child(5) {
        animation-delay: 0.5s;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .product-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(116, 185, 255, 0.1), transparent);
        transition: var(--transition-smooth);
        pointer-events: none;
    }

    .product-item:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: var(--shadow-strong);
        border-color: var(--blue-primary);
    }

    .product-item:hover::before {
        left: 100%;
    }

    /* Wishlist Button */
    .btn-wishlist {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid var(--card-border);
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
        transition: var(--transition-smooth);
        z-index: 2;
        box-shadow: var(--shadow-light);
    }

    .btn-wishlist:hover {
        background: var(--blue-primary);
        color: white;
        transform: scale(1.1);
        box-shadow: var(--shadow-medium);
    }

    /* Product Image */
    .product-item figure {
        margin-bottom: 16px;
        border-radius: 12px;
        overflow: hidden;
        position: relative;
        background: #f8f9fa;
    }

    .tab-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        transition: var(--transition-smooth);
    }

    .product-item:hover .tab-image {
        transform: scale(1.05);
    }

    /* Product Info */
    .product-item h3 {
        color: var(--text-primary);
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .qty {
        color: var(--text-secondary);
        font-size: 0.85rem;
        background: #f8f9fa;
        padding: 4px 10px;
        border-radius: 12px;
        border: 1px solid #e9ecef;
        display: inline-block;
        margin-bottom: 12px;
        font-weight: 500;
    }

    .price {
        color: var(--blue-secondary);
        font-weight: 700;
        font-size: 1.3rem;
        display: block;
        margin-bottom: 16px;
    }

    /* Enhanced Product Controls */
    .d-flex.align-items-center.justify-content-between {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .product-qty {
        background: #f8f9fa;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        min-width: 100px;
    }

    .product-qty .btn {
        border: none;
        padding: 6px 10px;
        transition: var(--transition-smooth);
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-qty .btn-danger {
        background: #ff6b89;
        color: white;
    }

    .product-qty .btn-success {
        background: var(--blue-primary);
        color: white;
    }

    .product-qty .btn:hover {
        transform: scale(1.05);
        filter: brightness(1.1);
    }

    .product-qty .form-control {
        background: transparent;
        border: none;
        color: var(--text-primary);
        text-align: center;
        font-weight: 600;
        padding: 6px 8px;
        width: 40px;
        font-size: 14px;
    }

    .product-qty .form-control:focus {
        outline: none;
        background: rgba(116, 185, 255, 0.1);
        box-shadow: none;
        border: none;
        color: var(--text-primary);
    }

    .d-flex.align-items-center.gap-2 {
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1;
        justify-content: flex-end;
        flex-wrap: nowrap;
    }

    .weight-label {
        background: #e9ecef !important;
        color: var(--text-secondary) !important;
        border: 1px solid #dee2e6 !important;
        border-radius: 6px;
        padding: 4px 8px;
        font-size: 0.75rem;
        font-weight: 500;
        white-space: nowrap;
    }

    .nav-link {
        background: var(--blue-primary) !important;
        color: white !important;
        border-radius: 8px !important;
        padding: 8px 12px !important;
        font-weight: 600 !important;
        font-size: 0.8rem !important;
        transition: var(--transition-smooth) !important;
        text-decoration: none !important;
        border: none !important;
        box-shadow: var(--shadow-light);
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 4px !important;
        white-space: nowrap !important;
        min-width: 80px !important;
        text-align: center !important;
    }

    .nav-link:hover {
        background: var(--blue-secondary) !important;
        color: white !important;
        transform: translateY(-2px) !important;
        box-shadow: var(--shadow-medium) !important;
        text-decoration: none !important;
    }

    /* Enhanced Responsive Design */
    @media (max-width: 768px) {
        .d-flex.align-items-center.justify-content-between {
            flex-direction: column;
            gap: 10px;
            align-items: stretch;
        }

        .d-flex.align-items-center.gap-2 {
            justify-content: space-between;
            width: 100%;
            flex-wrap: nowrap;
        }

        .nav-link {
            font-size: 0.75rem !important;
            padding: 6px 10px !important;
            min-width: 70px !important;
        }

        .weight-label {
            font-size: 0.7rem;
            padding: 3px 6px;
        }
    }

    /* Loading Animation untuk button */
    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.7;
        }
    }

    .loading {
        animation: pulse 1.5s ease-in-out infinite;
    }

    /* Ripple effect */
    @keyframes ripple {
        to {
            transform: scale(2);
            opacity: 0;
        }
    }

    /* Enhanced button animations */
    .quantity-left-minus,
    .quantity-right-plus {
        position: relative;
        overflow: hidden;
    }

    .quantity-left-minus:active,
    .quantity-right-plus:active {
        transform: scale(0.95);
    }

    /* Enhanced offcanvas and other elements */
    .offcanvas {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-left: 1px solid var(--card-border);
    }

    .search-bar {
        background: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(20px);
        border: 1px solid var(--card-border) !important;
        border-radius: 25px !important;
        transition: var(--transition-smooth);
        box-shadow: var(--shadow-light);
    }

    .search-bar:hover {
        background: rgba(255, 255, 255, 0.95) !important;
        transform: translateY(-2px);
    }

    .rounded-circle {
        background: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(20px);
        border: 1px solid var(--card-border) !important;
        transition: var(--transition-smooth);
        box-shadow: var(--shadow-light);
    }

    .rounded-circle:hover {
        background: rgba(255, 255, 255, 0.95) !important;
        transform: translateY(-3px) scale(1.1);
        box-shadow: var(--shadow-medium);
    }

    .btn-close.custom-close {
        background: var(--blue-primary) !important;
        border-radius: 50% !important;
        width: 2.2rem;
        height: 2.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 1 !important;
        position: relative;
    }

    .btn-close.custom-close svg {
        color: #fff;
        width: 1.2rem;
        height: 1.2rem;
    }
    </style>

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <defs>
            <symbol xmlns="http://www.w3.org/2000/svg" id="link" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M12 19a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0-4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm-5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm7-12h-1V2a1 1 0 0 0-2 0v1H8V2a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3Zm1 17a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-9h16Zm0-11H4V6a1 1 0 0 1 1-1h1v1a1 1 0 0 0 2 0V5h8v1a1 1 0 0 0 2 0V5h1a1 1 0 0 1 1 1ZM7 15a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0 4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="arrow-right" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M17.92 11.62a1 1 0 0 0-.21-.33l-5-5a1 1 0 0 0-1.42 1.42l3.3 3.29H7a1 1 0 0 0 0 2h7.59l-3.3 3.29a1 1 0 0 0 0 1.42a1 1 0 0 0 1.42 0l5-5a1 1 0 0 0 .21-.33a1 1 0 0 0 0-.76Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="category" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M19 5.5h-6.28l-.32-1a3 3 0 0 0-2.84-2H5a3 3 0 0 0-3 3v13a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-10a3 3 0 0 0-3-3Zm1 13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-13a1 1 0 0 1 1-1h4.56a1 1 0 0 1 .95.68l.54 1.64a1 1 0 0 0 .95.68h7a1 1 0 0 1 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="calendar" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M19 4h-2V3a1 1 0 0 0-2 0v1H9V3a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3Zm1 15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-7h16Zm0-9H4V7a1 1 0 0 1 1-1h2v1a1 1 0 0 0 2 0V6h6v1a1 1 0 0 0 2 0V6h2a1 1 0 0 1 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="heart" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M20.16 4.61A6.27 6.27 0 0 0 12 4a6.27 6.27 0 0 0-8.16 9.48l7.45 7.45a1 1 0 0 0 1.42 0l7.45-7.45a6.27 6.27 0 0 0 0-8.87Zm-1.41 7.46L12 18.81l-6.75-6.74a4.28 4.28 0 0 1 3-7.3a4.25 4.25 0 0 1 3 1.25a1 1 0 0 0 1.42 0a4.27 4.27 0 0 1 6 6.05Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="plus" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="minus" viewBox="0 0 24 24">
                <path fill="currentColor" d="M19 11H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="cart" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545v.005l1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="check" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M18.71 7.21a1 1 0 0 0-1.42 0l-7.45 7.46l-3.13-3.14A1 1 0 1 0 5.29 13l3.84 3.84a1 1 0 0 0 1.42 0l8.16-8.16a1 1 0 0 0 0-1.47Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="trash" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M10 18a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1ZM20 6h-4V5a3 3 0 0 0-3-3h-2a3 3 0 0 0-3 3v1H4a1 1 0 0 0 0 2h1v11a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8h1a1 1 0 0 0 0-2ZM10 5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v1h-4Zm7 14a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8h10Zm-3-1a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="star-outline" viewBox="0 0 15 15">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    d="M7.5 9.804L5.337 11l.413-2.533L4 6.674l2.418-.37L7.5 4l1.082 2.304l2.418.37l-1.75 1.793L9.663 11L7.5 9.804Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="star-solid" viewBox="0 0 15 15">
                <path fill="currentColor"
                    d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="search" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="user" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M15.71 12.71a6 6 0 1 0-7.42 0a10 10 0 0 0-6.22 8.18a1 1 0 0 0 2 .22a8 8 0 0 1 15.9 0a1 1 0 0 0 1 .89h.11a1 1 0 0 0 .88-1.1a10 10 0 0 0-6.25-8.19ZM12 12a4 4 0 1 1 4-4a4 4 0 0 1-4 4Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="close" viewBox="0 0 24 24">
                <path fill="currentColor" d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" />
            </symbol>
        </defs>
    </svg>

    <div class="preloader-wrapper">
        <div class="preloader">
        </div>
    </div>

    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart"
        aria-labelledby="CartOffcanvasLabel">
        <div class="offcanvas-header align-items-center">
            <h5 class="offcanvas-title text-center w-100 mb-2" id="CartOffcanvasLabel">Keranjang & Menu</h5>
            <button type="button" class="btn-close custom-close d-flex justify-content-center align-items-center"
                data-bs-dismiss="offcanvas" aria-label="Close"
                style="background: var(--blue-primary); border: none; box-shadow: none; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; margin-left: auto;">
                <span style="color: #fff; font-size: 1.3rem; font-weight: bold; line-height: 1;">×</span>
            </button>
        </div>
        <div class="offcanvas-body">
            <!-- Cart Summary -->
            <div class="cart-summary">
                <h4 class="d-flex justify-content-between align-items-center">
                    <span>Jumlah Barang</span>
                    <span id="cart-count" class="cart-count-badge">{{ $jmllayanandibeli ?? 0 }}</span>
                </h4>

                <div class="cart-total-item d-flex justify-content-between align-items-center">
                    <span class="cart-total-text">Total (IDR)</span>
                    <strong id="cart-total" class="cart-total-amount">{{ rupiah($total_belanja) ?? 0 }}</strong>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="navigation-menu">
                <a href="/lihatkeranjang" class="nav-button btn-primary">
                    <svg width="18" height="18" style="margin-right: 8px; vertical-align: middle;">
                        <use xlink:href="#cart"></use>
                    </svg>
                    Lihat Keranjang
                </a>

                <a href="/depan" class="nav-button btn-dark">
                    <svg width="18" height="18" style="margin-right: 8px; vertical-align: middle;">
                        <use xlink:href="#category"></use>
                    </svg>
                    Lihat Galeri
                </a>

                <a href="/lihatriwayat" class="nav-button btn-info">
                    <svg width="18" height="18" style="margin-right: 8px; vertical-align: middle;">
                        <use xlink:href="#calendar"></use>
                    </svg>
                    Riwayat Pemesanan
                </a>

                <a href="/logout" class="nav-button btn-danger">
                    <svg width="18" height="18" style="margin-right: 8px; vertical-align: middle;">
                        <use xlink:href="#user"></use>
                    </svg>
                    Keluar
                </a>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasSearch"
        aria-labelledby="Search">
        <div class="offcanvas-header justify-content-center">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Search</span>
                </h4>
                <form role="search" action="index.html" method="get" class="d-flex mt-3 gap-0">
                    <input class="form-control rounded-start rounded-0 bg-light" type="email"
                        placeholder="What are you looking for?" aria-label="What are you looking for?">
                    <button class="btn btn-dark rounded-end rounded-0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>

    <header>
        <div class="container-fluid">
            <div class="row py-3 border-bottom">

                <div class="col-sm-4 col-lg-3 text-center text-sm-start">
                    <div class="main-logo">
                        <a href="/depan"
                            class="d-flex align-items-center justify-content-center justify-content-sm-start">
                            <img src="images/logo.png" alt="logo" class="img-fluid">
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 offset-sm-2 offset-md-0 col-lg-5 d-none d-lg-block"></div>
                <div
                    class="col-sm-8 col-lg-4 d-flex justify-content-end gap-5 align-items-center mt-4 mt-sm-0 justify-content-center justify-content-sm-end">

                    <ul class="d-flex justify-content-end list-unstyled m-0">
                        <li class="d-lg-none">
                            <a href="#" class="rounded-circle bg-light p-2 mx-1" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                                <svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#cart"></use>
                                </svg>
                            </a>
                        </li>
                        <li class="d-lg-none">
                            <a href="#" class="rounded-circle bg-light p-2 mx-1" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasSearch" aria-controls="offcanvasSearch">
                                <svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#search"></use>
                                </svg>
                            </a>
                        </li>
                    </ul>

                    <!-- Untuk Icon User -->
                    <ul class="d-flex justify-content-end list-unstyled m-0">
                        <li>
                            <a href="{{ url('/ubahpassword') }}" class="rounded-circle bg-light p-2 mx-1">
                                <svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#user"></use>
                                </svg>
                            </a>
                        </li>
                    </ul>
                    <!-- Akhir Icon User -->

                    <div class="cart text-end d-none d-lg-block dropdown">
                        <button class="border-0 bg-transparent d-flex flex-column gap-2 lh-1" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                            <span class="fs-6 text-muted dropdown-toggle">Keranjang Anda</span>
                            <span class="cart-total fs-5 fw-bold"
                                id="total_belanja">{{ rupiah($total_belanja) ?? 0 }}</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </header>


    <section class="py-5">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">

                    <div class="bootstrap-tabs product-tabs">
                        <div class="tabs-header d-flex justify-content-between border-bottom my-5">
                            <h3>Layanan Kami</h3>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-all" role="tabpanel"
                                aria-labelledby="nav-all-tab">
                                <!-- Tambahan untuk CSRF -->
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <!-- Akhir Tambahan untuk CSRF -->
                                <div
                                    class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                                    @foreach ($layanans as $p)
                                    <div class="col">
                                        <div class="product-item">
                                            <a href="#" class="btn-wishlist">
                                                <svg width="24" height="24">
                                                    <use xlink:href="#heart"></use>
                                                </svg>
                                            </a>

                                            <figure>
                                                <a href="{{ Storage::url($p->foto) }}" title="Product Title">
                                                    <img src="{{ Storage::url($p->foto) }}" class="tab-image">
                                                </a>
                                            </figure>

                                            <h3>{{ $p->nama_paket }}</h3>

                                            <span class="qty">{{ $p->time_estimasi }} Estimasi</span>

                                            <span class="price">{{ rupiah($p->harga * 1.2) }}</span>

                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="input-group product-qty">
                                                    <span class="input-group-btn">
                                                        <button type="button"
                                                            class="quantity-left-minus btn btn-danger btn-number"
                                                            data-id="{{ $p->id }}" data-type="minus">
                                                            <svg width="16" height="16">
                                                                <use xlink:href="#minus"></use>
                                                            </svg>
                                                        </button>
                                                    </span>
                                                    <input type="text" id="quantity-{{ $p->id }}" name="quantity"
                                                        class="form-control input-number" value="1">
                                                    <span class="input-group-btn">
                                                        <button type="button"
                                                            class="quantity-right-plus btn btn-success btn-number"
                                                            data-id="{{ $p->id }}" data-type="plus">
                                                            <svg width="16" height="16">
                                                                <use xlink:href="#plus"></use>
                                                            </svg>
                                                        </button>
                                                    </span>
                                                </div>

                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="weight-label">{{ $p->berat }} kg</span>
                                                    <a href="#" class="nav-link" onclick="addToCart({{ $p->id }})">
                                                        <svg width="14" height="14">
                                                            <use xlink:href="#cart"></use>
                                                        </svg>
                                                        Add
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <!-- / product-grid -->


                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </section>

    <!-- Tambahan Javascript untuk Handler Penambahan dan Pengurangan Jumlah Produk -->

    <!-- Tambahkan JavaScript untuk animasi button yang diperbaiki -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add ripple effect to nav-link buttons
        document.querySelectorAll('.nav-link').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.4);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s ease-out;
                pointer-events: none;
            `;

                this.style.position = 'relative';
                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Enhanced quantity button animations and functionality
        document.querySelectorAll('.quantity-left-minus, .quantity-right-plus').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Animation effect
                this.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);

                // Find the quantity input
                const quantityInput = this.parentElement.querySelector(
                    'input[type="number"]') ||
                    this.parentElement.querySelector('input[id*="quantity"]') ||
                    this.nextElementSibling ||
                    this.previousElementSibling;

                if (quantityInput && quantityInput.type === 'number') {
                    let currentValue = parseInt(quantityInput.value) || 0;

                    if (this.classList.contains('quantity-left-minus')) {
                        // Decrease quantity (minimum 1)
                        if (currentValue > 1) {
                            quantityInput.value = currentValue - 1;
                            // Trigger change event
                            quantityInput.dispatchEvent(new Event('change', {
                                bubbles: true
                            }));
                        }
                    } else if (this.classList.contains('quantity-right-plus')) {
                        // Increase quantity
                        quantityInput.value = currentValue + 1;
                        // Trigger change event
                        quantityInput.dispatchEvent(new Event('change', {
                            bubbles: true
                        }));
                    }
                }
            });
        });

        // Alternative approach if quantity buttons are structured differently
        // This handles cases where buttons might be siblings or have different structure
        function handleQuantityButtons() {
            // Handle minus buttons
            document.querySelectorAll('[class*="minus"], [onclick*="minus"], [data-action="minus"]').forEach(
                btn => {
                    if (!btn.hasAttribute('data-quantity-handler')) {
                        btn.setAttribute('data-quantity-handler', 'true');
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();

                            const productId = this.getAttribute('data-product-id') ||
                                this.closest('[data-product-id]')?.getAttribute(
                                'data-product-id') ||
                                this.id?.replace(/[^0-9]/g, '') ||
                                this.closest('.product-item, .card, .item')?.querySelector(
                                    '[id*="quantity"]')?.id?.replace(/[^0-9]/g, '');

                            if (productId) {
                                const quantityInput = document.getElementById(
                                    `quantity-${productId}`);
                                if (quantityInput) {
                                    let currentValue = parseInt(quantityInput.value) || 1;
                                    if (currentValue > 1) {
                                        quantityInput.value = currentValue - 1;
                                        quantityInput.dispatchEvent(new Event('change', {
                                            bubbles: true
                                        }));
                                    }
                                }
                            }
                        });
                    }
                });

            // Handle plus buttons
            document.querySelectorAll('[class*="plus"], [onclick*="plus"], [data-action="plus"]').forEach(
            btn => {
                if (!btn.hasAttribute('data-quantity-handler')) {
                    btn.setAttribute('data-quantity-handler', 'true');
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        const productId = this.getAttribute('data-product-id') ||
                            this.closest('[data-product-id]')?.getAttribute(
                            'data-product-id') ||
                            this.id?.replace(/[^0-9]/g, '') ||
                            this.closest('.product-item, .card, .item')?.querySelector(
                                '[id*="quantity"]')?.id?.replace(/[^0-9]/g, '');

                        if (productId) {
                            const quantityInput = document.getElementById(
                                `quantity-${productId}`);
                            if (quantityInput) {
                                let currentValue = parseInt(quantityInput.value) || 0;
                                quantityInput.value = currentValue + 1;
                                quantityInput.dispatchEvent(new Event('change', {
                                    bubbles: true
                                }));
                            }
                        }
                    });
                }
            });
        }

        // Call the alternative handler
        handleQuantityButtons();

        // Re-run handler when new content is added dynamically
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    handleQuantityButtons();
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    });

    // Fungsi untuk mengubah quantity secara manual (dapat dipanggil dari HTML)
    function changeQuantity(productId, action) {
        const quantityInput = document.getElementById(`quantity-${productId}`);
        if (quantityInput) {
            let currentValue = parseInt(quantityInput.value) || 1;

            if (action === 'minus' && currentValue > 1) {
                quantityInput.value = currentValue - 1;
            } else if (action === 'plus') {
                quantityInput.value = currentValue + 1;
            }

            // Trigger change event
            quantityInput.dispatchEvent(new Event('change', {
                bubbles: true
            }));
        }
    }

    // Modifikasi fungsi addToCart yang ada untuk menambahkan loading state
    function addToCart(productId) {
        let quantityInput = document.getElementById("quantity-" + productId);
        let quantity = parseInt(quantityInput.value) || 1;

        console.log("ID Layanan:", productId);
        console.log("Quantity:", quantity);

        // Find the clicked button
        const btn = event.target.closest('.nav-link');
        const originalText = btn.innerHTML;

        // Add loading state
        btn.innerHTML = '<span class="loading">Adding...</span>';
        btn.style.pointerEvents = 'none';

        let formData = new FormData();
        formData.append("id_layanan", productId);
        formData.append("quantity", quantity);

        fetch("/tambah", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
                body: formData,
            })
            .then((response) => response.json())
            .then((data) => {
                console.log("Response:", data);

                // Restore button
                btn.innerHTML = originalText;
                btn.style.pointerEvents = 'auto';

                if (data.success) {
                    if (data.total_belanja) {
                        document.getElementById("total_belanja").textContent = data.total_belanja;
                    }

                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        text: "Produk berhasil ditambahkan ke keranjang!",
                        showConfirmButton: false,
                        timer: 2000,
                        background: 'rgba(255, 255, 255, 0.95)',
                        backdrop: 'rgba(0, 0, 0, 0.4)',
                        customClass: {
                            popup: 'enhanced-swal'
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: data.message || "Gagal menambahkan produk ke keranjang!",
                        background: 'rgba(255, 255, 255, 0.95)',
                        backdrop: 'rgba(0, 0, 0, 0.4)',
                        customClass: {
                            popup: 'enhanced-swal'
                        }
                    });
                }
            })
            .catch((error) => {
                console.error("Error:", error);

                // Restore button on error
                btn.innerHTML = originalText;
                btn.style.pointerEvents = 'auto';

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Terjadi kesalahan saat menambahkan produk ke keranjang.",
                    background: 'rgba(255, 255, 255, 0.95)',
                    backdrop: 'rgba(0, 0, 0, 0.4)',
                    customClass: {
                        popup: 'enhanced-swal'
                    }
                });
            });
    }
    </script>
    <!-- Akhir  Tambahan Javascript untuk Handler Penambahan dan Pengurangan Jumlah Produk-->
    @endsection