<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Landing Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body class="bg-white text-gray-900">

  <!-- HEADER -->
  <header class="flex items-center justify-between px-8 py-4 shadow-md">
  <div class="flex items-center gap-8">

                    <div class="col-sm-4 col-lg-3 text-center text-sm-start">
                        <div class="main-logo">
                            <a href="/depan"
                                class="d-flex align-items-center justify-content-center justify-content-sm-start">
                                <img src="images/logo.png" alt="logo" class="img-fluid">
                            </a>
                        </div>
                    </div>
    </div>


    <!-- Login button -->
    <div>
      <a href="/login" class="px-5 py-2 text-sm font-medium text-blue-600 border border-blue-600 rounded-full hover:bg-blue-600 hover:text-white transition">
        Login
      </a>
    </div>
  </header>

  <!-- MAIN SECTION -->
  <section class="relative px-8 py-20 flex items-center justify-center" style="min-height: calc(100vh - 4rem); background-image: url('{{ asset('images/background.jpeg') }}'); background-size: cover; background-position: center;">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>

    <!-- Konten -->
    <div class="relative max-w-4xl text-center bg-white bg-opacity-80 p-8 rounded-lg shadow-lg">
        <h1 class="text-4xl font-bold leading-tight text-gray-900">Where every fabric enjoys a <span class="text-blue-400">gentle</span>, refreshing breeze</h1>
        <p class="mt-4 text-lg text-gray-600">
            Solusi laundry terpercaya dengan pelayanan cepat, bersih, dan tanpa ribet.
        </p>
        <div class="mt-6">
            <a href="#" class="px-6 py-3 text-white bg-blue-600 rounded-full hover:bg-blue-700 transition">
                Schedule a Pickup
            </a>
        </div>
    </div>
</section>

    <!-- How It Works -->
    <section class="py-16 px-8 md:px-16 flex flex-col md:flex-row items-center gap-8">
    <div class="container mx-auto flex flex-col md:flex-row items-center gap-12 px-4">
        <!-- Teks Deskripsi -->
        <div class="md:w-1/2">
            <h2 class="text-3xl font-bold mb-4">Siapa Kami?</h2>
            <p class="text-lg text-gray-600 mb-4">
                Kami adalah platform laundry online yang membuat hidup Anda lebih mudah. Dengan sistem antar-jemput yang super praktis, cuci, setrika, dan lipat pakaian Anda kini hanya beberapa klik saja!
            </p>
            <p class="text-lg font-semibold text-gray-800">
                Laundry Anda, cara Anda.
            </p>
        </div>

        <!-- Gambar -->
        <div class="md:w-1/2">
            <img src="{{ asset('images/gambar1.jpg') }}" alt="Laundry Image" class="rounded-lg shadow-lg w-full h-auto object-cover">
        </div>
    </div>
</section>

    <!-- Our Services -->
<section id="services" class="bg-gray-50 py-16">
    <div class="container mx-auto px-8 md:px-16">
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Jemput-Antar GRATIS -->
            <div class="flex items-start gap-4">
                <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-lg">
                    <i class='bx bx-bar-chart text-4xl text-blue-600'></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-blue-600">Jemput-Antar GRATIS</h3>
                    <p class="text-sm text-gray-600">
                        Nikmati layanan jemput-antar tanpa biaya tambahan dalam radius yang telah ditentukan, karena kami peduli dengan kenyamanan Anda.
                    </p>
                </div>
            </div>

            <!-- Pelacakan Real-Time -->
            <div class="flex items-start gap-4">
                <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-lg">
                    <i class='bx bx-timer text-4xl text-blue-600'></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-blue-600">Pelacakan Real-Time</h3>
                    <p class="text-sm text-gray-600">
                        Dengan sistem pelacakan laundry secara real-time, Anda bisa tahu kapan cucian Anda akan tiba, jadi tidak ada lagi kejutan.
                    </p>
                </div>
            </div>

            <!-- Metode Pembayaran Cashless -->
            <div class="flex items-start gap-4">
                <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-lg">
                    <i class='bx bx-wallet-alt text-4xl text-blue-600'></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-blue-600">Metode Pembayaran Cashless</h3>
                    <p class="text-sm text-gray-600">
                        Bayar dengan mudah, aman, dan cepat tanpa ribet menggunakan metode pembayaran digital. Kami tidak suka antri, dan Anda juga tidak!
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Pricing -->
    <section id="pricing" class="py-16 px-8 bg-whitex`-50">
    <div class="container mx-auto px-4 md:px-16 flex flex-col md:flex-row items-center gap-12">
        <!-- Gambar -->
        <div class="md:w-1/2">
            <img src="{{ ('images/layanan.jpg') }}" alt="Pricing Image" class="rounded-lg shadow-lg w-full h-auto object-cover">
        </div>
        <!-- Teks -->
