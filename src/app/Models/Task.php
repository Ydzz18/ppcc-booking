<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'agency',
        'task_name',
        'required_forms_documents',
    ];

    protected function casts(): array
    {
        return [
            'required_forms_documents' => 'array',
        ];
    }
}
