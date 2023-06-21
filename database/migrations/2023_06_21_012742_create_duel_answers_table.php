<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('duel_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('duel_id')
                ->constrained();
            $table->foreignId('answer_id')
                ->constrained();
            $table->integer('answer_number');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('duel_answers');
    }
};
