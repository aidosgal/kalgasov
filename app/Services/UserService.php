<?php

namespace App\Services;

use App\Repositories\UserRepository;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(array $credentials)
    {
        if (Auth::attempt($credentials)) {
            return Auth::user();
        }

        return response()->json(
            [
                "error" =>
                    "Не удалось пройти аутентификацию. Пожалуйста, проверьте свои учетные данные и попробуйте снова.",
            ],
            401
        );
    }

    public function store(array $data)
    {
        $data["password"] = Hash::make($data["password"]);
        $user = $this->userRepository->store($data);

        return $user;
    }

    public function getUserById(int $id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function update(array $data, int $id, Request $request)
    {
        if ($request->hasFile("avatar")) {
            $avatarPath = $request->file("avatar")->store("avatars", "public");
            $data["avatar"] = $avatarPath;
        }

        if ($request->hasFile("background")) {
            $backgroundPath = $request
                ->file("background")
                ->store("backgrounds", "public");
            $data["background"] = $backgroundPath;
        }

        if (!empty($data["password"])) {
            $data["password"] = Hash::make($data["password"]);
        } else {
            unset($data["password"]);
        }

        $user = $this->userRepository->updateById($data, $id);

        return $user;
    }

    public function search(?string $search)
    {
        return $this->userRepository->searchByName($search);
    }
}
