<?php

namespace App\Http\Controllers\Jobs;

use App\Data\DepartmentData;
use App\Data\JobFilterData;
use App\Data\JobPostingData;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class JobListingController extends Controller
{
    /**
     * Display a listing of active jobs with filters.
     */
    public function index(Request $request): Response
    {
        try {
            $filters = JobFilterData::fromRequest($request);
            $query = JobPosting::with('department')->active();

            // Keyword Search (Title or Description)
            if ($filters->search) {
                $search = $filters->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('requirements', 'like', "%{$search}%");
                });
            }

            // Department Filter
            if ($filters->department_id) {
                $query->where('department_id', $filters->department_id);
            }

            // Employment Type Filter
            if (!empty($filters->employment_type)) {
                $normalizedTypes = array_filter(array_map('trim', $filters->employment_type));
                if (!empty($normalizedTypes)) {
                    $query->where(function ($q) use ($normalizedTypes) {
                        foreach ($normalizedTypes as $type) {
                            $cleanType = str_replace('_', ' ', strtolower($type));
                            $q->orWhereRaw('LOWER(REPLACE(employment_type, "_", " ")) LIKE ?', ["%{$cleanType}%"]);
                        }
                    });
                }
            }

            // Location Filter
            if ($filters->location) {
                $query->where('location', $filters->location);
            }

            // Posted Within Filter (days)
            if ($filters->posted_within) {
                $days = (int) $filters->posted_within;
                if ($days > 0) {
                    $query->where('published_at', '>=', now()->subDays($days));
                }
            }

            // Sort order
            if ($filters->sort === 'oldest') {
                $query->orderBy('published_at', 'asc');
            } elseif ($filters->sort === 'title') {
                $query->orderBy('title', 'asc');
            } else {
                $query->orderBy('published_at', 'desc');
            }

            $jobsPaginated = $query->paginate(12)->withQueryString();

            $departments = Department::withCount(['jobs as published_jobs_count' => function ($q) {
                $q->where('status', 'published')
                  ->where(function ($sub) {
                      $sub->whereNull('application_deadline')
                          ->orWhere('application_deadline', '>=', now()->toDateString());
                  });
            }])->orderBy('name')->get();

            $locations = JobPosting::active()
                ->whereNotNull('location')
                ->where('location', '!=', '')
                ->distinct()
                ->pluck('location');

            // Format jobs data using JobPostingData
            $jobsData = $jobsPaginated->through(fn ($job) => JobPostingData::fromModel($job)->toArray());

            return Inertia::render('Jobs/Index', [
                'jobs' => $jobsData,
                'departments' => DepartmentData::collect($departments),
                'locations' => $locations,
                'filters' => $filters->toArray(),
            ]);
        } catch (Throwable $e) {
            return Inertia::render('Jobs/Index', [
                'jobs' => [
                    'data' => [],
                    'total' => 0,
                    'current_page' => 1,
                    'last_page' => 1,
                    'links' => [],
                ],
                'departments' => [],
                'locations' => [],
                'filters' => [
                    'search' => '',
                    'department_id' => '',
                    'employment_type' => [],
                    'location' => '',
                    'posted_within' => '',
                    'sort' => 'latest',
                ],
            ]);
        }
    }

    /**
     * Display a specific job posting.
     */
    public function show(int|string $id): Response
    {
        try {
            $job = JobPosting::with('department')->findOrFail($id);

            $relatedJobs = JobPosting::with('department')
                ->active()
                ->where('id', '!=', $job->id)
                ->where('department_id', $job->department_id)
                ->take(3)
                ->get();

            return Inertia::render('Jobs/Show', [
                'job' => JobPostingData::fromModel($job)->toArray(),
                'relatedJobs' => [
                    'data' => JobPostingData::collect($relatedJobs),
                ],
            ]);
        } catch (Throwable $e) {
            abort(404, 'Job posting not found');
        }
    }
}
