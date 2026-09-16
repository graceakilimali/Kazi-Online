<?php

namespace App\Http\Controllers\Jobs;

use App\Data\DepartmentData;
use App\Data\JobFilterData;
use App\Data\JobPostingData;
use App\Http\Controllers\Controller;
use App\Services\RecruitmentApiService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class JobListingController extends Controller
{
    public function __construct(
        protected RecruitmentApiService $apiService
    ) {}

    /**
     * Display the job exploration page.
     */
    public function index(Request $request): Response
    {
        $filters = JobFilterData::fromRequest($request);
        $queryParams = array_filter([
            'search' => $filters->search,
            'department_id' => $filters->department_id,
            'employment_type' => !empty($filters->employment_type) ? implode(',', (array) $filters->employment_type) : null,
            'location' => $filters->location,
            'page' => $request->get('page', 1),
            'per_page' => 12,
        ]);

        $response = $this->apiService->getJobs($queryParams);
        $rawJobs = $response['data'] ?? [];
        $meta = $response['meta'] ?? ['total' => 0, 'current_page' => 1, 'last_page' => 1, 'per_page' => 12];

        $jobsList = array_map(fn ($j) => JobPostingData::fromApiArray($j)->toArray(), $rawJobs);
        $departments = array_map(fn ($d) => DepartmentData::fromApiArray($d)->toArray(), $this->apiService->getCategories());
        $companies = $this->apiService->getCompanies();

        $locations = collect($rawJobs)->pluck('location')->filter()->unique()->values()->all();
        if (empty($locations)) {
            $locations = ['Dar es Salaam, Tanzania', 'Mikocheni, Dar es Salaam', 'Arusha Region, Tanzania'];
        }

        return Inertia::render('Jobs/Index', [
            'jobs' => [
                'data' => $jobsList,
                'total' => (int) ($meta['total'] ?? count($jobsList)),
                'current_page' => (int) ($meta['current_page'] ?? 1),
                'last_page' => (int) ($meta['last_page'] ?? 1),
                'links' => [],
                'from' => 1,
                'to' => count($jobsList),
            ],
            'departments' => $departments,
            'companies' => $companies,
            'locations' => $locations,
            'filters' => $filters->toArray(),
        ]);
    }

    /**
     * Display a single job details page.
     */
    public function show(int $id): Response
    {
        $jobRaw = $this->apiService->getJob($id);

        if (!$jobRaw) {
            abort(404, 'Job not found or is no longer active.');
        }

        $jobData = JobPostingData::fromApiArray($jobRaw)->toArray();

        // Fetch related jobs in same department
        $relatedResponse = $this->apiService->getJobs([
            'department_id' => $jobRaw['department_id'] ?? null,
            'per_page' => 4,
        ]);

        $relatedJobs = collect($relatedResponse['data'] ?? [])
            ->filter(fn ($j) => (int) $j['id'] !== $id)
            ->take(3)
            ->map(fn ($j) => JobPostingData::fromApiArray($j)->toArray())
            ->values()
            ->all();

        return Inertia::render('Jobs/Show', [
            'job' => $jobData,
            'relatedJobs' => [
                'data' => $relatedJobs,
            ],
        ]);
    }
}
