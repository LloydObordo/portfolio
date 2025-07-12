<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'skills';

    protected $fillable = [
        'name',
        'category',
        'proficiency',
        'icon',
        'order',
    ];

    protected $cast = [
        'proficiency' => 'integer',
        'order' => 'integer',
        'deleted_at' => 'datetime',
    ];
}
