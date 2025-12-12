<?php

namespace App\Application\Pessoa;

use App\Domain\Pessoa\Pessoa;
use App\Domain\Pessoa\PessoaNotFoundException;

class FindPessoa extends PessoaApp
{
    public function execute(int $id): Pessoa
    {
        $pessoa = $this->repository->findById($id);

        if (!isset($pessoa)) {
            throw new PessoaNotFoundException('ID', $id);
        }

        return $pessoa;
    }
}
