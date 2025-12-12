<?php

namespace App\Domain\User;

/**
 * @since 10/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
interface UserRepository
{
    public function findByEmail(string $email): ?User;
    public function findById(int $id): ?User;
    public function findByToken(string $token): ?User;
    public function add(User $user): User;
    public function update(User $user): User;
    public function saveApiToken(int $userId, string $apiToken): void;

    /** @return User[] */
    public function all(): array;
}
