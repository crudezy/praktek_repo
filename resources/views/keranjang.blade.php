@extends('layout')

@section('konten')
<body>

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

@include('layouts.header_ui')

<section class="py-5">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="bootstrap-tabs product-tabs">
          <div class="tabs-header d-flex justify-content-between border-bottom my-5">
            <h3>Keranjang Anda</h3>
          </div>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
              <meta name="csrf-token" content="{{ csrf_token() }}">
              <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                @foreach($layanan as $p)
                <div class="col">
                  <div class="product-item">
                    <figure>
                      <a href="{{ Storage::url($p->foto) }}" title="Layanan">
                        <img src="{{ Storage::url($p->foto) }}" class="img-fluid">
                      </a>
                    </figure>
                    <h3>{{$p->nama_paket}}</h3>
                    <span class="qty">Jumlah: {{ $p->jumlah }} Unit</span><br>
                    <span class="qty"><b>Total : {{rupiah($p->total_harga)}}</b></span> <br>
                    <button class="w-100 btn btn-danger btn-sm" type="submit" onclick="hapus({{ $p->layanan_id }})">Hapus</button>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>

        <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between">
            <h6 class="my-0">Total</h6>
            <strong>{{rupiah($total_tagihan)}}</strong>
          </li>
        </ul>
        <div class="text-center mt-4">
          <button id="pay-button" class="w-100 btn btn-primary btn-lg">Bayar</button>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        window.snap.pay('{{$snap_token}}', {
        onSuccess: function(result){
            Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Pembayaran Berhasil',
                    showConfirmButton: false,
                    timer: 2000
                });
            window.location.href = "/depan";
        },
        onPending: function(result){
            Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Pembayaran Tertunda'
                });
            window.location.href = "/depan";
        },
        onError: function(result){
            Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Pembayaran Gagal'
                });
            window.location.href = "/depan";
        },
        onClose: function(){
            alert("Anda menutup pop-up pembayaran sebelum menyelesaikan transaksi.");
        }
        });
    });
</script>

<script>
  function hapus(layanan_id) {
        fetch('/hapus/'+layanan_id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Layanan berhasil dihapus dari keranjang!',
                    showConfirmButton: false,
                    timer: 2000
                });

                let formatter = new Intl.NumberFormat('id-ID', {
                              style: 'currency',
                              currency: 'IDR',
                              minimumFractionDigits: 0
                            });
                let vtotal = formatter.format(data.total);
                document.getElementById('cart-total').textContent = "Total: " +vtotal;
                document.getElementById('total_belanja').textContent = vtotal;
                document.getElementById('cart-count').textContent = data.jml_layanan;

                location.reload();
            } else {
                console.log(data);
            }
        })
        .catch(error => {
          Swal.fire({
              icon: 'error',
              title: 'Terjadi Kesalahan',
              text: error.message || 'Terjadi kesalahan saat menghapus layanan.',
          });
        });
    }
</script>

@endsection