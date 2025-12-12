<?php

namespace App\Domain\User;

/**
 * @since 10/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class User
{
    protected int $id;
    protected string $name;
    protected string $email;
    protected string $password;
    protected ?string $apiToken;

    public static function withIdNameEmailPasswordAndToken(int $id, string $name, string $email, string $password, ?string $apiToken): self
    {
        $user = new self();
        $user->setId($id)
            ->setName($name)
            ->setEmail($email)
            ->setPassword($password)
            ->setApiToken($apiToken);

        return $user;
    }

    public static function withNameEmailAndPassword(string $name, string $email, string $password): self
    {
        $user = new self();
        $user->setName($name)
            ->setEmail($email)
            ->setPassword($password);

        return $user;
    }

    private function __construct() {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getApiToken(): ?string
    {
        return isset($this->apiToken) ? $this->apiToken : null;
    }

    protected function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    protected function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    protected function setApiToken(?string $apiToken): self
    {
        $this->apiToken = $apiToken;
        return $this;
    }
}
