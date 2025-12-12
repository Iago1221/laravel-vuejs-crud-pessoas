<?php

namespace App\Application\Pessoa;

use App\Domain\Pessoa\Pessoa;
use App\Domain\Pessoa\PessoaAlreadyExistsException;
use App\Domain\Pessoa\PessoaTipo;

class CreatePessoa extends PessoaApp
{
    public function execute(string $nome, string $tipo, string $documento, string $telefone, string $email): Pessoa
    {
        if ($this->repository->findByDocument($documento)) {
            $message = $tipo == PessoaTipo::FISICA->value ? 'CPF' : 'CNPJ';
            throw new PessoaAlreadyExistsException($message, $documento);
        }

        $pessoa = Pessoa::withNomeTipoDocumentoTelefoneAndEmail(
            $nome,
            $tipo,
            $documento,
            $telefone,
            $email
        );

        return $this->repository->add($pessoa);
    }
}
