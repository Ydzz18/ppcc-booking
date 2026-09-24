<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'client_name',
        'business_name',
        'contact_person',
        'address',
        'residential_address',
        'tin',
        'tel_phone_number',
        'email_address',
        'id_presented',
        'fathers_name',
        'mothers_maiden_name',
        'date_of_birth',
        'place_of_birth',
        'civil_status',
        'religion',
        'capitalization',
        'notes',
        'business_registrations',
        'additional_requirements',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'business_registrations' => 'array',
            'additional_requirements' => 'array',
        ];
    }
}
