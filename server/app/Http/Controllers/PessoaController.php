<?php

namespace App\Http\Controllers;

use App\Application\Pessoa\CreatePessoa;
use App\Application\Pessoa\DeletePessoa;
use App\Application\Pessoa\FindPessoa;
use App\Application\Pessoa\UpdatePessoa;
use App\Domain\Pessoa\PessoaRepository;
use App\Domain\Pessoa\PessoaResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @since 11/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class PessoaController extends ApiController
{
    public function create(Request $request, CreatePessoa $useCase): JsonResponse
    {
        try {
            $data = $request->validate([
                'nome' => 'required|string',
                'tipo' => 'required|string',
                'documento' => 'required|string',
                'telefone' => 'required|string',
                'email' => 'required|email'
            ]);

            $pessoa = $useCase->execute($data['nome'], $data['tipo'], $data['documento'], $data['telefone'], $data['email']);

            return response()->json(['pessoa' => PessoaResponse::from($pessoa)], 201);
        } catch (ValidationException $e) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
        } catch (\DomainException $e) {
            return self::errorResponse($e);
        }
    }

    public function update(int $id, Request $request, UpdatePessoa $useCase): JsonResponse
    {
        try {
            $data = $request->validate([
                'nome' => 'nullable|string',
                'telefone' => 'nullable|string',
                'email' => 'nullable|email'
            ]);
            $pessoa = $useCase->execute($id, $data['nome'] ?? null, $data['telefone'] ?? null, $data['email'] ?? null);

            return response()->json(['pessoa' => PessoaResponse::from($pessoa)]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\DomainException $e) {
            return self::errorResponse($e);
        }
    }

    public function find(int $id, FindPessoa $useCase): JsonResponse
    {
        try {
            $pessoa = $useCase->execute($id);
            return response()->json(['pessoa' => PessoaResponse::from($pessoa)]);
        } catch (\DomainException $e) {
            return self::errorResponse($e);
        }
    }

    public function list(PessoaRepository $repository): JsonResponse
    {
        $pessoas = $repository->all();

        return response()->json(['pessoas' =>
            array_map(
                fn($p) => PessoaResponse::from($p),
                $pessoas
            )
        ]);
    }

    public function delete(int $id, DeletePessoa $useCase): JsonResponse
    {
        try {
            $useCase->execute($id);
            return response()->json(['message' => 'Pessoa excuída com sucesso']);
        } catch (\DomainException $e) {
            return self::errorResponse($e);
        }
    }
}
