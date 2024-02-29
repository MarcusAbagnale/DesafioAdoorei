<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;

use Illuminate\Http\Request;

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
            'product_id' => 'required',
            'quantity' => 'required|numeric',
            'total_amount' => 'required|numeric',
        ]);

        $sale = Sale::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_amount' => $request->total_amount,
        ]);

        return response()->json(['message' => 'Venda criada com sucesso', 'sale' => $sale], 201);
    }

    private function formatSaleDetails($sale)
    {
        if (!($sale instanceof Sale)) {
            return [];
        }

        $saleDetails = [
            'sale_id' => $sale->sale_id,
            'amount' => $sale->total_amount,
            'products' => []
        ];

        foreach ($sale->products as $product) {

            $productDetails = $this->findProductDetails($product->product_id);

            if ($productDetails) {
                $saleDetails['products'][] = [
                    'product_id' => $product->id,
                    'nome' => $productDetails->name,
                    'price' => $productDetails->price,
                    'amount' => $product->pivot->quantity
                ];
            }
        }

        return $saleDetails;
    }

    private function findProductDetails($productId)
    {
        return Product::find($productId);
    }
}
