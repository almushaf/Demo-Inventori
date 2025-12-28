<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalProducts' => Product::count(),
            'totalStock'    => Product::sum('stock'),
            'totalValue'    => Product::sum(DB::raw('stock * price')),
        
            // 🔴 stok habis
            'outOfStock'    => Product::where('stock', 0)->get(),

            // 🟠 stok menipis (<= 10)
            'lowStock'      => Product::whereBetween('stock', [1, 10])->get(),

            // 📊 data grafik
            'chartLabels'   => Product::pluck('name'),
            'chartData'     => Product::pluck('stock'),
        ]);
    }
}
