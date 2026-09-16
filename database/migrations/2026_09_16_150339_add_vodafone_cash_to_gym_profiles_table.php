<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gym_profiles', function (Blueprint $table) {
            $table->string('vodafone_cash')->nullable()->after('whatsapp');
        });
    }

    public function down(): void
    {
        Schema::table('gym_profiles', function (Blueprint $table) {
            $table->dropColumn('vodafone_cash');
        });
    }
};
