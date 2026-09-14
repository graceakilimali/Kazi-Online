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