<div class="md:w-1/2 px-8 md:px-16">
    <h2 class="text-3xl font-bold text-blue-600 mb-6">Layanan Kami</h2>
    <p class="text-lg text-gray-600 mb-4">
        Kami menawarkan berbagai layanan laundry yang dirancang untuk memenuhi kebutuhan Anda. Semua dalam satu tempat!
    </p>
    <ul class="space-y-4">
        <li class="flex items-start gap-2">
            <span class="text-blue-600 text-xl">✔</span>
            <div>
                <h3 class="font-bold text-gray-800">Cuci & Setrika</h3>
                <p class="text-sm text-gray-600">Cuci dan setrika pakaian Anda dengan hasil terbaik, tanpa Anda harus melakukannya sendiri!</p>
            </div>
        </li>
        <li class="flex items-start gap-2">
            <span class="text-blue-600 text-xl">✔</span>
            <div>
                <h3 class="font-bold text-gray-800">Lipat Pakaian</h3>
                <p class="text-sm text-gray-600">Lipat pakaian Anda dengan rapi dan siap untuk disimpan, karena kami tahu Anda tidak suka berantakan.</p>
            </div>
        </li>
        <li class="flex items-start gap-2">
            <span class="text-blue-600 text-xl">✔</span>
            <div>
                <h3 class="font-bold text-gray-800">Layanan Khusus</h3>
                <p class="text-sm text-gray-600">Butuh layanan khusus? Kami dapat menyesuaikan layanan untuk memenuhi kebutuhan spesifik Anda.</p>
            </div>
        </li>
    </ul>
</div>
</section>

    <!-- Testimonials -->
    <section class="bg-gray-50 py-16 px-4">
    <div class="container mx-auto px-4 md:px-16 flex flex-col md:flex-row items-center gap-8">
        <!-- Gambar -->
        <div class="md:w-1/3">
            <img src="{{ asset('images/jouvan.jpg') }}" alt="Client Testimonial" class="rounded-lg shadow-lg w-full h-auto object-cover">
        </div>

        <!-- Testimonial -->
        <div class="md:w-2/3">
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">What Our Clients Say</h2>
            <div class="flex items-center mb-4">
                <!-- Rating -->
                <div class="flex text-yellow-500 text-xl">
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                </div>
            </div>
            <blockquote class="text-lg font-semibold text-gray-800">
                "Laundry Luar Biasa telah mengubah hidup saya! Sekarang saya punya lebih banyak waktu untuk bersantai daripada mengurus cucian."
            </blockquote>
            <footer class="mt-4 text-sm font-bold text-gray-600">
                — Jouvan Augusto <br>
                <span class="text-gray-500">Pelanggan Puas</span>
            </footer>
        </div>
    </div>
</section>

<!-- Bangga -->
<section class="bg-blue-50 py-16 px-4 text-center">
    <div class="container mx-auto">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Kami Bangga Menyajikan Angka Ini</h2>
        <p class="text-lg text-gray-600 mb-10">
            Lihat bagaimana kami telah membantu pelanggan kami menikmati hidup tanpa stres.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Pakaian Dicuci -->
            <div>
                <h3 class="text-4xl font-bold text-gray-800">10,000+</h3>
                <p class="text-sm text-gray-600">Pakaian Dicuci</p>
            </div>
            <!-- Pelanggan Puas -->
            <div>
                <h3 class="text-4xl font-bold text-gray-800">2,500+</h3>
                <p class="text-sm text-gray-600">Pelanggan Puas</p>
            </div>
            <!-- Layanan Tersedia -->
            <div>
                <h3 class="text-4xl font-bold text-gray-800">24/7</h3>
                <p class="text-sm text-gray-600">Layanan Tersedia</p>
            </div>
        </div>
    </div>
</section>

    <!-- hubungi kami -->
    <section class="bg-grey-100 py-16 px-4 text-center">
    <h2 class="text-3xl font-bold text-blue-600 mb-4">Siap untuk Hidup Lebih Mudah?</h2>
    <p class="text-lg text-gray-600 mb-6">
        Jangan tunggu lagi! Bergabunglah dengan ribuan pelanggan puas dan nikmati layanan laundry terbaik di kota.
    </p>
    <div class="flex justify-center gap-4">
        <a href="#" class="px-6 py-3 border border-gray-800 text-gray-800 rounded-full hover:bg-gray-800 hover:text-white transition">
            Pesan Sekarang
        </a>
        <a href="#" class="px-6 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition">
            Hubungi Kami
        </a>
    </div>
</section>

<!-- footer -->
<footer class="bg-gray-800 text-white py-6">
    <div class="container mx-auto px-4 md:px-16">
        <!-- Logo dan Deskripsi -->
        <div class="text-center md:text-left mb-0">
            <h3 class="text-xl font-bold mb-2">KitaLaundry.</h3>
            <p class="text-sm text-gray-400">
                Kami di sini untuk menjaga cucian Anda bersih dan rapi.
            </p>
        </div>

        <!-- Links -->
        <div class="flex flex-col md:flex-row justify-center md:justify-between items-center md:items-start gap-4 md:gap-8 mb-8">
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-700 pt-4 text-center">
            <p class="text-sm text-gray-400">
                © 2025 Laundry Luar Biasa. Semua hak dilindungi.
            </p>
        </div>
    </div>
</footer>


</body>
</html>
