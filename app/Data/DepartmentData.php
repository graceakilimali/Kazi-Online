<?php

namespace App\Data;

use App\Models\Department;

class DepartmentData extends BaseData
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $description = null,
        public int $openPositionsCount = 0,
    ) {}

    public static function fromModel(Department $department): self
    {
        return new self(
            id: $department->id,
            name: $department->name,
            description: $department->description ?? null,
            openPositionsCount: (int) ($department->published_jobs_count ?? 0),
        );
    }

    public static function fromApiArray(array $dept): self
    {
        return new self(
            id: (int) ($dept['id'] ?? 0),
            name: $dept['name'] ?? $dept['department_name'] ?? 'Department',
            description: $dept['description'] ?? null,
            openPositionsCount: (int) ($dept['published_jobs_count'] ?? $dept['open_positions_count'] ?? 0),
        );
    }
}
