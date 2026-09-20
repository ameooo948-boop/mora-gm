<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('subscriptions', 'duration_days')) {
            return;
        }

        $subscriptions = DB::table('subscriptions')
            ->join(
                'membership_plans',
                'membership_plans.id',
                '=',
                'subscriptions.membership_plan_id'
            )
            ->whereNull('subscriptions.duration_days')
            ->whereNotNull('membership_plans.duration_days')
            ->select([
                'subscriptions.id',
                'membership_plans.duration_days',
            ])
            ->get();

        foreach ($subscriptions as $subscription) {
            DB::table('subscriptions')
                ->where('id', $subscription->id)
                ->update([
                    'duration_days' => $subscription->duration_days,
                ]);
        }
    }

    public function down(): void
    {
        // لا نحذف قيم duration_days الموجودة بالفعل.
    }
};
