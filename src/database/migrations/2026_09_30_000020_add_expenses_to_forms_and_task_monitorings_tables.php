<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->decimal('expense_amount', 10, 2)->default(0)->after('form_name');
        });

        Schema::table('task_monitorings', function (Blueprint $table) {
            $table->json('expenses_breakdown')->nullable()->after('required_forms_documents');
        });
    }

    public function down(): void
    {
        Schema::table('task_monitorings', function (Blueprint $table) {
            $table->dropColumn('expenses_breakdown');
        });

        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn('expense_amount');
        });
    }
};