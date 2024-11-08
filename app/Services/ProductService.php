<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Models\Product;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts($filters = [])
    {
        return $this->productRepository->getAll($filters);
    }

    public function getProductById($id)
    {
        return $this->productRepository->findById($id);
    }

    public function createProduct(array $data, $images = [])
    {
        return $this->productRepository->create($data, $images);
    }

    public function updateProduct(Product $product, array $data, $images = [])
    {
        return $this->productRepository->update($product, $data, $images);
    }

    public function deleteProduct(Product $product)
    {
        return $this->productRepository->delete($product);
    }
}
