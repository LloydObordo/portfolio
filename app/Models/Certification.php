<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'certifications';

    protected $fillable = [
        'certification_title',
        'organization',
        'location',
        'date_issued',
        'date_expired',
        'description',
        'organiozation_logo',
    ];

    protected $casts = [
        'date_issued' => 'date',
        'date_expired' => 'date',
        'deleted_at' => 'datetime',
    ];
}
