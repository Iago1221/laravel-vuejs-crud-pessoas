<?php

namespace App\Application\Pessoa;

use App\Domain\Pessoa\PessoaNotFoundException;

class DeletePessoa extends PessoaApp
{
    public function execute(int $id): void
    {
        $pessoa = $this->repository->findById($id);

        if (!isset($pessoa)) {
            throw new PessoaNotFoundException('ID', $id);
        }

        $this->repository->delete($pessoa);
    }
}
