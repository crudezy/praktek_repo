<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laundry Telkom</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('css/vendor.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style.css')}}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">

    <!-- Tambahan Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tambahan untuk Midtrans -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{env('MIDTRANS_CLIENT_KEY')}}"></script>

    <!-- Simple Blue Soft Footer Styles -->
    <style>
    :root {
        --primary-gradient: linear-gradient(135deg, #a8d8ea 0%, #7fb3d3 100%);
        --footer-bg: #2c3e50;
        --footer-text: rgba(255, 255, 255, 0.9);
        --footer-muted: rgba(255, 255, 255, 0.7);
        --blue-soft: #87ceeb;
        --blue-accent: #5dade2;
    }

    body {
        font-family: 'Nunito', sans-serif;
        background: var(--primary-gradient);
        min-height: 100vh;
        position: relative;
    }

    /* Simple Footer */
    footer {
        background-color: var(--footer-bg);
        margin-top: 50px;
        padding: 40px 0;
    }

    .footer-content {
        text-align: center;
    }

    .footer-logo {
        color: var(--footer-text);
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 15px;
        letter-spacing: 1px;
    }

    .footer-description {
        color: var(--footer-muted);
        font-size: 1rem;
        margin-bottom: 25px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    .footer-copyright {
        color: var(--footer-muted);
        font-size: 0.9rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 20px;
        margin-top: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .footer-logo {
            font-size: 1.5rem;
        }

        .footer-description {
            font-size: 0.95rem;
            padding: 0 20px;
        }
    }

    /* Enhanced Offcanvas Styling */
    .offcanvas {
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        border-left: 1px solid var(--card-border);
        box-shadow: -10px 0 30px rgba(116, 185, 255, 0.15);
    }

    .offcanvas-header {
        border-bottom: 1px solid var(--card-border);
        background: rgba(168, 216, 234, 0.1);
        padding: 20px;
    }

    .offcanvas-title {
        color: var(--text-primary);
        font-weight: 700;
        font-size: 1.5rem;
    }

    .btn-close {
        background: var(--card-bg);
        border-radius: 50%;
        opacity: 0.8;
        transition: var(--transition-smooth);
        box-shadow: var(--shadow-light);
    }

    .btn-close:hover {
        opacity: 1;
        transform: scale(1.1);
        box-shadow: var(--shadow-medium);
    }

    .offcanvas-body {
        padding: 20px;
        background: var(--card-bg);
    }

    /* Cart Summary Styling */
    .cart-summary {
        background: rgba(168, 216, 234, 0.1);
        border-radius: var(--border-radius);
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid var(--card-border);
    }

    .cart-summary h4 {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 1.2rem;
    }

    .cart-count-badge {
        background: var(--blue-primary) !important;
        color: white !important;
        border-radius: 20px !important;
        padding: 8px 12px !important;
        font-weight: 600 !important;
        box-shadow: var(--shadow-light);
    }

    .cart-total-item {
        background: var(--card-bg) !important;
        border: 1px solid var(--card-border) !important;
        border-radius: 12px !important;
        padding: 15px !important;
        margin-bottom: 15px !important;
        box-shadow: var(--shadow-light);
    }

    .cart-total-text {
        color: var(--text-secondary);
        font-weight: 500;
    }

    .cart-total-amount {
        color: var(--blue-secondary);
        font-weight: 700;
        font-size: 1.1rem;
    }

    /* Enhanced Navigation Buttons */
    .nav-button {
        background: var(--blue-primary) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 12px 20px !important;
        font-weight: 600 !important;
        font-size: 0.95rem !important;
        transition: var(--transition-smooth) !important;
        text-decoration: none !important;
        box-shadow: var(--shadow-light);
        display: block !important;
        text-align: center !important;
        margin-bottom: 12px !important;
        cursor: pointer;
    }

    .nav-button:hover {
        background: var(--blue-secondary) !important;
        color: white !important;
        transform: translateY(-2px) !important;
        box-shadow: var(--shadow-medium) !important;
        text-decoration: none !important;
    }

    .nav-button.btn-dark {
        background: #34495e !important;
    }

    .nav-button.btn-dark:hover {
        background: #2c3e50 !important;
    }

    .nav-button.btn-info {
        background: #17a2b8 !important;
    }

    .nav-button.btn-info:hover {
        background: #138496 !important;
    }

    .nav-button.btn-danger {
        background: #dc3545 !important;
    }

    .nav-button.btn-danger:hover {
        background: #c82333 !important;
    }

    /* Cart Icon Enhancement */
    .cart-dropdown {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid var(--card-border);
        border-radius: 12px;
        padding: 15px;
        transition: var(--transition-smooth);
    }

    .cart-dropdown:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .cart-label {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .cart-total-display {
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        text-shadow: 0 2px 4px rgba(116, 185, 255, 0.3);
    }

    /* Responsive Design untuk Offcanvas */
    @media (max-width: 768px) {
        .offcanvas {
            width: 90% !important;
        }

        .cart-summary {
            padding: 15px;
        }

        .nav-button {
            padding: 10px 15px !important;
            font-size: 0.9rem !important;
        }
    }
    </style>
</head>

@yield('konten')

<footer>
    <div class="container">
        <div class="footer-content">
            <h2 class="footer-logo">KitaLaundry.</h2>
            <p class="footer-description">
                Kami di sini untuk menjaga cucian Anda bersih dan rapi.
            </p>
            <div class="footer-copyright">
                © 2025 Laundry Luar Biasa. Semua hak dilindungi.
            </div>
        </div>
    </div>
</footer>

<script src="{{asset('js/jquery-1.11.0.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
</script>
<script src="{{asset('js/plugins.js')}}"></script>
<script src="{{asset('js/script.js')}}"></script>

</body>

</html>