<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\PostImage;

class PostRepository
{
    public function getAll()
    {
        return Post::with(
            "images",
            "user",
            "comments",
            "comments.responses",
            "comments.responses.user",
            "comments.user"
        )
            ->withCount("likes")
            ->get();
    }

    public function store(array $data)
    {
        $post = Post::create($data);

        return $post;
    }

    public function update(int $id, array $data)
    {
        $post = Post::findOrFail($id);
        $post->update(array_filter($data));
        return $post;
    }

    public function delete(int $id)
    {
        Post::destroy($id);
    }

    public function addImage(int $postId, string $imagePath)
    {
        PostImage::create([
            "post_id" => $postId,
            "image_url" => $imagePath,
        ]);
    }

    public function clearImages(int $postId)
    {
        PostImage::where("post_id", $postId)->delete();
    }
}
