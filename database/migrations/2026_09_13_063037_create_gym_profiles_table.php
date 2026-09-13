<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gym_profiles', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('eyebrow')->nullable();

            $table->string('about_title');
            $table->text('about_description');

            $table->string('mission_title')->nullable();
            $table->text('mission')->nullable();

            $table->string('vision_title')->nullable();
            $table->text('vision')->nullable();

            $table->string('image')->nullable();

            $table->unsignedInteger('space_size')->nullable();
            $table->unsignedInteger('trainer_count')->default(1);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gym_profiles');
    }
};
