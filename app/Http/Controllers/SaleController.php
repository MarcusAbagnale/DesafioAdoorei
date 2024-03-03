<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\ProductSale;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

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
            $sale = Sale::findOrFail($id);
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



    public function addProductsToSale($saleId, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'products' => 'required|array',
                'products.*.product_id' => 'required|exists:products,product_id',
                'products.*.quantity' => 'required|integer|min:1',
                'products.*.total_amount' => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 400);
            }

            $sale = Sale::findOrFail($saleId);
            $totalAmount = 0;

            foreach ($request->input('products') as $productData) {
                $existingProduct = $sale->products()->where('products.product_id', $productData['product_id'])->first();

                if ($existingProduct) {
                    $this->updateProductInSale($existingProduct, $productData);
                } else {
                    $this->addNewProductToSale($sale, $productData);
                }
            }

            foreach ($sale->products as $product) {
                $totalAmount += $product->pivot->total_amount;
            }

            $sale->total_amount = $totalAmount;
            $sale->save();

            return response()->json(['message' => 'Produtos adicionados à venda com sucesso.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Venda não encontrada'], 404);
        }
    }



    protected function updateProductInSale($existingProduct, $productData)
    {
        $existingProduct->pivot->quantity += $productData['quantity'];
        $existingProduct->pivot->total_amount += $productData['total_amount'];
        $existingProduct->pivot->updated_at = now();
        $existingProduct->pivot->save();
    }

    protected function addNewProductToSale($sale, $productData)
    {
        $now = now();
        $sale->products()->attach($productData['product_id'], [
            'quantity' => $productData['quantity'],
            'total_amount' => $productData['total_amount'],
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }


    public function cancel($id)
    {
        try {
            $sale = Sale::findOrFail($id);

            if ($sale->cancelled_at !== null) {
                return response()->json(['message' => 'A venda já foi cancelada.'], 400);
            }
            $sale->cancelled_at = now();
            $sale->save();

            return response()->json(['message' => 'Venda cancelada com sucesso.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Venda não encontrada'], 404);
        }
    }

    private function formatSaleDetails($sale)
    {
        if (!($sale instanceof Sale)) {
            return [];
        }

        $formattedSale = [
            'sale_id' => $sale->sale_id,
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
