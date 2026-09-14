export interface FeaturedJob {
    id: number;
    title: string;
    department: string;
    department_id?: number | null;
    location: string;
    employmentType: string;
    rawEmploymentType?: string;
    publishedAt: string;
    deadline: string;
    isUrgent: boolean;
    description?: string | null;
    requirements?: string | null;
    top_responsibilities?: string[] | null;
    skills_requirements?: string[] | null;
    education_requirements?: string[] | null;
    experience_requirements?: string | null;
    other_qualifications?: string | null;
}

export interface DepartmentCategory {
    id: number;
    name: string;
    description: string | null;
    openPositionsCount: number;
}

export interface HomeStats {
    totalOpenings: number;
    totalDepartments: number;
    companiesCount: number;
}

export interface JobFilterParams {
    search?: string | null;
    department_id?: string | number | null;
    employment_type?: string[];
    location?: string | null;
    posted_within?: string | number | null;
    sort?: string;
}
