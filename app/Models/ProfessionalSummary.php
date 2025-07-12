<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfessionalSummary extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'professional_summaries';

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'qualifier',
        'shortname',
        'biography',
        'summary',
        'resume',
        'cv',
        'profile_image',
        'cover_image',
        'address',
        'phone',
        'email',
        'website',
        'linkedin',
        'github',
    ];
}
