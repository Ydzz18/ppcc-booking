<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('task_monitorings', function (Blueprint $table) {
            $table->json('required_forms_quantities')->nullable()->after('required_forms_documents');
        });
    }

    public function down(): void
    {
        Schema::table('task_monitorings', function (Blueprint $table) {
            $table->dropColumn('required_forms_quantities');
        });
    }
};