<?php

namespace App\Infrastructure\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use Illuminate\Support\Facades\DB;

/**
 * @since 10/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class EloquentUserRepository implements UserRepository
{
    public function findByEmail(string $email): ?User
    {
        $row = DB::table('users')->where('email', $email)->first();
        return $row ? $this->map($row) : null;
    }

    public function findById(int $id): ?User
    {
        $row = DB::table('users')->where('id', $id)->first();
        return $row ? $this->map($row) : null;
    }

    public function findByToken(string $token): ?User
    {
        $row = DB::table('users')->where('api_token', $token)->first();
        return $row ? $this->map($row) : null;
    }

    public function add(User $user): User
    {
        $id = DB::table('users')->insertGetId([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return User::withIdNameEmailPasswordAndToken(
            $id,
            $user->getName(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getApiToken()
        );
    }

    public function update(User $user): User
    {
        DB::table('users')->where('id', $user->getId())->update([
            'name' => $user->getName(),
            'password' => $user->getPassword(),
            'updated_at' => now(),
        ]);

        return $user;
    }

    public function saveApiToken(int $userId, string $apiToken): void
    {
        DB::table('users')->where('id', $userId)->update([
            'api_token' => $apiToken,
        ]);
    }

    /** @inheritDoc */
    public function all(): array
    {
        return array_map(
            fn($row) => $this->map($row),
            DB::table('users')->get()->toArray()
        );
    }

    private function map(object $row): User
    {
        return User::withIdNameEmailPasswordAndToken(
            $row->id,
            $row->name,
            $row->email,
            $row->password,
            $row->api_token ?? null,
        );
    }
}
