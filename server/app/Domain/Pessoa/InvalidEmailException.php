<?php

namespace App\Domain\Pessoa;

/**
 * @since 11/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class InvalidEmailException extends \DomainException
{
    public function __construct()
    {
        parent::__construct("E-mail inválido", 400);
    }
}
