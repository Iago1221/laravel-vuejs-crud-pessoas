<?php

namespace App\Application\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use Illuminate\Support\Facades\Hash;

/**
 * @since 10/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class UpdateUser extends UserApp
{
    public function execute(int $id, ?string $name, ?string $password): User
    {
        $user = $this->repository->findById($id);

        if (!isset($user)) {
            throw new UserNotFoundException('ID', $id);
        }

        if (isset($name)) {
            $user->setName($name);
        }

        if (isset($password)) {
            $user->setPassword(Hash::make($password));
        }

        return $this->repository->update($user);
    }
}
