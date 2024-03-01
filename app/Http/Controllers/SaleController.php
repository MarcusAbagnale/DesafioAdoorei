<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\ProductSale;
use Illuminate\Database\Eloquent\ModelNotFoundException;


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

    public function show($id)
    {
        try {
            $sale = Sale::with('products')->findOrFail($id);
            $formattedSale = $this->formatSaleDetails($sale);
            return response()->json($formattedSale);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Venda não encontrada'], 404);
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            '*.total_amount' => 'required|numeric',
        ]);

        $total = 0;

        foreach ($request->all() as $saleData) {
            $total += $saleData['total_amount'];
        }

        $sale = Sale::create(['total_amount' => $total]);

        foreach ($request->all() as $saleData) {
            ProductSale::create([
                'sale_id' => $sale->sale_id,
                'product_id' => $saleData['product_id'],
                'quantity' => $saleData['quantity'],
                'total_amount' => $saleData['total_amount']
            ]);
        }

        return response()->json(['message' => 'Venda criada com sucesso'], 201);
    }


    private function formatSaleDetails($sale)
    {
        if (!($sale instanceof Sale)) {
            return [];
        }

        $formattedSale = [
            'sales_id' => $sale->sale_id,
            'amount' => $sale->total_amount,
            'products' => []
        ];

        foreach ($sale->products as $product) {
            $formattedSale['products'][] = [
                'product_id' => $product->product_id,
                'nome' => $product->name,
                'price' => $product->pivot->total_amount,
                'quantity' => $product->pivot->quantity
            ];
        }

        return $formattedSale;
    }
}
