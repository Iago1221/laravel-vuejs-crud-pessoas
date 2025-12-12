<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Application\User\CreateUser;

/**
 * @since 11/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class CreateFirstUser extends Command
{
    protected $signature = 'user:create
                            {name? : Nome do usuário}
                            {email? : Email do usuário}
                            {password? : Senha do usuário}';

    protected $description = 'Cria o primeiro usuário do sistema';

    public function handle(CreateUser $useCase)
    {
        $name = $this->argument('name') ?? $this->ask('Nome');
        $email = $this->argument('email') ?? $this->ask('E-mail');
        $password = $this->argument('password') ?? $this->secret('Senha');

        $user = $useCase->execute($name, $email, $password);

        $this->info("Usuário criado com sucesso!");
        $this->info("ID: {$user->getId()}");
        $this->info("E-mail: {$email}");

        return Command::SUCCESS;
    }
}
