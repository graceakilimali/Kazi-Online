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
}
