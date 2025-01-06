<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('backups', function (Blueprint $table) {
            // Only add columns if they don't exist
            if (!Schema::hasColumn('backups', 'status')) {
                $table->string('status')->default('completed')->after('size');
            }
            if (!Schema::hasColumn('backups', 'restore_status')) {
                $table->string('restore_status')->nullable()->after('status');
            }
        });
    }

    public function down()
    {
        Schema::table('backups', function (Blueprint $table) {
            $table->dropColumn(['status', 'restore_status']);
        });
    }
};
