@extends('layouts.app')

@section('konten')
<body>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <defs>
    <symbol xmlns="http://www.w3.org/2000/svg" id="cart" viewBox="0 0 24 24">
      <path fill="currentColor" d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545v.005l1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z"/>
    </symbol>
  </defs>
</svg>

<div class="preloader-wrapper">
  <div class="preloader">
  </div>
</div>

<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart" aria-labelledby="My Cart">
  <div class="offcanvas-header justify-content-center">
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="order-md-last">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-primary">Jumlah Layanan</span>
        <span id="cart-count" class="badge bg-primary rounded-pill">{{$jml_layanan ?? 0}}</span>
      </h4>

      <li class="list-group-item d-flex justify-content-between">
            <span>Total (IDR)</span>
            <strong id="cart-total">{{rupiah($total_tagihan) ?? 0}}</strong>
      </li>

      <button class="w-100 btn btn-primary btn-lg" type="submit" onclick="window.location.href='/lihatkeranjang'">Lihat Keranjang</button> <br><br>
      <a href="/depan" class="w-100 btn btn-dark btn-lg" type="submit">Lihat Galeri</a> <br><br>
      <a href="/lihatriwayat" class="w-100 btn btn-info btn-lg" type="submit">Riwayat Pemesanan</a> <br><br>
      <a href="/logout" class="w-100 btn btn-danger btn-lg" type="submit">Keluar</a>
    </div>
  </div>
</div>

<header>
  <div class="container-fluid">
    <div class="row py-3 border-bottom">
      <div class="col-sm-4 col-lg-3 text-center text-sm-start">
        <div class="main-logo">
          <a href="index.html">
            <img src="images/logo.png" alt="logo" class="img-fluid">
          </a>
        </div>
      </div>
      <div class="col-sm-6 offset-sm-2 offset-md-0 col-lg-5 d-none d-lg-block"></div>
      <div class="col-sm-8 col-lg-4 d-flex justify-content-end gap-5 align-items-center mt-4 mt-sm-0 justify-content-center justify-content-sm-end">
        <div class="cart text-end d-none d-lg-block dropdown">
          <button class="border-0 bg-transparent d-flex flex-column gap-2 lh-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
            <span class="fs-6 text-muted dropdown-toggle">Keranjang Anda</span>
            <span class="cart-total fs-5 fw-bold" id="total_belanja">{{rupiah($total_tagihan) ?? 0}}</span>
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
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Riwayat Pemesanan Anda</span>
          </h4>

        <!-- Tambahan List -->
          <ul class="list-group mb-3">
          @php
            $totalTagihan = 0;
          @endphp
          @foreach($transaksi as $p)
            @php
              $totalTagihan += $p->tagihan;
            @endphp
            <li class="list-group-item d-flex justify-content-between">
              <div>
                  <h6 class="my-0">{{ $p->no_faktur }}</h6>
                  <strong>Status: {{ $p->status }} pada {{ $p->tgl }}</strong><br>
                  <strong>Tagihan: {{ rupiah($p->tagihan) }}</strong>
              
              <ul class="mt-2 mb-0 ps-3">
                @foreach($detail_layanan[$p->id] ?? [] as $layanan)
                  <li>
                    {{ $layanan->nama_paket }} x {{ $layanan->jumlah }} = {{ rupiah($layanan->harga * $layanan->jumlah) }}
                  </li>
                @endforeach
              </ul>
              </div>
            </li>
          @endforeach
            <li class="list-group-item d-flex justify-content-between bg-light">
              <div class="text-success">
                <h6 class="my-0">Total Transaksi</h6>
              </div>
              <span><strong>{{ rupiah($totalTagihan) }}</strong></span>
            </li>
          </ul>
         <!-- Akhir tambahan list -->

      </div>
    </div>
  </div>
</section>

@endsection