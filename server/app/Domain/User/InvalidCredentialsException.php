<?php

namespace App\Domain\User;

/**
 * @since 10/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class InvalidCredentialsException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct("Invalid credentials", 401);
    }
}
