<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Inventory</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        h2 {
            text-align: center;
            margin-bottom: 4px;
        }

        .print-date {
            text-align: right;
            margin-bottom: 12px;
            color: #555;
        }

        .summary {
            margin-bottom: 15px;
        }

        .summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary td {
            padding: 6px;
            border: 1px solid #000;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 6px;
        }

        table.data th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>

{{-- HEADER --}}
<table width="100%" style="margin-bottom:15px;">
    <tr>
        <td style="text-align:left; vertical-align:top;">
            <strong style="font-size:16px;">⚡ Toko Bla Bla</strong><br>
            <span style="font-size:12px;">Bidang Usaha: Elektronik</span>
        </td>
        <td style="text-align:right; vertical-align:top; font-size:11px;">
            Dicetak pada:<br>
            {{ date('d-m-Y H:i') }}
        </td>
    </tr>
</table>

<hr style="margin-bottom:15px;">

<h2 style="margin-bottom:10px;">
    Laporan Inventory Produk
</h2>

{{-- RINGKASAN --}}
<div class="summary">
    <table>
        <tr>
            <td>Total Produk</td>
            <td>{{ $totalProducts }}</td>
            <td>Total Stok</td>
            <td>{{ $totalStock }}</td>
        </tr>
        <tr>
            <td>Stok Habis</td>
            <td>{{ $outOfStock }}</td>
            <td>Stok Menipis</td>
            <td>{{ $lowStock }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Total Nilai Inventori</strong></td>
            <td colspan="2">
                <strong>Rp {{ number_format($totalValue, 0, ',', '.') }}</strong>
            </td>
        </tr>
    </table>
</div>

{{-- TABEL PRODUK --}}
<table class="data">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Stock</th>
            <th>Harga</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $i => $product)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->stock }}</td>
            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($product->stock * $product->price, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>