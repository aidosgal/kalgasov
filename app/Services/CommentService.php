<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentService
{
    public function create(array $data, Request $request)
    {
        return DB::transaction(function () use ($data, $request) {
            $comment = Comment::create([
                "user_id" => $data["user_id"],
                "post_id" => $data["post_id"],
                "comment_id" => $data["comment_id"] ?? null,
                "comment" => $data["comment"],
            ]);

            return $comment;
        });
    }

    public function update(int $id, array $data, Request $request)
    {
        $comment = Comment::findOrFail($id);

        $comment->update([
            "comment" => $data["comment"],
        ]);

        return $comment;
    }

    public function delete(int $id)
    {
        $comment = Comment::findOrFail($id);

        $comment->delete();
    }
}
