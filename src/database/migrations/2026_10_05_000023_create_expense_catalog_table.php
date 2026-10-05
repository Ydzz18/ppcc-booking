<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expense_catalog', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->decimal('default_amount', 10, 2)->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $now = now();
        $names = [
            'Notarial Fee-SPA',
            'Notarial Fee-Sworn',
            'Loose DST',
            'Doc Stamp Tax',
            'SI Printing',
            'DR Printing',
            'Permits',
            'Cedula',
            'Certification Fee',
            'Penalties',
            'Registration Fee',
            'Processing Fee',
            'Others:1___________',
            'Others:2___________',
            'Others:3___________',
        ];

        DB::table('expense_catalog')->insert(collect($names)->values()->map(
            fn (string $name, int $index): array => [
                'name' => $name,
                'default_amount' => 0,
                'sort_order' => $index + 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        )->all());

        $catalogIdsByName = DB::table('expense_catalog')->pluck('id', 'name');

        foreach (DB::table('task_monitorings')->get(['id', 'expenses_breakdown']) as $monitoring) {
            $legacyExpenses = json_decode((string) $monitoring->expenses_breakdown, true);

            if (! is_array($legacyExpenses)) {
                continue;
            }

            $snapshots = collect($legacyExpenses)
                ->filter(fn ($expense): bool => is_array($expense)
                    && isset($expense['form_name'], $expense['expense_amount'])
                    && $catalogIdsByName->has($expense['form_name']))
                ->map(fn (array $expense): array => [
                    'catalog_id' => (int) $catalogIdsByName[$expense['form_name']],
                    'catalog_name' => (string) $expense['form_name'],
                    'expense_amount' => (float) $expense['expense_amount'],
                ])
                ->values()
                ->all();

            DB::table('task_monitorings')
                ->where('id', $monitoring->id)
                ->update(['expenses_breakdown' => json_encode($snapshots)]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('expense_catalog');
    }
};
