<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')
                ->nullable()
                ->change();
            $table->string('channel')
                ->after('name');
            $table->string('external_id')
                ->nullable()
                ->after('channel');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')
                ->nullable(false)
                ->change();
            $table->dropColumn('channel', 'external_id');
        });
    }
};
