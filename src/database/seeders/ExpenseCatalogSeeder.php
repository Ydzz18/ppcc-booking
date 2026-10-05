<?php

namespace Database\Seeders;

use App\Models\ExpenseCatalogItem;
use Illuminate\Database\Seeder;

class ExpenseCatalogSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
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
        ] as $index => $name) {
            $item = ExpenseCatalogItem::query()->where('name', $name)->first()
                ?? ExpenseCatalogItem::query()->where('sort_order', $index + 1)->first();

            if (! $item) {
                $item = ExpenseCatalogItem::query()->create([
                    'name' => $name,
                    'default_amount' => 0,
                    'sort_order' => $index + 1,
                ]);
            }

            if ($item->sort_order !== $index + 1) {
                $item->update(['sort_order' => $index + 1]);
            }
        }
    }
}
