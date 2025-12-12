<?php

namespace App\Domain\User;

/**
 * @since 10/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class UserAlreadyExistsException extends \DomainException
{
    public function __construct(string $email)
    {
        parent::__construct("User com e-mail '{$email}' já existe", 409);
    }
}
