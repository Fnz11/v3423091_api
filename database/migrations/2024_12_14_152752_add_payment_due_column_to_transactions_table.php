<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->timestamp('payment_due')->nullable()->after('shipping_address');
        });

        // Set payment_due for existing transactions
        DB::table('transactions')
            ->whereNull('payment_due')
            ->update([
                'payment_due' => DB::raw('DATE_ADD(created_at, INTERVAL 24 HOUR)')
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('payment_due');
        });
    }
};
