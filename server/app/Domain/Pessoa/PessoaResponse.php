<?php

namespace App\Domain\Pessoa;

/**
 * @since 11/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class PessoaResponse
{
    public static function from(Pessoa $pessoa): array
    {
        return [
            'id' => $pessoa->getId(),
            'nome' => $pessoa->getNome(),
            'tipo' => $pessoa->getTipo(),
            'documento' => $pessoa->getDocumento(),
            'telefone' => $pessoa->getTelefone(),
            'email' => $pessoa->getEmail()
        ];
    }
}
