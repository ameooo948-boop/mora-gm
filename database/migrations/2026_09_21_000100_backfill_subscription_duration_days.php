<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('subscriptions', 'duration_days')) {
            return;
        }

        DB::statement(<<<'SQL'
            UPDATE subscriptions AS subscriptions
            INNER JOIN membership_plans AS membership_plans
                ON membership_plans.id = subscriptions.membership_plan_id
            SET subscriptions.duration_days = membership_plans.duration_days
            WHERE subscriptions.duration_days IS NULL
              AND membership_plans.duration_days IS NOT NULL
        SQL);
    }

    public function down(): void
    {
        if (! Schema::hasColumn('subscriptions', 'duration_days')) {
            return;
        }

        DB::statement(
            'UPDATE subscriptions SET duration_days = NULL'
        );
    }
};
