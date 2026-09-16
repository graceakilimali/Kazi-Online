<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use App\Services\RecruitmentApiService;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    public function __construct(
        protected RecruitmentApiService $recruitmentApi
    ) {}

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
        ])->validate();

        $parts = preg_split('/\s+/', trim($input['name']));
        $firstName = array_shift($parts) ?: $input['name'];
        $lastName = !empty($parts) ? array_pop($parts) : $firstName;
        $middleName = !empty($parts) ? implode(' ', $parts) : null;

        // 1. Create candidate user locally in Kazi-Online
        $user = User::create([
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'email' => $input['email'],
            'password' => $input['password'],
        ]);

        // 2. Register candidate on Recruitment System and save Sanctum token
        $response = $this->recruitmentApi->registerApplicant([
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'email' => $input['email'],
            'password' => $input['password'],
            'phone' => $input['phone'] ?? null,
        ]);

        if ($response && !empty($response['token'])) {
            session(['recruitment_token' => $response['token']]);
        }

        return $user;
    }
}
