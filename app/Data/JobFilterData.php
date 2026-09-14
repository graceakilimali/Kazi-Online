<?php

namespace App\Data;

use Illuminate\Http\Request;

class JobFilterData extends BaseData
{
    public function __construct(
        public ?string $search = null,
        public ?string $department_id = null,
        public array $employment_type = [],
        public ?string $location = null,
        public ?string $posted_within = null,
        public string $sort = 'latest',
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            search: $request->filled('search') ? trim($request->input('search')) : null,
            department_id: $request->filled('department_id') ? (string) $request->input('department_id') : null,
            employment_type: (array) $request->input('employment_type', []),
            location: $request->filled('location') ? (string) $request->input('location') : null,
            posted_within: $request->filled('posted_within') ? (string) $request->input('posted_within') : null,
            sort: (string) $request->input('sort', 'latest'),
        );
    }
}
