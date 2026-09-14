<?php

namespace App\Data;

class HomeStatsData extends BaseData
{
    public function __construct(
        public int $totalOpenings = 0,
        public int $totalDepartments = 0,
        public int $companiesCount = 3,
    ) {}
}
