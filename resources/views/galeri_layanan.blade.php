@extends('layout')

@section('konten')
<div class="container">
    <h1>Daftar Layanan</h1>
    <table class="table" id="layanan-table">
        <thead>
            <tr>
                <th>ID Layanan</th>
                <th>Nama Paket</th>
                <th>Harga (per kg)</th>
                <th>Estimasi Waktu</th>
                <th>Keterangan</th>
                <th>Berat (kg)</th>
                <th>Tambah ke Keranjang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($layanan as $layanan)
            <tr data-id="{{ $layanan->id_layanan }}" data-harga="{{ $layanan->harga }}">
                <td>{{ $layanan->id_layanan }}</td>
                <td>{{ $layanan->nama_paket }}</td>
                <td>{{ number_format($layanan->harga, 0, ',', '.') }}</td>
                <td>{{ $layanan->time_estimasi }}</td>
                <td>{{ $layanan->keterangan }}</td>
                <td><input type="number" min="0" step="0.1" class="berat-input" value="0" style="width: 80px;"></td>
                <td><button class="btn btn-primary btn-tambah">Tambah</button></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Keranjang</h3>
    <table class="table" id="keranjang-table">
        <thead>
            <tr>
                <th>Nama Paket</th>
                <th>Berat (kg)</th>
                <th>Harga per kg</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <!-- Isi keranjang akan muncul di sini -->
        </tbody>
    </table>

    <h3>Total Belanja: Rp <span id="total-belanja">0</span></h3>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const keranjang = {};

    function updateKeranjangTable() {
        const tbody = document.querySelector('#keranjang-table tbody');
        tbody.innerHTML = '';
        let total = 0;

        for (const id in keranjang) {
            const item = keranjang[id];
            const subtotal = item.berat * item.harga;
            total += subtotal;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${item.nama}</td>
                <td>${item.berat.toFixed(2)}</td>
                <td>Rp ${item.harga.toLocaleString('id-ID')}</td>
                <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td><button class="btn btn-danger btn-hapus" data-id="${id}">Hapus</button></td>
            `;
            tbody.appendChild(tr);
        }

        document.getElementById('total-belanja').textContent = total.toLocaleString('id-ID');
    }

    document.querySelectorAll('.btn-tambah').forEach(button => {
        button.addEventListener('click', function() {
            const tr = this.closest('tr');
            const id = tr.getAttribute('data-id');
            const nama = tr.children[1].textContent;
            const harga = parseFloat(tr.getAttribute('data-harga'));
            const beratInput = tr.querySelector('.berat-input');
            const berat = parseFloat(beratInput.value);

            if (berat <= 0 || isNaN(berat)) {
                alert('Masukkan berat yang valid lebih dari 0');
                return;
            }

            if (keranjang[id]) {
                keranjang[id].berat += berat;
            } else {
                keranjang[id] = { nama, berat, harga };
            }

            beratInput.value = 0;
            updateKeranjangTable();
        });
    });

    document.querySelector('#keranjang-table tbody').addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-hapus')) {
            const id = e.target.getAttribute('data-id');
            delete keranjang[id];
            updateKeranjangTable();
        }
    });
});
</script>
@endsection
