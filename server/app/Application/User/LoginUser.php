<?php

namespace App\Application\User;

use App\Domain\User\InvalidCredentialsException;
use App\Domain\User\UserNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @since 10/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class LoginUser extends UserApp
{
    public function execute(string $email, string $password): string
    {
        $user = $this->repository->findByEmail($email);

        if (!$user || !Hash::check($password, $user->getPassword())) {
            throw new InvalidCredentialsException();
        }

        $token = Str::random(60);

        $this->repository->saveApiToken($user->getId(), $token);

        return $token;
    }
}
