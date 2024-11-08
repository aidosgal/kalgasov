<?php

namespace App\Http\Controllers;

use App\Services\StoreService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    protected $storeService;

    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    /**
     * Get a list of stores.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $stores = $this->storeService->getAll();

        return response()->json([
            "stores" => $stores,
        ]);
    }

    /**
     * Show a single store.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $store = $this->storeService->getById($id);

        if (!$store) {
            return response()->json(
                [
                    "error" => "Store not found",
                ],
                404
            );
        }

        return response()->json([
            "store" => $store,
        ]);
    }

    /**
     * Create a new store.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "user_id" => "required",
            "name" => "required|string|max:255",
            "description" => "nullable|string",
            "city" => "nullable|string",
            "phone" => "nullable|string",
            "link1" => "nullable|string|url",
            "link2" => "nullable|string|url",
            "link3" => "nullable|string|url",
            "avatar_url" => "nullable|url",
            "background_url" => "nullable|url",
        ]);

        $store = $this->storeService->create($validated);

        return response()->json([
            "store" => $store,
            "message" => "Store created successfully.",
        ]);
    }

    /**
     * Update an existing store.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "description" => "nullable|string",
            "city" => "nullable|string",
            "phone" => "nullable|string",
            "link1" => "nullable|string|url",
            "link2" => "nullable|string|url",
            "link3" => "nullable|string|url",
            "avatar_url" => "nullable|url",
            "background_url" => "nullable|url",
        ]);

        $store = $this->storeService->update($id, $validated);

        return response()->json([
            "store" => $store,
            "message" => "Store updated successfully.",
        ]);
    }

    /**
     * Delete a store.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $deleted = $this->storeService->delete($id);

        if (!$deleted) {
            return response()->json(
                [
                    "error" => "Store not found or could not be deleted",
                ],
                404
            );
        }

        return response()->json([
            "message" => "Store deleted successfully.",
        ]);
    }
}
