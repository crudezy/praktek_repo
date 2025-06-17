@extends('layouts.app')

@section('konten')

    <body>

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
                <symbol xmlns="http://www.w3.org/2000/svg" id="close" viewBox="0 0 15 15">
                    <path fill="currentColor"
                        d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z" />
                </symbol>
            </defs>
        </svg>

        <div class="preloader-wrapper">
            <div class="preloader">
            </div>
        </div>

        <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart"
            aria-labelledby="My Cart">
            <div class="offcanvas-header justify-content-center">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Jumlah Barang</span>
                        <span id="cart-count" class="badge bg-primary rounded-pill">{{ $jml_brg ?? 0 }}</span>
                    </h4>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (IDR)</span>
                        <strong id="cart-total">{{ rupiah($total_tagihan) ?? 0 }}</strong>
                    </li>

                    <button class="w-100 btn btn-primary btn-lg" type="submit"
                        onclick="window.location.href='/lihatkeranjang'">Lihat Keranjang</button> <br><br>
                    <a href="/depan" class="w-100 btn btn-dark btn-lg" type="submit">Lihat Galeri</a> <br><br>
                    <a href="/lihatriwayat" class="w-100 btn btn-info btn-lg" type="submit">Riwayat Pemesanan</a> <br><br>
                    <a href="/logout" class="w-100 btn btn-danger btn-lg" type="submit">Keluar</a>
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

                        <div class="cart text-end d-none d-lg-block dropdown">
                            <button class="border-0 bg-transparent d-flex flex-column gap-2 lh-1" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                                <span class="fs-6 text-muted dropdown-toggle">Keranjang Anda</span>
                                <span class="cart-total fs-5 fw-bold"
                                    id="total_belanja">{{ rupiah($total_tagihan) ?? 0 }}</span>
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
                                <h3>Keranjang Anda</h3>
                            </div>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-all" role="tabpanel"
                                    aria-labelledby="nav-all-tab">

                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <div
                                        class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">

                                        @foreach ($layanans as $p)
                                            <div class="col">
                                                <div class="product-item">
                                                    <figure>
                                                        <a href="{{ Storage::url($p->foto) }}" title="Product Title">
                                                            <img src="{{ Storage::url($p->foto) }}" class="img-fluid">
                                                        </a>
                                                    </figure>
                                                    <h3>{{ $p->nama_paket }}</h3>
                                                    <span class="qty">Jumlah Pembelian: {{ $p->total_layanan }}
                                                        Unit</span><br>
                                                    <span class="qty"><b>Total :
                                                            {{ rupiah($p->total_belanja) }}</b></span><br>
                                                    <button class="w-100 btn btn-danger btn-sm" type="submit"
                                                        onclick="hapus({{ $p->id_layanan }})">Hapus</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- / product-grid -->

                                </div>

                            </div>
                        </div>

                        <!-- Tambahan List -->
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between">
                                <h6 class="my-0">Total</h6>
                                <strong>{{ rupiah($total_tagihan) }}</strong>
                            </li>
                        </ul>
                        <!-- <button class="w-100 btn btn-primary btn-lg" type="submit">Bayar</button> -->
                        <div class="text-center mt-4">
                            <button id="pay-button" class="w-100 btn btn-primary btn-lg">Bayar</button>
                        </div>
                        <!-- Akhir tambahan list -->

                    </div>
                </div>
            </div>
        </section>

        <!-- Tambahan script untuk payment gateway -->
        <script type="text/javascript">
            // Pastikan Midtrans Snap.js sudah dimuat
            var payButton = document.getElementById('pay-button');
            payButton.addEventListener('click', function() {
                // console.log("Token:", "{{ $snap_token }}");
                window.snap.pay('{{ $snap_token }}', {
                    onSuccess: function(result) {
                        console.log('Pembayaran berhasil:', result);
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Pembayaran Berhasil',
                            showConfirmButton: false,
                            timer: 2000 // Popup otomatis hilang setelah 2 detik
                        });
                        window.location.href = "/depan";
                    },
                    onPending: function(result) {
                        // console.log('Pembayaran tertunda:', result);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Pembayaran Tertunda'
                        });
                        window.location.href = "/depan";
                    },
                    onError: function(result) {
                        // console.log('Pembayaran gagal:', result);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Pembayaran Gagal'
                        });
                        // alert("Pembayaran gagal. Silakan coba lagi.");
                        window.location.href = "/depan";
                    },
                    onClose: function() {
                        alert("Anda menutup pop-up pembayaran sebelum menyelesaikan transaksi.");
                    }
                });
            });
        </script>

        <!-- untuk sintak hapus data -->
        <script>
            function hapus(idLayanan) {
                fetch(`/hapus/${idLayanan}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        },
                    })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error("HTTP error " + response.status);
                        }
                        return response.json();
                    })
                    .then((data) => {
                        console.log("Response:", data); // Debugging respons dari server
                        if (data.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil!",
                                text: data.message,
                                showConfirmButton: false,
                                timer: 2000,
                            });

                            // Reload halaman untuk memperbarui keranjang
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: data.message || "Gagal menghapus layanan dari keranjang!",
                            });
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error); // Debugging error di konsol
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: `Terjadi kesalahan saat menghapus layanan dari keranjang. Detail: ${error.message}`,
                        });
                    });
            }
        </script>
    @endsection
