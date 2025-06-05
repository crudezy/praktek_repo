@extends('layout')

@section('konten')


<body>


<!-- Section ubah password -->
<section class="py-5">
    <div class="container-fluid">

    <div class="bg-secondary py-5 my-5 rounded-5" style="background: url('images/bg-leaves-img-pattern.png') no-repeat;">
        <div class="container my-5">
        <div class="row">
            <div class="col-md-6 p-5">
            <div class="section-header">
                <h2 class="section-title display-4">Ubah <span class="text-primary">Password</span></h2>
            </div>
            </div>
            <div class="col-md-6 p-5">
                <!-- Tambahan untuk menampilkan error jika ada -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                 <!-- Akhir tambahan menampilkan error -->
            <form action="{{ url('prosesubahpassword') }}" method="post">
            @csrf
                <div class="mb-3">
                <label for="name" class="form-label">Password</label>
                <input type="password"
                    class="form-control form-control-lg" name="password" id="password" placeholder="Masukkan Passsword Baru Anda">
                </div>
                
                <div class="d-grid gap-2">
                <button type="submit" class="btn btn-dark btn-lg">Submit</button>
                </div>
            </form>
            
            </div>
            
        </div>
        
        </div>
    </div>
    
    </div>
</section>


<!-- Tambahan Javascript untuk Handler Penambahan dan Pengurangan Jumlah Produk -->
<script>
    // event handler untuk proses tombol di tekan 
    document.addEventListener("click", function(event) {
            let target = event.target.closest(".btn-number"); // Pastikan tombol yang diklik adalah tombol plus/minus

            if (target) {
                let productId = target.getAttribute("data-id"); // Ambil ID produk dari tombol
                let quantityInput = document.getElementById("quantity-" + productId);
                // console.log(productId);
                // console.log(quantityInput.value);
                if (quantityInput) {
                    let value = parseInt(quantityInput.value) || 0;
                    let type = target.getAttribute("data-type"); // Cek apakah tombol plus atau minus

                    if (type === "plus") {
                        quantityInput.value = value + 1;
                    } else if (type === "minus" && value > 1) { 
                        // Mencegah nilai negatif atau nol
                        quantityInput.value = value - 1;
                    }
                    // console.log(quantityInput.value);
                    // Ambil nilainya setelah diubah
                    let currentQty = quantityInput.value;
                }
            }
      });

      // fungsi untuk menangani request
      function addToCart(productId) {
    let quantityInput = document.getElementById("quantity-" + productId);
    let quantity = parseInt(quantityInput.value) || 1;

    console.log("ID Layanan:", productId); // Debugging ID layanan
    console.log("Quantity:", quantity); // Debugging jumlah

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
            console.log("Response:", data); // Debugging respons dari server
            if (data.success) {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: "Produk berhasil ditambahkan ke keranjang!",
                    showConfirmButton: false,
                    timer: 2000,
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: data.message || "Gagal menambahkan produk ke keranjang!",
                });
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Terjadi kesalahan saat menambahkan produk ke keranjang.",
            });
        });
}

 </script>
<!-- Akhir  Tambahan Javascript untuk Handler Penambahan dan Pengurangan Jumlah Produk-->


<!--  -->

@endsection

