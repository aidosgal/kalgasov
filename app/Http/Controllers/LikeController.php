<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    /**
     * Store a like for a post or product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "user_id" => "required",
            "post_id" => "nullable|exists:posts,id",
            "product_id" => "nullable|exists:products,id",
        ]);

        if (!$validated["post_id"] && !$validated["product_id"]) {
            return response()->json(
                ["error" => "Either post_id or product_id must be provided."],
                400
            );
        }

        $like = Like::create([
            "user_id" => $validated["user_id"],
            "post_id" => $validated["post_id"] ?? null,
            "product_id" => $validated["product_id"] ?? null,
        ]);

        return response()->json([
            "message" => "Like created successfully",
            "like" => $like,
        ]);
    }

    /**
     * Remove a like for a post or product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "user_id" => "required",
            "post_id" => "nullable|exists:posts,id",
            "product_id" => "nullable|exists:products,id",
        ]);

        if (!$validated["post_id"] && !$validated["product_id"]) {
            return response()->json(
                ["error" => "Either post_id or product_id must be provided."],
                400
            );
        }

        $like = Like::where("user_id", $validated["user_id"])
            ->where(function ($query) use ($validated) {
                if ($validated["post_id"]) {
                    $query->where("post_id", $validated["post_id"]);
                }
                if ($validated["product_id"]) {
                    $query->where("product_id", $validated["product_id"]);
                }
            })
            ->first();

        if ($like) {
            $like->delete();

            return response()->json([
                "message" => "Like deleted successfully",
            ]);
        }

        return response()->json(
            [
                "error" => "Like not found",
            ],
            404
        );
    }
}
