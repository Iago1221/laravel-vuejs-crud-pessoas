<?php

namespace App\Domain\Pessoa;

/**
 * @since 11/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class PessoaNotFoundException extends \DomainException
{
    public function __construct(string $with, string $value)
    {
        parent::__construct("Pessoa com {$with}: '{$value}' não encontrada", 404);
    }
}
