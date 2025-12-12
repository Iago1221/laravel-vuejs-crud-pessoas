<?php

namespace App\Domain\Pessoa;

/**
 * @since 11/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
enum PessoaTipo: string
{
    case FISICA = 'fisica';
    case JURIDICA = 'juridica';

    public function label(): string
    {
        return self::list()[$this->value];
    }

    public static function list(): array
    {
        return [
            self::FISICA->value => 'Física',
            self::JURIDICA->value => 'Jurídica'
        ];
    }
}
