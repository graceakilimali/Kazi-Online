<?php

namespace App\Data;

use App\Models\JobPosting;

class JobPostingData extends BaseData
{
    public function __construct(
        public int $id,
        public string $title,
        public string $company,
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
        public ?string $jd_file_url = null,
        public ?string $jd_file_name = null,
    ) {}

    public static function fromModel(JobPosting $job): self
    {
        $rawJdFile = $job->effective_jd_file;
        $jdFileUrl = null;
        $jdFileName = null;

        if ($rawJdFile) {
            $jdFileName = basename($rawJdFile);
            if (str_starts_with($rawJdFile, 'http://') || str_starts_with($rawJdFile, 'https://')) {
                $jdFileUrl = $rawJdFile;
            } else {
                $jdFileUrl = url("/jobs/{$job->id}/jd");
            }
        }

        $formattedEducation = self::formatEducationRequirements($job->effective_education_requirements);
        $formattedRequirements = self::formatRequirementsText($job->requirements, $formattedEducation);

        return new self(
            id: $job->id,
            title: $job->title,
            company: $job->effective_company_name,
            department: $job->department ? $job->department->name : 'General',
            department_id: $job->department_id,
            location: $job->location ?? 'Dar es Salaam, Tanzania',
            employmentType: $job->employment_type ? ucfirst(str_replace('_', ' ', $job->employment_type)) : 'Full Time',
            rawEmploymentType: strtolower(str_replace([' ', '-'], '_', $job->employment_type ?? 'full_time')),
            publishedAt: $job->published_at ? $job->published_at->diffForHumans() : 'Recently',
            deadline: $job->application_deadline ? $job->application_deadline->format('M d, Y') : 'Open until filled',
            isUrgent: $job->application_deadline ? ($job->application_deadline->isToday() || $job->application_deadline->diffInDays(now()) <= 3) : false,
            description: $job->description,
            requirements: $formattedRequirements,
            top_responsibilities: $job->effective_top_responsibilities,
            skills_requirements: $job->effective_skills_requirements,
            education_requirements: $formattedEducation,
            experience_requirements: $job->effective_experience_requirements,
            other_qualifications: $job->effective_other_qualifications,
            jd_file_url: $jdFileUrl,
            jd_file_name: $jdFileName,
        );
    }

    public static function fromApiArray(array $job): self
    {
        $rawJdFile = $job['jd_file'] ?? null;
        $jdFileUrl = null;
        $jdFileName = null;

        if ($rawJdFile) {
            $jdFileName = basename($rawJdFile);
            $jdFileUrl = str_starts_with($rawJdFile, 'http')
                ? $rawJdFile
                : url("/jobs/{$job['id']}/jd");
        }

        $formattedEducation = self::formatEducationRequirements($job['education_requirements'] ?? []);
        $formattedRequirements = self::formatRequirementsText($job['requirements'] ?? null, $formattedEducation);

        $publishedAtStr = 'Recently';
        if (!empty($job['published_at'])) {
            try {
                $publishedAtStr = \Carbon\Carbon::parse($job['published_at'])->diffForHumans();
            } catch (\Throwable) {
                $publishedAtStr = 'Recently';
            }
        }

        $deadlineStr = 'Open until filled';
        $isUrgent = false;
        if (!empty($job['application_deadline'])) {
            try {
                $deadlineDate = \Carbon\Carbon::parse($job['application_deadline']);
                $deadlineStr = $deadlineDate->format('M d, Y');
                $isUrgent = $deadlineDate->isToday() || ($deadlineDate->isFuture() && $deadlineDate->diffInDays(now()) <= 3);
            } catch (\Throwable) {
                $deadlineStr = $job['application_deadline'];
            }
        }

        $rawEmp = strtolower(str_replace([' ', '-'], '_', $job['employment_type'] ?? 'full_time'));

        return new self(
            id: (int) $job['id'],
            title: $job['title'] ?? '',
            company: $job['company_name'] ?? 'Company',
            department: $job['department_name'] ?? 'General',
            department_id: isset($job['department_id']) ? (int) $job['department_id'] : null,
            location: $job['location'] ?? 'Dar es Salaam, Tanzania',
            employmentType: ucfirst(str_replace('_', ' ', $rawEmp)),
            rawEmploymentType: $rawEmp,
            publishedAt: $publishedAtStr,
            deadline: $deadlineStr,
            isUrgent: $isUrgent,
            description: $job['description'] ?? null,
            requirements: $formattedRequirements,
            top_responsibilities: $job['top_responsibilities'] ?? [],
            skills_requirements: $job['skills_requirements'] ?? [],
            education_requirements: $formattedEducation,
            experience_requirements: $job['experience_requirements'] ?? null,
            other_qualifications: $job['other_qualifications'] ?? null,
            jd_file_url: $jdFileUrl,
            jd_file_name: $jdFileName,
        );
    }

    /**
     * Format structured education requirements JSON/array into clean human-readable list.
     */
    public static function formatEducationRequirements(mixed $edu): array
    {
        if (empty($edu)) {
            return [];
        }

        if (is_string($edu)) {
            $decoded = json_decode($edu, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $edu = $decoded;
            } else {
                return array_filter(array_map('trim', explode("\n", $edu)));
            }
        }

        if (!is_array($edu)) {
            return [];
        }

        $formatted = [];
        foreach ($edu as $item) {
            if (is_string($item)) {
                $formatted[] = trim($item);
            } elseif (is_array($item)) {
                $level = isset($item['level']) ? ucwords(str_replace('_', ' ', $item['level'])) : '';
                $fields = '';
                if (isset($item['fields'])) {
                    if (is_array($item['fields'])) {
                        $fields = implode(', ', array_filter($item['fields']));
                    } elseif (is_string($item['fields'])) {
                        $fields = $item['fields'];
                    }
                }

                if ($level && $fields) {
                    $formatted[] = "{$level} in {$fields}";
                } elseif ($level) {
                    $formatted[] = $level;
                } elseif ($fields) {
                    $formatted[] = $fields;
                }
            }
        }

        return $formatted;
    }

    /**
     * Clean and format requirements string. If it's a JSON array, convert to readable text.
     */
    public static function formatRequirementsText(?string $req, array $fallbackEducation = []): ?string
    {
        if (empty($req)) {
            return !empty($fallbackEducation) ? implode("\n", $fallbackEducation) : null;
        }

        // Check if $req is JSON
        if (str_starts_with(trim($req), '[') || str_starts_with(trim($req), '{')) {
            $decoded = json_decode($req, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $items = self::formatEducationRequirements($decoded);
                if (!empty($items)) {
                    return implode("\n", $items);
                }
            }
        }

        return $req;
    }
}
