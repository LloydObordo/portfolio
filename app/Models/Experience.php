<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Experience extends Model
{
    Use HasFactory, SoftDeletes;

    protected $table = 'experiences';

    protected $fillable = [
        'job_title',
        'company',
        'location',
        'start_date',
        'end_date',
        'is_current',
        'description',
        'achievements',
        'order',
        'company_logo'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'achievements' => 'array',
        'is_current' => 'boolean',
        'order' => 'integer',
        'deleted_at' => 'datetime',
    ];

    public function getDurationAttribute()
    {
        $start = Carbon::parse((string) $this->start_date);
        $end = $this->is_current ? Carbon::now() : Carbon::parse((string) $this->end_date);
        
        return $start->diffForHumans($end, true);
    }

    public function getFormattedDateRangeAttribute()
    {
        $start = Carbon::parse((string) $this->start_date)->format('M Y');
        $end = $this->is_current ? 'Present' : Carbon::parse((string) $this->end_date)->format('M Y');
        
        return "{$start} - {$end}";
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('created_at', 'asc');
    }
}
