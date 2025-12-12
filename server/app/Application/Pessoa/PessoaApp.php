<?php

namespace App\Application\Pessoa;

use App\Domain\Pessoa\PessoaRepository;

/**
 * @since 11/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
abstract class PessoaApp
{
    protected PessoaRepository $repository;

    public function __construct(PessoaRepository $repository)
    {
        $this->repository = $repository;
    }
}
