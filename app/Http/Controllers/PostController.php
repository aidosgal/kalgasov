<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request): JsonResponse
    {
        $posts = $this->postService->getAll();
        return response()->json([
            "posts" => $posts,
            "message" => "Список всех постов",
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                "user_id" => "required",
                "description" => "required|string",
                "images" => "nullable|array",
                "images.*" => "image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            ]);

            $post = $this->postService->create($validated, $request);

            return response()->json([
                "post" => $post,
                "message" => "Пост успешно создан",
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                [
                    "error" => "Ошибка валидации данных.",
                    "message" => $e->errors(),
                ],
                422
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    "error" => "Произошла ошибка при создании поста.",
                    "message" => $e->getMessage(),
                ],
                500
            );
        }
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $validated = $request->validate([
            "description" => "nullable|string",
            "images" => "nullable|array",
            "images.*" => "image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ]);

        $post = $this->postService->update($id, $validated, $request);

        return response()->json([
            "post" => $post,
            "message" => "Пост успешно обновлен",
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        $this->postService->delete($id);

        return response()->json([
            "message" => "Пост успешно удален",
        ]);
    }
}
