<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class VerifyUserEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:verify-email 
                            {email? : Email del usuario a verificar}
                            {--all : Verificar todos los usuarios sin verificar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica el email de un usuario o todos los usuarios sin verificar';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('all')) {
            return $this->verifyAll();
        }

        $email = $this->argument('email');

        if (!$email) {
            $email = $this->ask('¿Cuál es el email del usuario a verificar?');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Usuario con email '{$email}' no encontrado.");
            return 1;
        }

        if ($user->hasVerifiedEmail()) {
            $this->info("El usuario '{$email}' ya está verificado.");
            return 0;
        }

        $user->markEmailAsVerified();
        $user->save();

        $this->info("✅ Email verificado exitosamente para: {$email}");
        return 0;
    }

    /**
     * Verificar todos los usuarios sin verificar
     */
    private function verifyAll()
    {
        $users = User::whereNull('email_verified_at')->get();

        if ($users->isEmpty()) {
            $this->info('No hay usuarios sin verificar.');
            return 0;
        }

        $this->info("Encontrados {$users->count()} usuario(s) sin verificar.");

        if (!$this->confirm('¿Deseas verificar todos estos usuarios?', true)) {
            $this->info('Operación cancelada.');
            return 0;
        }

        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        foreach ($users as $user) {
            $user->markEmailAsVerified();
            $user->save();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ {$users->count()} usuario(s) verificados exitosamente.");

        return 0;
    }
}

