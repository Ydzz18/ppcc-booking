<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class TaskMonitoringFormNote extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'task_monitoring_id',
        'form_id',
        'notes_remarks',
        'note_date',
        'note_status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'note_date' => 'date',
        ];
    }

    protected function notesRemarks(): Attribute
    {
        return Attribute::get(function (?string $value): ?string {
            return $value === null
                ? null
                : preg_replace('/^\[[A-Z][a-z]+ \d{2}, \d{4} \d{2}:\d{2} [AP]M\] /m', '', $value);
        });
    }
}
