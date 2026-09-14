<?php

namespace App\Http\Controllers\Home;

use App\Data\DepartmentData;
use App\Data\HomeStatsData;
use App\Data\JobPostingData;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class ShowHomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response
    {
        try {
            $featuredJobs = JobPosting::with('department')
                ->active()
                ->orderBy('published_at', 'desc')
                ->take(6)
                ->get();

            $departments = Department::withCount(['jobs as published_jobs_count' => function ($query) {
                $query->where('status', 'published')
                    ->where(function ($q) {
                        $q->whereNull('application_deadline')
                          ->orWhere('application_deadline', '>=', now()->toDateString());
                    });
            }])
            ->orderBy('name')
            ->get();

            $stats = new HomeStatsData(
                totalOpenings: JobPosting::active()->count(),
                totalDepartments: $departments->count(),
                companiesCount: 3,
            );

            return Inertia::render('Home', [
                'featuredJobs' => [
                    'data' => JobPostingData::collect($featuredJobs),
                ],
                'departments' => [
                    'data' => DepartmentData::collect($departments),
                ],
                'stats' => $stats->toArray(),
            ]);
        } catch (Throwable $e) {
            return Inertia::render('Home', [
                'featuredJobs' => ['data' => []],
                'departments' => ['data' => []],
                'stats' => [
                    'totalOpenings' => 0,
                    'totalDepartments' => 0,
                    'companiesCount' => 3,
                ],
            ]);
        }
    }
}
