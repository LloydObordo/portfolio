<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Education extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'educations';

    protected $fillable = [
        'institution',
        'degree',
        'field_of_study',
        'start_date',
        'end_date',
        'is_current',
        'description',
        'order',
        'active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'active' => 'boolean',
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

    public function getAbbreviationAttribute(): string
    {
        $abbreviations = [
            'bachelor' => 'BS',
            'master' => 'MS',
            'doctorate' => 'PhD',
            'associate' => 'AA',
        ];
        
        return $abbreviations[strtolower($this->degree)] ?? $this->degree;
    }

    public function getDegreeDescriptionAttribute(): string
    {
        $descriptions = [
            'bachelor' => 'Bachelor\'s Degree',
            'master' => 'Master\'s Degree',
            'doctorate' => 'Doctorate Degree',
            'associate' => 'Associate Degree',
        ];
        
        return $descriptions[strtolower($this->degree)] ?? $this->degree;
    }

    public static function getEnumValues($column)
    {
        $type = \DB::select("SHOW COLUMNS FROM " . (new self)->getTable() . " WHERE Field = '{$column}'")[0]->Type;
    
        preg_match('/^enum\((.*)\)$/', $type, $matches);
    
        $enum = [];
        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "'");
            $enum[] = [
                'id' => $v,
                'description' => ucwords(strtolower(str_replace('_', ' ', $v)))
            ];
        }
    
        return $enum;
    }
}
