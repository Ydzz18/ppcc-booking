<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'actor_id',
        'actor_name',
        'event',
        'subject_type',
        'subject_id',
        'changed_fields',
        'route_name',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'changed_fields' => 'array',
            'created_at' => 'immutable_datetime',
        ];
    }

    public static function record(
        string $event,
        ?Model $subject = null,
        array $changedFields = [],
        ?Authenticatable $actor = null,
    ): self {
        $actor ??= Auth::user();
        $request = app()->bound('request') ? app('request') : null;
        $changedFields = array_values(array_unique(array_filter(
            $changedFields,
            static fn (mixed $field): bool => is_string($field)
                && ! in_array($field, ['created_at', 'updated_at', 'remember_token'], true),
        )));

        return static::query()->create([
            'actor_id' => $actor?->getAuthIdentifier(),
            'actor_name' => $actor instanceof Model ? $actor->getAttribute('name') : null,
            'event' => $event,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject === null ? null : (string) $subject->getKey(),
            'changed_fields' => $changedFields === [] ? null : $changedFields,
            'route_name' => $request?->route()?->getName(),
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ]);
    }
}
