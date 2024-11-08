<?php

namespace App\Services;

use App\Repositories\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAll()
    {
        return $this->postRepository->getAll();
    }

    public function create(array $data, Request $request)
    {
        return DB::transaction(function () use ($data, $request) {
            $post = $this->postRepository->store([
                "description" => $data["description"],
                "user_id" => $data["user_id"],
            ]);

            if (!$post) {
                throw new \Exception("Failed to create post.");
            }

            if (!empty($data["images"])) {
                foreach ($data["images"] as $image) {
                    $imagePath = $image->store("post_images", "public");
                    $this->postRepository->addImage($post->id, $imagePath);
                }
            }

            return $post->load("images");
        });
    }

    public function update(int $id, array $data, Request $request)
    {
        return DB::transaction(function () use ($id, $data, $request) {
            $post = $this->postRepository->update($id, [
                "description" => $data["description"] ?? null,
            ]);

            if (!empty($data["images"])) {
                $this->postRepository->clearImages($post->id);
                foreach ($data["images"] as $image) {
                    $imagePath = $image->store("post_images", "public");
                    $this->postRepository->addImage($post->id, $imagePath);
                }
            }

            return $post->load("images");
        });
    }

    public function delete(int $id)
    {
        DB::transaction(function () use ($id) {
            $this->postRepository->clearImages($id);
            $this->postRepository->delete($id);
        });
    }
}
