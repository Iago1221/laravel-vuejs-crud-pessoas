<?php

namespace App\Domain\Pessoa;

/**
 * @since 11/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class Pessoa
{
    protected int $id;
    protected string $nome;
    protected PessoaTipo $tipo;
    protected string $documento;
    protected string $telefone;
    protected string $email;

    public static function withNomeTipoDocumentoTelefoneAndEmail(string $nome, string $tipo, string $documento, string $telefone, string $email): self
    {
        $pessoa = new self();
        $pessoa->setNome($nome)
            ->setTipo($tipo)
            ->setDocumento($documento)
            ->setTelefone($telefone)
            ->setEmail($email);

        return $pessoa;
    }

    public static function withIdNomeTipoDocumentoTelefoneAndEmail(int $id, string $nome, string $tipo, string $documento, string $telefone, string $email): self
    {
        $pessoa = new self();
        $pessoa->setId($id)
            ->setNome($nome)
            ->setTipo($tipo)
            ->setDocumento($documento)
            ->setTelefone($telefone)
            ->setEmail($email);

        return $pessoa;
    }

    private function __construct() {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getTipo(): string
    {
        return $this->tipo->value;
    }

    public function getDocumento(): string
    {
        return $this->documento;
    }

    public function getTelefone(): string
    {
        return $this->telefone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    protected function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }

    protected function setTipo(string $tipo): self
    {
        $tipo = PessoaTipo::tryFrom($tipo);

        if (!isset($tipo)) {
            throw new InvalidTipoException();
        }

        $this->tipo = $tipo;
        return $this;
    }

    protected function setDocumento(string $documento): self
    {
        if (!isset($this->tipo)) {
            throw new \RuntimeException("Tipo de pessoa não informado");
        }

        if ($this->tipo == PessoaTipo::JURIDICA) {
            if (!$this->isValidCnpj($documento)) {
                throw new InvalidDocumentException('CNPJ');
            }
        }

        if ($this->tipo == PessoaTipo::FISICA) {
            if (!$this->isValidCpf($documento)) {
                throw new InvalidDocumentException('CPF');
            }
        }

        $this->documento = $documento;
        return $this;
    }

    public function setTelefone(string $telefone): self
    {
        $telefone = preg_replace('/\D/', '', $telefone);

        if (strlen($telefone) != 11) {
            throw new InvalidTelefoneException();
        }

        $this->telefone = $telefone;
        return $this;
    }

    public function setEmail(string $email): self
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException();
        }

        $this->email = $email;
        return $this;
    }

    private function isValidCpf(string $cpf): bool
    {
        if (strlen($cpf) !== 11 || preg_match('/^(.)\1{10}$/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;

            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    private function isValidCnpj(string $cnpj): bool
    {
        if (strlen($cnpj) !== 14 || preg_match('/^(.)\1{13}$/', $cnpj)) {
            return false;
        }

        $weights1 = [5,4,3,2,9,8,7,6,5,4,3,2];
        $weights2 = [6,5,4,3,2,9,8,7,6,5,4,3,2];

        $sum = 0;
        for ($i = 0; $i < 12; $i++) $sum += $cnpj[$i] * $weights1[$i];
        $digit1 = ($sum % 11 < 2) ? 0 : 11 - ($sum % 11);

        $sum = 0;
        for ($i = 0; $i < 13; $i++) $sum += $cnpj[$i] * $weights2[$i];
        $digit2 = ($sum % 11 < 2) ? 0 : 11 - ($sum % 11);

        return ($cnpj[12] == $digit1 && $cnpj[13] == $digit2);
    }
}
