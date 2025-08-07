<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index()
    {
        return ProductResource::collection(Product::paginate(10));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'vendor_id' => 'required|exists:vendors,id',
        ]);

        $product = Product::create($validatedData);

        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'vendor_id' => 'sometimes|required|exists:vendors,id',
        ]);

        $product->update($validatedData);

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response(null, 204); // 204 No Content
    }
    
    public function search($key)
    {
        $products = Product::where('name', 'like', "%$key%")
                             ->orWhere('description', 'like', "%$key%")
                             ->paginate(10);
        
        return ProductResource::collection($products);
    }
}