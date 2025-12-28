<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $stock  = $request->stock; // filter baru

        $products = Product::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($stock === 'habis', function ($query) {
                $query->where('stock', 0);
            })
            ->when($stock === 'tersedia', function ($query) {
                $query->where('stock', '>', 0);
            })
            ->latest()
            ->paginate(5);

        return view('products.index', compact('products', 'search', 'stock'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
        ]);

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil disimpan');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

    public function exportPdf(Request $request)
    {
    $search = $request->search;
    $stock  = $request->stock;

    $products = Product::when($search, function ($q) use ($search) {
            $q->where('name', 'like', "%$search%");
        })
        ->when($stock, function ($q) use ($stock) {
            if ($stock === 'tersedia') {
                $q->where('stock', '>', 0);
            } elseif ($stock === 'habis') {
                $q->where('stock', '=', 0);
            }
        })
        ->get();

    // 🔢 RINGKASAN
    $totalProducts = $products->count();
    $totalStock    = $products->sum('stock');
    $outOfStock    = $products->where('stock', 0)->count();
    $lowStock      = $products->whereBetween('stock', [1, 10])->count();
    $totalValue    = $products->sum(fn ($p) => $p->stock * $p->price);

    $pdf = Pdf::loadView('products.pdf', compact(
        'products',
        'totalProducts',
        'totalStock',
        'outOfStock',
        'lowStock',
        'totalValue'
    ));

    return $pdf->download('laporan-inventory.pdf');
    }
}