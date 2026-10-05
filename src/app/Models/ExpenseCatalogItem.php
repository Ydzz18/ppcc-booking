<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCatalogItem extends Model
{
    use HasFactory;

    protected $table = 'expense_catalog';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'default_amount',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'default_amount' => 'decimal:2',
            'sort_order' => 'integer',
        ];
    }
}
