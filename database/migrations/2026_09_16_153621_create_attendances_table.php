<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('training_session_id')
                ->constrained()
                ->restrictOnDelete();

            $table->date('attendance_date');

            $table->dateTime('checked_in_at');

            $table->dateTime('checked_out_at')->nullable();

            $table->timestamps();

            $table->unique([
                'user_id',
                'training_session_id',
                'attendance_date',
            ]);

            $table->index([
                'attendance_date',
                'training_session_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
