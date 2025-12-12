<?php

namespace App\Domain\Pessoa;

/**
 * @since 11/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class PessoaAlreadyExistsException extends \DomainException
{
    public function __construct(string $typeDocument, string $document)
    {
        parent::__construct("Pessoa com {$typeDocument} '{$document}' já existe", 409);
    }
}
