<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('epresences', function (Blueprint $table) {
            $table->foreign(['id_users'])->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('epresences', function (Blueprint $table) {
            $table->dropForeign('epresences_id_users_foreign');
        });
    }
};
