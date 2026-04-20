<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RenumberUserIdsCommand extends Command
{
    protected $signature = 'users:renumber
                            {--force : Omitir confirmación (obligatorio en producción)}';

    protected $description = 'Reasigna los IDs de users a 1..N consecutivos (mantiene packages, quotes y sessions).';

    public function handle(): int
    {
        if (app()->isProduction() && ! $this->option('force')) {
            $this->error('En producción debes pasar --force si realmente quieres ejecutar esto.');

            return self::FAILURE;
        }

        if (! $this->option('force') && ! $this->confirm('Se reordenarán todos los IDs de usuario y referencias. ¿Continuar?', false)) {
            return self::FAILURE;
        }

        $users = User::query()->orderBy('id')->get();
        if ($users->isEmpty()) {
            $this->info('No hay usuarios.');

            return self::SUCCESS;
        }

        $this->warn('Tras esto las sesiones por ID antiguo dejan de ser válidas: vuelve a iniciar sesión si aplica.');

        Schema::disableForeignKeyConstraints();

        try {
            $maxId = (int) User::query()->max('id');
            $tmpBase = $maxId + 10_000;

            $oldToTmp = [];
            $i = 0;
            foreach ($users as $user) {
                $oldToTmp[$user->id] = $tmpBase + $i;
                $i++;
            }

            foreach ($oldToTmp as $oldId => $tmpId) {
                DB::table('packages')->where('user_id', $oldId)->update(['user_id' => $tmpId]);
                DB::table('quotes')->where('user_id', $oldId)->update(['user_id' => $tmpId]);
                DB::table('sessions')->where('user_id', $oldId)->update(['user_id' => $tmpId]);
                DB::table('users')->where('id', $oldId)->update(['id' => $tmpId]);
            }

            $tmpIds = array_values($oldToTmp);
            sort($tmpIds, SORT_NUMERIC);

            $newId = 1;
            foreach ($tmpIds as $tmpId) {
                DB::table('packages')->where('user_id', $tmpId)->update(['user_id' => $newId]);
                DB::table('quotes')->where('user_id', $tmpId)->update(['user_id' => $newId]);
                DB::table('sessions')->where('user_id', $tmpId)->update(['user_id' => $newId]);
                DB::table('users')->where('id', $tmpId)->update(['id' => $newId]);
                $newId++;
            }

            $next = $users->count() + 1;
            DB::statement('ALTER TABLE users AUTO_INCREMENT = '.(int) $next);
        } finally {
            Schema::enableForeignKeyConstraints();
        }

        $this->info('Listo: '.$users->count().' usuarios con IDs 1..'.$users->count().'. AUTO_INCREMENT = '.$next.'.');

        return self::SUCCESS;
    }
}
