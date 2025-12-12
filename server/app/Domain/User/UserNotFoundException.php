<?php

namespace App\Domain\User;

/**
 * @since 10/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class UserNotFoundException extends \DomainException
{
    public function __construct(string $with, string $value)
    {
        parent::__construct("User com {$with}: '{$value}' não encontrado", 404);
    }
}
