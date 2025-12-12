<?php

namespace App\Domain\Pessoa;

/**
 * @since 11/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class InvalidTelefoneException extends \DomainException
{
    public function __construct()
    {
        parent::__construct("Telefone inválido", 400);
    }
}
