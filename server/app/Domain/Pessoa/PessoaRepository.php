<?php

namespace App\Domain\Pessoa;

/**
 * @since 11/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
interface PessoaRepository
{
    public function add(Pessoa $pessoa): Pessoa;
    public function update(Pessoa $pessoa): Pessoa;
    public function findById(int $id): ?Pessoa;
    public function findByDocument(string $documento): ?Pessoa;
    public function delete(Pessoa $pessoa): void;

    /** @return Pessoa[] */
    public function all(): array;
}
