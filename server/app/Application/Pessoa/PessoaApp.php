<?php

namespace App\Application\Pessoa;

use App\Domain\Pessoa\PessoaRepository;

abstract class PessoaApp
{
    protected PessoaRepository $repository;

    public function __construct(PessoaRepository $repository)
    {
        $this->repository = $repository;
    }
}
