<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductRepository
{
    public function getAll($filters = [])
    {
        $query = Product::query();

        if (!empty($filters["search"])) {
            $search = $filters["search"];
            $query
                ->where("name", "LIKE", "%$search%")
                ->orWhere("description", "LIKE", "%$search%");
        }

        return $query->with("images")->get();
    }

    public function findById($id)
    {
        return Product::with("images")->findOrFail($id);
    }

    public function create(array $data, $images = [])
    {
        $product = Product::create($data);

        $this->saveImages($product, $images);

        return $product->load("images");
    }

    public function update(Product $product, array $data, $images = [])
    {
        $product->update($data);

        $product->images()->delete();
        $this->saveImages($product, $images);

        return $product->load("images");
    }

    public function delete(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::delete($image->image_url);
        }
        $product->images()->delete();
        return $product->delete();
    }

    protected function saveImages(Product $product, $images)
    {
        foreach ($images as $image) {
            $path = $image->store("product_images", "public");
            ProductImage::create([
                "product_id" => $product->id,
                "image_url" => $path,
            ]);
        }
    }
}
