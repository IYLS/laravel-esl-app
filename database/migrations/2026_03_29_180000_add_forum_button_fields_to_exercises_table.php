<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $addedShowForumLink = false;

        if (! Schema::hasColumn('exercises', 'show_forum_link')) {
            Schema::table('exercises', function (Blueprint $table) {
                $table->boolean('show_forum_link')->default(false);
            });
            $addedShowForumLink = true;
        }

        if (! Schema::hasColumn('exercises', 'forum_button_label')) {
            Schema::table('exercises', function (Blueprint $table) {
                $table->string('forum_button_label', 255)->nullable();
            });
        }

        if ($addedShowForumLink) {
            DB::table('exercises')
                ->whereIn('subtype', [99, 991])
                ->update(['show_forum_link' => true]);
        }
    }

    public function down(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            if (Schema::hasColumn('exercises', 'forum_button_label')) {
                $table->dropColumn('forum_button_label');
            }
            if (Schema::hasColumn('exercises', 'show_forum_link')) {
                $table->dropColumn('show_forum_link');
            }
        });
    }
};
