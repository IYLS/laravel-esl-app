<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Fix "duplicate key violates unique constraint ..._pkey (id)=(1)" on PostgreSQL when
     * sequences are behind the actual MAX(id) (imports, restores, manual inserts, etc.).
     */
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'pgsql') {
            return;
        }

        $tables = [
            'units',
            'sections',
            'exercises',
            'questions',
            'alternatives',
            'feedback',
            'keywords',
            'glossed_words',
            'tracking',
            'user_responses',
            'tracking_feedback_usage',
            'tracking_help_usage',
        ];

        foreach ($tables as $table) {
            if (!Schema::hasTable($table)) {
                continue;
            }
            if (!Schema::hasColumn($table, 'id')) {
                continue;
            }

            $max = DB::table($table)->max('id');
            if ($max === null) {
                continue;
            }

            $max = (int) $max;
            $qualified = 'public.'.$table;

            $row = DB::selectOne(
                'SELECT pg_get_serial_sequence(?, ?) AS seq',
                [$qualified, 'id']
            );

            if (!$row || empty($row->seq)) {
                continue;
            }

            // true => next nextval() will return max + 1
            DB::statement('SELECT setval(?, ?, true)', [$row->seq, $max]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Non-destructive data fix; nothing to reverse
    }
};
