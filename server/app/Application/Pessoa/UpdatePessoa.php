<?php

namespace App\Application\Pessoa;

use App\Domain\Pessoa\Pessoa;
use App\Domain\Pessoa\PessoaNotFoundException;

class UpdatePessoa extends PessoaApp
{
    public function execute(int $id, ?string $nome, ?string $telefone, ?string $email): Pessoa
    {
        $pessoa = $this->repository->findById($id);

        if (!isset($pessoa)) {
            throw new PessoaNotFoundException('ID', $id);
        }

        if (isset($nome)) {
            $pessoa->setNome($nome);
        }

        if (isset($telefone)) {
            $pessoa->setTelefone($telefone);
        }

        if (isset($email)) {
            $pessoa->setEmail($email);
        }

        return $this->repository->update($pessoa);
    }
}
