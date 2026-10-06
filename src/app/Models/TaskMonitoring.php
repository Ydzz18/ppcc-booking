<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class TaskMonitoring extends Model
{
    use HasFactory;

    public function scopePending(Builder $query): Builder
    {
        return $query->where(function (Builder $pendingQuery): void {
            $pendingQuery->whereNull('submission_status')->orWhere('submission_status', '!=', 'completed');
        });
    }

    protected static function booted(): void
    {
        static::saving(function (TaskMonitoring $taskMonitoring): void {
            if (strtolower(trim((string) $taskMonitoring->submission_decision)) === 'accepted') {
                $taskMonitoring->submission_status = 'completed';
            }
        });
    }

    /**
     * @var list<string>
     */
    protected $fillable = [
        'date_task_received',
        'client_id',
        'task_id',
        'task_ids',
        'assigned_responsible_person_id',
        'required_forms_documents',
        'required_forms_quantities',
        'expenses_breakdown',
        'submission_status',
        'date_of_submission',
        'receiving_officer',
        'acknowledgement_receipt_reference_number',
        'submission_decision',
        'submission_notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_task_received' => 'date',
            'task_ids' => 'array',
            'required_forms_documents' => 'array',
<<<<<<< HEAD
=======
            'task_ids' => 'array',
>>>>>>> cc7605a1efaea1247a2e66aae0df46dc30feaed1
            'required_forms_quantities' => 'array',
            'expenses_breakdown' => 'array',
            'date_of_submission' => 'date',
        ];
    }

    protected function submissionNotes(): Attribute
    {
        return Attribute::get(fn (?string $value) => $this->withoutAddedAtTimestamps($value));
    }

    private function withoutAddedAtTimestamps(?string $value): ?string
    {
        return $value === null
            ? null
            : preg_replace('/^\[[A-Z][a-z]+ \d{2}, \d{4} \d{2}:\d{2} [AP]M\] /m', '', $value);
    }

    public function taskAgeInDays(): ?int
    {
        $receivedDate = $this->date_task_received;

        if (!$receivedDate) {
            return null;
        }

        return max(0, (int) $receivedDate->copy()->startOfDay()->diffInDays(today(), false));
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function assignedResponsiblePerson(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'assigned_responsible_person_id');
    }

    public function formNotes(): HasMany
    {
        return $this->hasMany(TaskMonitoringFormNote::class);
    }
}
