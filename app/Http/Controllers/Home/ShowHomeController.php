<?php

namespace App\Http\Controllers\Home;

use App\Data\DepartmentData;
use App\Data\HomeStatsData;
use App\Data\JobPostingData;
use App\Http\Controllers\Controller;
use App\Services\RecruitmentApiService;
use Inertia\Inertia;
use Inertia\Response;

class ShowHomeController extends Controller
{
    public function __construct(
        protected RecruitmentApiService $apiService
    ) {}

    public function __invoke(): Response
    {
        $response = $this->apiService->getJobs(['per_page' => 6]);
        $rawJobs = $response['data'] ?? [];
        $rawCategories = $this->apiService->getCategories();

        $featuredJobs = array_map(fn ($j) => JobPostingData::fromApiArray($j)->toArray(), $rawJobs);
        $departments = array_map(fn ($d) => DepartmentData::fromApiArray($d)->toArray(), $rawCategories);

        $stats = new HomeStatsData(
            totalOpenings: (int) ($response['meta']['total'] ?? count($featuredJobs)),
            totalDepartments: count($departments),
            companiesCount: count($this->apiService->getCompanies()) ?: 3,
        );

        return Inertia::render('Home', [
            'featuredJobs' => [
                'data' => $featuredJobs,
            ],
            'departments' => [
                'data' => $departments,
            ],
            'stats' => $stats->toArray(),
        ]);
    }
}
