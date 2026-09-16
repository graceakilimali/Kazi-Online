<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $user = Auth::user();
        $userId = $user ? $user->id : null;

        $stats = [
            'total_applications' => 0,
            'under_review' => 0,
            'interview_invites' => 0,
            'active_jobs' => 0,
        ];

        $recentApplications = [];

        // Real active jobs count in portal
        if (Schema::hasTable('job_postings')) {
            $stats['active_jobs'] = DB::table('job_postings')
                ->where('status', 'published')
                ->whereNull('deleted_at')
                ->count();
        }

        // Real applications data for authenticated candidate
        if ($userId && Schema::hasTable('applications')) {
            $userAppsQuery = DB::table('applications')->where('user_id', $userId);

            $stats['total_applications'] = (clone $userAppsQuery)->count();

            $stats['under_review'] = (clone $userAppsQuery)
                ->whereIn('status', ['pending', 'under_review', 'hod_approved', 'assessment'])
                ->count();

            $stats['interview_invites'] = (clone $userAppsQuery)
                ->whereIn('status', ['interview_scheduled', 'second_interview'])
                ->count();

            $companies = [
                1 => 'East Africa Television Ltd (EATV)',
                2 => 'Independent Television (ITV)',
                3 => 'The Guardian LTD (TGL)',
            ];

            $apps = DB::table('applications')
                ->leftJoin('job_postings', 'applications.job_id', '=', 'job_postings.id')
                ->leftJoin('departments', 'job_postings.department_id', '=', 'departments.id')
                ->where('applications.user_id', $userId)
                ->select(
                    'applications.id',
                    'applications.job_id',
                    'applications.status',
                    'applications.created_at',
                    'job_postings.title as job_title',
                    'job_postings.company_id',
                    'job_postings.location',
                    'job_postings.employment_type',
                    'departments.name as department_name'
                )
                ->orderByDesc('applications.created_at')
                ->limit(5)
                ->get();

            $recentApplications = $apps->map(function ($app) use ($companies) {
                return [
                    'id' => $app->id,
                    'job_id' => $app->job_id,
                    'job_title' => $app->job_title ?: 'Position #' . $app->job_id,
                    'company' => $companies[$app->company_id] ?? 'East Africa Television Ltd (EATV)',
                    'department' => $app->department_name ?: 'General',
                    'location' => $app->location ?: 'Dar es Salaam, Tanzania',
                    'employment_type' => $app->employment_type ? ucfirst(str_replace('_', ' ', $app->employment_type)) : 'Full-time',
                    'status' => $app->status ?: 'pending',
                    'applied_at' => $app->created_at ? date('M d, Y', strtotime($app->created_at)) : '',
                ];
            })->toArray();
        }

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recentApplications' => $recentApplications,
        ]);
    }
}
