<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gym_profiles', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('name');
            $table->string('whatsapp')->nullable()->after('phone');
            $table->string('email')->nullable()->after('whatsapp');
            $table->string('address')->nullable()->after('email');
            $table->string('instagram_url')->nullable()->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('gym_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'whatsapp',
                'email',
                'address',
                'instagram_url',
            ]);
        });
    }
};
