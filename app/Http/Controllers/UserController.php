<?php

namespace App\Http\Controllers;

use App\Services\UserService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "search" => "nullable",
        ]);

        $users = $this->userService->search($validated["search"] ?? null);

        return response()->json([
            "users" => $users,
            "message" => "Результаты поиска пользователей",
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);

        return response()->json([
            "user" => $user,
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only("email", "password");
        $user = $this->userService->login($credentials);

        if ($user instanceof JsonResponse) {
            return $user;
        }

        return response()->json([
            "user" => $user,
            "message" => "Login successful.",
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                "name" => "required",
                "last_name" => "required",
                "email" => "required|email",
                "password" => "required|min:6|confirmed",
            ]);

            $user = $this->userService->store($validated);

            return response()->json([
                "user" => $user,
                "message" => "Вы успешно зарегистрировались",
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
                    "error" => "Произошла ошибка при регистрации.",
                    "message" => $e->getMessage(),
                ],
                500
            );
        }
    }

    public function update(int $id, Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                "name" => "required|string",
                "last_name" => "required|string",
                "email" => "required|email|unique:users,email," . $id,
                "password" => "nullable|min:6",
                "city" => "nullable",
                "date_of_birth" => "nullable",
                "show_date_of_birth" => "nullable",
                "subscribed_until" => "nullable",
                "avatar" =>
                    "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
                "background" =>
                    "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            ]);

            $user = $this->userService->update($validated, $id, $request);

            return response()->json([
                "user" => $user,
                "message" => "Профиль успешно обновлен",
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
}
