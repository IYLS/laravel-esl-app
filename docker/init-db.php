<?php

/**
 * Inicializa la base de datos al arrancar el contenedor:
 *  1. Espera a que la base de datos acepte conexiones.
 *  2. Ejecuta las migraciones pendientes.
 *  3. Ejecuta los seeders solo si la base está vacía (los seeders usan IDs fijos,
 *     por lo que no son idempotentes).
 */

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$log = static fn (string $message) => fwrite(STDOUT, "[init-db] {$message}\n");

// 1. Esperar a la base de datos
$maxAttempts = 30;
for ($attempt = 1; ; $attempt++) {
    try {
        DB::connection()->getPdo();
        break;
    } catch (Throwable $e) {
        if ($attempt >= $maxAttempts) {
            $log('No se pudo conectar a la base de datos: ' . $e->getMessage());
            exit(1);
        }
        $log("Esperando a la base de datos ({$attempt}/{$maxAttempts})...");
        sleep(2);
    }
}

// 2. Migraciones
$log('Ejecutando migraciones...');
Artisan::call('migrate', ['--force' => true], new Symfony\Component\Console\Output\StreamOutput(STDOUT));

// 3. Seeders (solo si la base está vacía)
if (DB::table('users')->count() === 0) {
    $log('Base de datos vacía, ejecutando seeders...');
    Artisan::call('db:seed', ['--force' => true], new Symfony\Component\Console\Output\StreamOutput(STDOUT));

    // Los seeders insertan IDs explícitos: reajustar las secuencias de PostgreSQL
    // para que los próximos inserts de la aplicación no colisionen.
    if (DB::connection()->getDriverName() === 'pgsql') {
        $log('Reajustando secuencias de PostgreSQL...');
        DB::unprepared(<<<'SQL'
            DO $$
            DECLARE
                r record;
            BEGIN
                FOR r IN
                    SELECT c.table_name,
                           pg_get_serial_sequence(format('%I.%I', c.table_schema, c.table_name), c.column_name) AS seq
                    FROM information_schema.columns c
                    JOIN information_schema.tables t
                      ON t.table_schema = c.table_schema AND t.table_name = c.table_name
                    WHERE c.table_schema = current_schema()
                      AND c.column_name = 'id'
                      AND t.table_type = 'BASE TABLE'
                LOOP
                    IF r.seq IS NOT NULL THEN
                        EXECUTE format(
                            'SELECT setval(%L, COALESCE((SELECT MAX(id) FROM %I), 0) + 1, false)',
                            r.seq, r.table_name
                        );
                    END IF;
                END LOOP;
            END $$;
            SQL);
    }

    $log('Seeders completados.');
} else {
    $log('La base de datos ya tiene datos, se omiten los seeders.');
}
