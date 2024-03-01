<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\ProductSale;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('products')->get();

        $formattedSales = [];

        foreach ($sales as $sale) {
            $formattedSales[] = $this->formatSaleDetails($sale);
        }

        return response()->json($formattedSales);
    }

    public function store(Request $request)
    {
        $request->validate([
            '*.product_id' => 'required',
            '*.quantity' => 'required|numeric',
            '*.total_amount' => 'required|numeric',
        ]);

        $total = 0;

        foreach ($request->all() as $saleData) {
            $total += $saleData['total_amount'];
        }

        $sale = Sale::create(['total' => $total]);

        foreach ($request->all() as $saleData) {
            ProductSale::create([
                'sale_id' => $sale->id,
                'product_id' => $saleData['product_id'],
                'quantity' => $saleData['quantity']
            ]);
        }

        return response()->json(['message' => 'Venda criada com sucesso'], 201);
    }

    private function formatSaleDetails($sale)
    {
        if (!($sale instanceof Sale)) {
            return [];
        }

        return [
            'sale_id' => $sale->sale_id,
            'amount' => $sale->total,
        ];
    }
}
