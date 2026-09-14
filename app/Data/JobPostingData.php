<?php

namespace App\Data;

use App\Models\JobPosting;

class JobPostingData extends BaseData
{
    public function __construct(
        public int $id,
        public string $title,
        public string $department,
        public ?int $department_id,
        public string $location,
        public string $employmentType,
        public string $rawEmploymentType,
        public string $publishedAt,
        public string $deadline,
        public bool $isUrgent,
        public ?string $description = null,
        public ?string $requirements = null,
        public ?array $top_responsibilities = null,
        public ?array $skills_requirements = null,
        public ?array $education_requirements = null,
        public ?string $experience_requirements = null,
        public ?string $other_qualifications = null,
    ) {}

    public static function fromModel(JobPosting $job): self
    {
        return new self(
            id: $job->id,
            title: $job->title,
            department: $job->department ? $job->department->name : 'General',
            department_id: $job->department_id,
            location: $job->location ?? 'Dar es Salaam, Tanzania',
            employmentType: $job->employment_type ? ucfirst(str_replace('_', ' ', $job->employment_type)) : 'Full Time',
            rawEmploymentType: strtolower(str_replace([' ', '-'], '_', $job->employment_type ?? 'full_time')),
            publishedAt: $job->published_at ? $job->published_at->diffForHumans() : 'Recently',
            deadline: $job->application_deadline ? $job->application_deadline->format('M d, Y') : 'Open until filled',
            isUrgent: $job->application_deadline ? $job->application_deadline->isToday() || $job->application_deadline->diffInDays(now()) <= 3 : false,
            description: $job->description,
            requirements: $job->requirements,
            top_responsibilities: $job->top_responsibilities ?? [],
            skills_requirements: $job->skills_requirements ?? [],
            education_requirements: $job->education_requirements ?? [],
            experience_requirements: $job->experience_requirements ?? '',
            other_qualifications: $job->other_qualifications ?? '',
        );
    }
}
