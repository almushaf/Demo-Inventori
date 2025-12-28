@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')

<h2>Tambah Produk</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('products.store') }}" method="POST" class="mt-3">
    @csrf

    <div class="mb-3">
        <label class="form-label">Nama Produk</label>
        <input
            type="text"
            name="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name') }}"
            required
        >
    </div>

    <div class="mb-3">
        <label class="form-label">Stock</label>
        <input
            type="number"
            name="stock"
            class="form-control @error('stock') is-invalid @enderror"
            value="{{ old('stock') }}"
            required
        >
    </div>

    <div class="mb-3">
        <label class="form-label">Harga</label>
        <input
            type="number"
            name="price"
            class="form-control @error('price') is-invalid @enderror"
            value="{{ old('price') }}"
            required
        >
    </div>

    <button class="btn btn-success">Simpan</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
</form>

@endsection