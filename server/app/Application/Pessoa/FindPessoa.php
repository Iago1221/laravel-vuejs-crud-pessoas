<?php

namespace App\Application\Pessoa;

use App\Domain\Pessoa\Pessoa;
use App\Domain\Pessoa\PessoaNotFoundException;

/**
 * @since 11/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
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
