<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create 
                            {--email= : Email del administrador}
                            {--password= : Contraseña (mín. 8 caracteres)}
                            {--name= : Nombre del administrador}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un usuario administrador';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->option('email') ?? $this->ask('Email del administrador');
        $password = $this->option('password') ?? $this->secret('Contraseña (mín. 8 caracteres)');
        $name = $this->option('name') ?? $this->ask('Nombre', 'Administrador');

        $validator = Validator::make(
            [
                'email' => $email,
                'password' => $password,
                'name' => $name,
            ],
            [
                'email' => ['required', 'email'],
                'password' => ['required', 'string', 'min:8'],
                'name' => ['required', 'string', 'max:255'],
            ],
            [
                'email.required' => 'El email es obligatorio.',
                'email.email' => 'El email no es válido.',
                'password.required' => 'La contraseña es obligatoria.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return self::FAILURE;
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->info("✓ Usuario administrador creado/actualizado correctamente.");
        $this->table(
            ['ID', 'Nombre', 'Email', 'Rol'],
            [[$user->id, $user->name, $user->email, $user->role]]
        );

        return self::SUCCESS;
    }
}
