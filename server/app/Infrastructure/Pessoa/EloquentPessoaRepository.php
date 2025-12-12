<?php

namespace App\Infrastructure\Pessoa;

use App\Domain\Pessoa\Pessoa;
use App\Domain\Pessoa\PessoaRepository;
use Illuminate\Support\Facades\DB;

/**
 * @since 11/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class EloquentPessoaRepository implements PessoaRepository
{
    public function findById(int $id): ?Pessoa
    {
        $row = DB::table('pessoas')->where('id', $id)->first();
        return $row ? $this->map($row) : null;
    }

    public function findByDocument(string $documento): ?Pessoa
    {
        $row = DB::table('pessoas')->where('documento', $documento)->first();
        return $row ? $this->map($row) : null;
    }

    public function delete(Pessoa $pessoa): void
    {
        DB::table('pessoas')->where('id', $pessoa->getId())->delete();
    }

    public function add(Pessoa $pessoa): Pessoa
    {
        $id = DB::table('pessoas')->insertGetId([
            'nome' => $pessoa->getNome(),
            'tipo' => $pessoa->getTipo(),
            'documento' => $pessoa->getDocumento(),
            'telefone' => $pessoa->getTelefone(),
            'email' => $pessoa->getEmail(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return Pessoa::withIdNomeTipoDocumentoTelefoneAndEmail(
            $id,
            $pessoa->getNome(),
            $pessoa->getTipo(),
            $pessoa->getDocumento(),
            $pessoa->getTelefone(),
            $pessoa->getEmail()
        );
    }

    public function update(Pessoa $pessoa): Pessoa
    {
        DB::table('pessoas')->where('id', $pessoa->getId())->update([
            'nome' => $pessoa->getNome(),
            'telefone' => $pessoa->getTelefone(),
            'email' => $pessoa->getEmail(),
            'updated_at' => now(),
        ]);

        return $pessoa;
    }

    /** @inheritDoc */
    public function all(): array
    {
        return array_map(
            fn($row) => $this->map($row),
            DB::table('pessoas')->orderByDesc('id')->get()->toArray()
        );
    }

    private function map(object $row): Pessoa
    {
        return Pessoa::withIdNomeTipoDocumentoTelefoneAndEmail(
            $row->id,
            $row->nome,
            $row->tipo,
            $row->documento,
            $row->telefone,
            $row->email
        );
    }
}
