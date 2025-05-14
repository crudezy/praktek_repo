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
