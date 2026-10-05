<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('task_monitorings', 'task_ids')) {
            Schema::table('task_monitorings', function (Blueprint $table) {
                $table->json('task_ids')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('task_monitorings', 'task_ids')) {
            Schema::table('task_monitorings', function (Blueprint $table) {
                $table->dropColumn('task_ids');
            });
        }
    }
};