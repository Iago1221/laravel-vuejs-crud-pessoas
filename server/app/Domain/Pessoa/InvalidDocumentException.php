<?php

namespace App\Domain\Pessoa;

/**
 * @since 11/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class InvalidDocumentException extends \DomainException
{
    public function __construct(string $tipo)
    {
        parent::__construct("{$tipo} inválido", 400);
    }
}
