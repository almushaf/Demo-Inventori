@extends('layouts.app')

@section('content')
<h3 class="mb-1">Dashboard</h3>
<p class="text-muted">Sistem Inventori · Toko Bla Bla</p>

<p class="text-muted">
    Ringkasan kondisi inventori saat ini.
</p>
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('products.index') }}" class="btn btn-primary">
        Kelola Produk
    </a>
</div>

{{-- SUMMARY --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Produk</h6>
                <h3>{{ $totalProducts }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Stok</h6>
                <h3>{{ $totalStock }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Nilai Inventori</h6>
                <h3>Rp {{ number_format($totalValue, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- WARNING SECTION --}}
<div class="row mb-4">
    {{-- STOK HABIS --}}
    <div class="col-md-6">
        <div class="card border-danger">
            <div class="card-body">
                <h6 class="text-danger">⚠ Produk Stok Habis</h6>

                @if($outOfStock->count())
                    <ul class="mb-0">
                        @foreach($outOfStock as $product)
                            <li>{{ $product->name }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mb-0">Tidak ada.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- STOK MENIPIS --}}
    <div class="col-md-6">
        <div class="card border-warning">
            <div class="card-body">
                <h6 class="text-warning">⚠ Produk Stok Menipis</h6>

                @if($lowStock->count())
                    <ul class="mb-0">
                        @foreach($lowStock as $product)
                            <li>{{ $product->name }} ({{ $product->stock }})</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mb-0">Tidak ada.</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- CHART --}}
<div class="card shadow-sm">
    <div class="card-body">
        <h6>Grafik Stok Produk</h6>
        <canvas id="stockChart" height="100"></canvas>
    </div>
</div>

{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('stockChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'Stok',
            data: @json($chartData),
            backgroundColor: '#0d6efd'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        }
    }
});
</script>

@endsection
