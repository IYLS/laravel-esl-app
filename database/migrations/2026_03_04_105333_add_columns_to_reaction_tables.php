<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('comment_reactions')) {
            Schema::create('comment_reactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('comment_id')->constrained('comments')->cascadeOnDelete();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('emoji', 10);
                $table->unique(['comment_id', 'user_id', 'emoji']);
                $table->timestamps();
            });
        } elseif (!Schema::hasColumn('comment_reactions', 'comment_id')) {
            Schema::table('comment_reactions', function (Blueprint $table) {
                $table->foreignId('comment_id')->constrained('comments')->cascadeOnDelete();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('emoji', 10);
                $table->unique(['comment_id', 'user_id', 'emoji']);
            });
        }

        if (!Schema::hasTable('reply_reactions')) {
            Schema::create('reply_reactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('reply_id')->constrained('replies')->cascadeOnDelete();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('emoji', 10);
                $table->unique(['reply_id', 'user_id', 'emoji']);
                $table->timestamps();
            });
        } elseif (!Schema::hasColumn('reply_reactions', 'reply_id')) {
            Schema::table('reply_reactions', function (Blueprint $table) {
                $table->foreignId('reply_id')->constrained('replies')->cascadeOnDelete();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('emoji', 10);
                $table->unique(['reply_id', 'user_id', 'emoji']);
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('comment_reactions', 'comment_id')) {
            Schema::table('comment_reactions', function (Blueprint $table) {
                $table->dropUnique(['comment_id', 'user_id', 'emoji']);
                $table->dropForeign(['comment_id']);
                $table->dropForeign(['user_id']);
                $table->dropColumn('comment_id');
                $table->dropColumn('user_id');
                $table->dropColumn('emoji');
            });
        }
        if (Schema::hasColumn('reply_reactions', 'reply_id')) {
            Schema::table('reply_reactions', function (Blueprint $table) {
                $table->dropUnique(['reply_id', 'user_id', 'emoji']);
                $table->dropForeign(['reply_id']);
                $table->dropForeign(['user_id']);
                $table->dropColumn('reply_id');
                $table->dropColumn('user_id');
                $table->dropColumn('emoji');
            });
        }
    }
};
