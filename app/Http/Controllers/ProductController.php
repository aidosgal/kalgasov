<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $filters = $request->only("search");
        $products = $this->productService->getAllProducts($filters);

        return response()->json($products);
    }

    public function show($id)
    {
        $product = $this->productService->getProductById($id);

        return response()->json($product);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            "store_id" => "required|integer",
            "name" => "required|string|max:255",
            "description" => "nullable|string",
            "price" => "required|numeric",
        ]);

        $images = $request->file("images", []);

        $product = $this->productService->createProduct($data, $images);

        return response()->json($product, 201);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            "name" => "sometimes|string|max:255",
            "description" => "nullable|string",
            "price" => "sometimes|numeric",
        ]);

        $images = $request->file("images", []);

        $updatedProduct = $this->productService->updateProduct(
            $product,
            $data,
            $images
        );

        return response()->json($updatedProduct);
    }

    public function delete(Product $product)
    {
        $this->productService->deleteProduct($product);

        return response()->json(["message" => "Product deleted successfully"]);
    }
}
