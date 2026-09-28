<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditModelObserver
{
    public function created(Model $model): void
    {
        AuditLog::record('created', $model, array_keys($model->getAttributes()));
    }

    public function updated(Model $model): void
    {
        $changedFields = array_keys($model->getChanges());

        if ($changedFields !== []) {
            AuditLog::record('updated', $model, $changedFields);
        }
    }

    public function deleted(Model $model): void
    {
        AuditLog::record('deleted', $model, array_keys($model->getAttributes()));
    }
}
