<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPosting extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'job_postings';

    protected $fillable = [
        'recruitment_request_id',
        'department_id',
        'company_id',
        'posted_by',
        'title',
        'description',
        'requirements',
        'top_responsibilities',
        'skills_requirements',
        'education_requirements',
        'experience_requirements',
        'other_qualifications',
        'location',
        'employment_type',
        'application_deadline',
        'status',
        'published_at',
        'closed_at',
        'closed_reason',
        'view_count',
        'application_count',
        'image',
        'jd_file',
    ];

    protected $casts = [
        'application_deadline' => 'date',
        'published_at' => 'datetime',
        'closed_at' => 'datetime',
        'top_responsibilities' => 'array',
        'skills_requirements' => 'array',
        'education_requirements' => 'array',
        'view_count' => 'integer',
        'application_count' => 'integer',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function getEffectiveCompanyNameAttribute(): string
    {
        $companies = [
            1 => 'East Africa Television (EATV)',
            2 => 'Independent Television (ITV)',
            3 => 'The Guardian LTD (TGL)',
        ];

        return $companies[$this->company_id] ?? 'East Africa Television Ltd (EATV)';
    }

    public function getEffectiveTopResponsibilitiesAttribute(): array
    {
        if (!empty($this->top_responsibilities)) {
            return is_array($this->top_responsibilities)
                ? $this->top_responsibilities
                : (json_decode($this->top_responsibilities, true) ?: []);
        }

        return [];
    }

    public function getEffectiveSkillsRequirementsAttribute(): array
    {
        if (!empty($this->skills_requirements)) {
            return is_array($this->skills_requirements)
                ? $this->skills_requirements
                : (json_decode($this->skills_requirements, true) ?: []);
        }

        return [];
    }

    public function getEffectiveEducationRequirementsAttribute(): array|string
    {
        if (!empty($this->education_requirements)) {
            return $this->education_requirements;
        }

        return [];
    }

    public function getEffectiveExperienceRequirementsAttribute(): ?string
    {
        return !empty($this->experience_requirements) ? (string) $this->experience_requirements : null;
    }

    public function getEffectiveOtherQualificationsAttribute(): ?string
    {
        return !empty($this->other_qualifications) ? (string) $this->other_qualifications : null;
    }

    public function getEffectiveJdFileAttribute(): ?string
    {
        return !empty($this->jd_file) ? (string) $this->jd_file : null;
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('application_deadline')
                  ->orWhere('application_deadline', '>=', now()->toDateString());
            });
    }
}
