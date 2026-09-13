<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_session_trainer', function (Blueprint $table) {
            $table->foreignId('training_session_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('trainer_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->primary([
                'training_session_id',
                'trainer_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_session_trainer');
    }
};
