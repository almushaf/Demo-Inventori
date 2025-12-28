@extends('layouts.app')

@section('title', 'Inventory')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Inventory Products</h2>
    <div>
        {{-- Export PDF (ikut search + filter) --}}
        <a href="{{ route('products.export.pdf', request()->query()) }}"
           class="btn btn-outline-danger me-2">
            Export PDF
        </a>

        <a href="{{ route('dashboard') }}" class="btn btn-dark me-2">
            Dashboard
        </a>

        <a href="{{ route('products.create') }}" class="btn btn-primary">
            + Tambah Produk
        </a>
    </div>
</div>

{{-- SEARCH + FILTER --}}
<form method="GET" class="mb-3 row g-2 align-items-center">

    {{-- SEARCH INPUT --}}
    <div class="col-md-5 position-relative">
        <input type="text"
               id="searchInput"
               name="search"
               value="{{ $search ?? '' }}"
               class="form-control pe-5"
               placeholder="Cari produk..."
               oninput="toggleClear()">

        <button type="button"
                id="clearBtn"
                onclick="clearSearch()"
                class="btn btn-sm btn-light position-absolute top-50 end-0 translate-middle-y me-2"
                style="border:none; display:none;">
            ✕
        </button>
    </div>

    {{-- FILTER STOCK --}}
    <div class="col-md-4">
        <select name="stock" class="form-select">
            <option value="">Semua Stok</option>
            <option value="tersedia" {{ ($stock ?? '') == 'tersedia' ? 'selected' : '' }}>
                Stok Tersedia
            </option>
            <option value="habis" {{ ($stock ?? '') == 'habis' ? 'selected' : '' }}>
                Stok Habis
            </option>
        </select>
    </div>

    {{-- BUTTON CARI --}}
    <div class="col-md-3 d-grid">
        <button type="submit" class="btn btn-outline-secondary">
            Cari
        </button>
    </div>
</form>

{{-- ALERT --}}
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- TABLE --}}
@if ($products->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Stock</th>
                <th>Harga</th>
                <th width="160">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->stock }}</td>
                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}"
                       class="btn btn-sm btn-warning">
                        Edit
                    </a>

                    <form action="{{ route('products.destroy', $product->id) }}"
                          method="POST"
                          style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus produk ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- PAGINATION --}}
    <div class="mt-3">
        {{ $products->withQueryString()->links() }}
    </div>
@else
    <div class="alert alert-info">
        Belum ada produk.
    </div>
@endif

{{-- SCRIPT (KHUSUS CLEAR INPUT) --}}
<script>
function toggleClear() {
    const input = document.getElementById('searchInput');
    const btn = document.getElementById('clearBtn');
    btn.style.display = input.value ? 'block' : 'none';
}

function clearSearch() {
    const input = document.getElementById('searchInput');
    input.value = '';
    input.focus();
    toggleClear();
}

// saat halaman load & ada value lama
document.addEventListener('DOMContentLoaded', toggleClear);
</script>

@endsection
