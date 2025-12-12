<?php

namespace App\Http\Controllers;

use App\Application\User\CreateUser;
use App\Application\User\LoginUser;
use App\Application\User\UpdateUser;
use App\Domain\User\InvalidCredentialsException;
use App\Domain\User\UserResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @since 10/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class UserController extends ApiController
{
    public function login(Request $request, LoginUser $useCase): JsonResponse
    {
        try {
            $data = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $token = $useCase->execute(
                $data['email'],
                $data['password']
            );

            return response()->json(['token' => $token]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (InvalidCredentialsException|\DomainException $e) {
            return self::errorResponse($e);
        }
    }

    public function create(Request $request, CreateUser $useCase): JsonResponse
    {
        try {
            $data = $request->validate([
               'name' => 'required',
               'email' => 'required|email',
               'password' => 'required|min:4',
            ]);

            $user = $useCase->execute($data['name'], $data['email'], $data['password']);

            return response()->json(['user' => UserResponse::from($user)], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\DomainException $e) {
            return self::errorResponse($e);
        }
    }

    public function update($id, Request $request, UpdateUser $useCase): JsonResponse
    {
        try {
            $data = $request->validate([
                'name' => 'nullable|string',
                'password' => 'nullable|min:4'
            ]);

            $user = $useCase->execute($id, $data['name'] ?? null, $data['password'] ?? null);

            return response()->json(['user' => UserResponse::from($user)]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\DomainException $e) {
            return self::errorResponse($e);
        }
    }
}
