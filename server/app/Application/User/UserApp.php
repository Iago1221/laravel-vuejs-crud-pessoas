<?php

namespace App\Application\User;

use App\Domain\User\UserRepository;

/**
 * @since 10/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
abstract class UserApp
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
}
