<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                "user_id" => "required",
                "post_id" => "required|exists:posts,id",
                "comment" => "required|string",
                "comment_id" => "nullable|exists:comments,id",
            ]);

            $comment = $this->commentService->create($validated, $request);

            return response()->json([
                "comment" => $comment,
                "message" => "Комментарий успешно добавлен",
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
                    "error" => "Произошла ошибка при обновлении.",
                    "message" => $e->getMessage(),
                ],
                500
            );
        }
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $validated = $request->validate([
            "comment" => "required|string",
        ]);

        $comment = $this->commentService->update($id, $validated, $request);

        return response()->json([
            "comment" => $comment,
            "message" => "Комментарий успешно обновлен",
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        $this->commentService->delete($id);

        return response()->json([
            "message" => "Комментарий успешно удален",
        ]);
    }
}
