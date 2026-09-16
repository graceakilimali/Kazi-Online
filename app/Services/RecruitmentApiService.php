<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecruitmentApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.recruitment.base_url', env('RECRUITMENT_API_URL', 'http://127.0.0.1:8000/api/v1')), '/');
    }

    /**
     * Create an HTTP client instance.
     * If a Sanctum token is provided (or stored in session), attach Bearer header.
     */
    protected function client(?string $token = null)
    {
        $token = $token ?? session('recruitment_token');

        $client = Http::baseUrl($this->baseUrl)
            ->withHeaders([
                'Accept' => 'application/json',
            ])
            ->timeout(10);

        if ($token) {
            $client = $client->withToken($token);
        }

        return $client;
    }

    /**
     * Register candidate on Recruitment System and retrieve Sanctum token.
     */
    public function registerApplicant(array $data): ?array
    {
        try {
            $response = $this->client()->post('/auth/register', $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Recruitment API register failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        } catch (\Exception $e) {
            Log::error('Recruitment API registerApplicant error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Login candidate on Recruitment System and retrieve Sanctum token.
     */
    public function loginApplicant(string $email, string $password): ?array
    {
        try {
            $response = $this->client()->post('/auth/login', [
                'email' => $email,
                'password' => $password,
            ]);

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::error('Recruitment API loginApplicant error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Fetch authenticated user profile using Sanctum token.
     */
    public function getProfile(?string $token = null): ?array
    {
        try {
            $response = $this->client($token)->get('/auth/user');
            if ($response->successful()) {
                return $response->json('data');
            }
        } catch (\Exception $e) {
            Log::error('Recruitment API getProfile error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Fetch list of published jobs with optional filters.
     */
    public function getJobs(array $filters = []): array
    {
        try {
            $response = $this->client()->get('/jobs', $filters);

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::error('Recruitment API getJobs error: ' . $e->getMessage());
        }

        return ['success' => false, 'data' => [], 'meta' => ['total' => 0]];
    }

    /**
     * Fetch a single job details by ID.
     */
    public function getJob(int $id): ?array
    {
        try {
            $response = $this->client()->get("/jobs/{$id}");

            if ($response->successful()) {
                return $response->json('data');
            }
        } catch (\Exception $e) {
            Log::error("Recruitment API getJob({$id}) error: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Fetch active departments/categories.
     */
    public function getCategories(): array
    {
        try {
            $response = $this->client()->get('/categories');
            if ($response->successful()) {
                return $response->json('data', []);
            }
        } catch (\Exception $e) {
            Log::error('Recruitment API getCategories error: ' . $e->getMessage());
        }

        return [];
    }

    /**
     * Fetch active companies from the portal.
     */
    public function getCompanies(): array
    {
        try {
            $response = $this->client()->get('/companies');
            if ($response->successful()) {
                return $response->json('data', []);
            }
        } catch (\Exception $e) {
            Log::error('Recruitment API getCompanies error: ' . $e->getMessage());
        }

        return [];
    }
}
