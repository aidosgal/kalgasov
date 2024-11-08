<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function store(array $data)
    {
        return User::create($data);
    }

    public function getUserById($id)
    {
        return User::find($id);
    }

    public function updateById(array $data, $id)
    {
        $user = User::find($id);
        $user->update($data);
        return $user;
    }

    public function searchByName(?string $search)
    {
        return User::when($search, function ($query, $search) {
            return $query->where("name", "like", "%" . $search . "%");
        })->get();
    }
}
