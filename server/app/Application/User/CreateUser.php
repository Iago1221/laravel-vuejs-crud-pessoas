<?php

namespace App\Application\User;

use App\Domain\User\User;
use App\Domain\User\UserAlreadyExistsException;
use Illuminate\Support\Facades\Hash;

/**
 * @since 10/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class CreateUser extends UserApp
{
    public function execute(string $name, string $email, string $password): User
    {
        if ($this->repository->findByEmail($email)) {
            throw new UserAlreadyExistsException($email);
        }

        $password = Hash::make($password);

        $user = User::withNameEmailAndPassword($name, $email, $password);

        return $this->repository->add($user);
    }
}
