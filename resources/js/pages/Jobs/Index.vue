<script setup lang="ts">
import { reactive, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PublicNavbar from '@/components/Layout/PublicNavbar.vue';
import PublicFooter from '@/components/Layout/PublicFooter.vue';
import { Search, MapPin, Building2, Clock, Filter, RotateCcw, ArrowRight, Briefcase } from '@lucide/vue';

interface JobItem {
    id: number;
    title: string;
    department: string;
    department_id?: number;
    location: string;
    employmentType: string;
    rawEmploymentType?: string;
    publishedAt: string;
    deadline: string;
    isUrgent?: boolean;
    description?: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface JobsPaginated {
    data: JobItem[];
    total: number;
    current_page: number;
    last_page: number;
    links: PaginationLink[];
    from: number;
    to: number;
}

interface DepartmentOption {
    id: number;
    name: string;
    openPositionsCount: number;
}

const props = defineProps<{
    jobs: JobsPaginated;
    departments: DepartmentOption[];
    locations: string[];
    filters: {
        search: string;
        department_id: string | number;
        employment_type: string[];
        location: string;
        posted_within: string;
        sort: string;
    };
}>();

const formFilters = reactive({
    search: props.filters.search || '',
    department_id: props.filters.department_id || '',
    employment_type: Array.isArray(props.filters.employment_type) ? [...props.filters.employment_type] : [],
    location: props.filters.location || '',
    posted_within: props.filters.posted_within || '',
    sort: props.filters.sort || 'latest',
});

const applyFilters = () => {
    router.get('/jobs', {
        search: formFilters.search || undefined,
        department_id: formFilters.department_id || undefined,
        employment_type: formFilters.employment_type.length ? formFilters.employment_type : undefined,
        location: formFilters.location || undefined,
        posted_within: formFilters.posted_within || undefined,
        sort: formFilters.sort || undefined,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};

const clearFilters = () => {
    formFilters.search = '';
    formFilters.department_id = '';
    formFilters.employment_type = [];
    formFilters.location = '';
    formFilters.posted_within = '';
    formFilters.sort = 'latest';
    applyFilters();
};

const toggleEmploymentType = (type: string) => {
    const idx = formFilters.employment_type.indexOf(type);
    if (idx > -1) {
        formFilters.employment_type.splice(idx, 1);
    } else {
        formFilters.employment_type.push(type);
    }
    applyFilters();
};

const employmentTypeOptions = [
    { value: 'full_time', label: 'Full Time' },
    { value: 'part_time', label: 'Part Time' },
    { value: 'contract', label: 'Contract' },
    { value: 'temporary', label: 'Temporary' },
];

const postedWithinOptions = [
    { value: '', label: 'Any' },
    { value: '1', label: 'Today' },
    { value: '2', label: 'Last 2 days' },
    { value: '3', label: 'Last 3 days' },
    { value: '5', label: 'Last 5 days' },
    { value: '10', label: 'Last 10 days' },
];
</script>

<template>
    <Head title="Find Jobs - EATV Recruitment Portal" />

    <div class="flex min-h-screen flex-col bg-background text-foreground transition-colors duration-200">
        <PublicNavbar />

        <main class="flex-1">
            <!-- Hero Header Banner -->
            <div
                class="relative bg-slate-950 bg-fixed bg-cover bg-center py-16 text-white border-b border-border overflow-hidden"
                style="background-image: url('/images/dark-bg.jpg');"
            >
                <!-- Dark gradient overlay for strong text contrast while preserving image depth -->
                <div class="absolute inset-0 bg-gradient-to-b from-slate-950/85 via-slate-950/60 to-slate-950/85 backdrop-blur-[0.5px]"></div>

                <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <span class="text-xs font-bold uppercase tracking-widest text-cyan-400">Opportunities</span>
                        <h1 class="mt-2 text-3xl font-extrabold tracking-tight sm:text-4xl lg:text-5xl text-white drop-shadow-[0_2px_12px_rgba(0,0,0,0.9)]">
                            Posted Jobs
                        </h1>
                        <p class="mt-3 text-base font-medium text-slate-100 max-w-xl mx-auto drop-shadow-[0_2px_6px_rgba(0,0,0,0.9)]">
                            Find your next career opportunity across our Companies
                        </p>
                    </div>
                </div>
            </div>

            <!-- Job Listing Section -->
            <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
                    <!-- Left Sidebar Filters -->
                    <aside class="lg:col-span-4 xl:col-span-3">
                        <div class="sticky top-24 rounded-xl border border-border bg-card p-6 shadow-xs">
                            <!-- Filter Header -->
                            <div class="flex items-center justify-between border-b border-border pb-4">
                                <div class="flex items-center gap-2">
                                    <Filter class="h-4 w-4 text-[#0066cc]" />
                                    <h2 class="text-base font-bold text-foreground">Filter Jobs</h2>
                                </div>
                                <button
                                    type="button"
                                    @click="clearFilters"
                                    class="inline-flex items-center gap-1 text-xs font-semibold text-muted-foreground hover:text-[#0066cc]"
                                >
                                    <RotateCcw class="h-3 w-3" />
                                    <span>Clear</span>
                                </button>
                            </div>

                            <!-- Search Input -->
                            <div class="mt-5">
                                <label class="text-xs font-bold uppercase tracking-wider text-muted-foreground">Keyword</label>
                                <div class="relative mt-2">
                                    <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                                    <input
                                        v-model="formFilters.search"
                                        @keyup.enter="applyFilters"
                                        type="text"
                                        placeholder="Job title or skill..."
                                        class="w-full rounded-md border border-input bg-background py-2 pl-9 pr-3 text-sm focus:border-[#0066cc] focus:outline-none focus:ring-1 focus:ring-[#0066cc]"
                                    />
                                </div>
                            </div>

                            <!-- Department Filter -->
                            <div class="mt-6 border-t border-border pt-5">
                                <label class="text-xs font-bold uppercase tracking-wider text-muted-foreground">Department</label>
                                <select
                                    v-model="formFilters.department_id"
                                    @change="applyFilters"
                                    class="mt-2 w-full rounded-md border border-input bg-background py-2 px-3 text-sm focus:border-[#0066cc] focus:outline-none focus:ring-1 focus:ring-[#0066cc]"
                                >
                                    <option value="">All Departments</option>
                                    <option v-for="dept in departments" :key="dept.id" :value="dept.id">
                                        {{ dept.name }}
                                    </option>
                                </select>
                            </div>

                            <!-- Job Type Filter -->
                            <div class="mt-6 border-t border-border pt-5">
                                <label class="text-xs font-bold uppercase tracking-wider text-muted-foreground">Job Type</label>
                                <div class="mt-2.5 space-y-2">
                                    <label
                                        v-for="type in employmentTypeOptions"
                                        :key="type.value"
                                        class="flex items-center gap-2.5 text-sm cursor-pointer text-foreground/90 hover:text-[#0066cc]"
                                    >
                                        <input
                                            type="checkbox"
                                            :value="type.value"
                                            :checked="formFilters.employment_type.includes(type.value)"
                                            @change="toggleEmploymentType(type.value)"
                                            class="rounded border-input text-[#0066cc] focus:ring-[#0066cc]"
                                        />
                                        <span>{{ type.label }}</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Location Filter -->
                            <div v-if="locations.length > 0" class="mt-6 border-t border-border pt-5">
                                <label class="text-xs font-bold uppercase tracking-wider text-muted-foreground">Location</label>
                                <select
                                    v-model="formFilters.location"
                                    @change="applyFilters"
                                    class="mt-2 w-full rounded-md border border-input bg-background py-2 px-3 text-sm focus:border-[#0066cc] focus:outline-none focus:ring-1 focus:ring-[#0066cc]"
                                >
                                    <option value="">Anywhere</option>
                                    <option v-for="loc in locations" :key="loc" :value="loc">
                                        {{ loc }}
                                    </option>
                                </select>
                            </div>

                            <!-- Posted Within Filter -->
                            <div class="mt-6 border-t border-border pt-5">
                                <label class="text-xs font-bold uppercase tracking-wider text-muted-foreground">Posted Within</label>
                                <div class="mt-2.5 space-y-2">
                                    <label
                                        v-for="option in postedWithinOptions"
                                        :key="option.value"
                                        class="flex items-center gap-2.5 text-sm cursor-pointer text-foreground/90 hover:text-[#0066cc]"
                                    >
                                        <input
                                            type="radio"
                                            name="posted_within"
                                            :value="option.value"
                                            :checked="formFilters.posted_within === option.value"
                                            @change="formFilters.posted_within = option.value; applyFilters()"
                                            class="border-input text-[#0066cc] focus:ring-[#0066cc]"
                                        />
                                        <span>{{ option.label }}</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Filter Submit Button -->
                            <div class="mt-6 border-t border-border pt-5">
                                <button
                                    type="button"
                                    @click="applyFilters"
                                    class="w-full rounded-md bg-[#0066cc] py-2.5 text-sm font-semibold text-white transition-colors hover:bg-[#0052cc]"
                                >
                                    Apply Filters
                                </button>
                            </div>
                        </div>
                    </aside>

                    <!-- Right Jobs Listing Area -->
                    <div class="lg:col-span-8 xl:col-span-9">
                        <!-- Header Count & Sort Bar -->
                        <div class="flex flex-col gap-3 rounded-xl border border-border bg-card p-4 sm:flex-row sm:items-center sm:justify-between shadow-xs mb-6">
                            <span class="text-sm font-bold text-foreground">
                                {{ jobs.total }} {{ jobs.total === 1 ? 'Job' : 'Jobs' }} found
                            </span>

                            <div class="flex items-center gap-2 text-sm text-muted-foreground">
                                <span>Sort by:</span>
                                <select
                                    v-model="formFilters.sort"
                                    @change="applyFilters"
                                    class="rounded-md border border-input bg-background py-1.5 px-3 text-sm text-foreground focus:border-[#0066cc] focus:outline-none"
                                >
                                    <option value="latest">Latest</option>
                                    <option value="oldest">Oldest</option>
                                    <option value="title">Job Title</option>
                                </select>
                            </div>
                        </div>

                        <!-- Jobs List Items -->
                        <div v-if="jobs.data.length > 0" class="space-y-4">
                            <div
                                v-for="job in jobs.data"
                                :key="job.id"
                                class="group flex flex-col justify-between rounded-xl border border-border bg-card p-6 shadow-xs transition-all duration-200 hover:-translate-y-0.5 hover:border-[#0066cc]/60 hover:shadow-md sm:flex-row sm:items-center"
                            >
                                <div class="flex items-start gap-4">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-[#0066cc] dark:bg-blue-950/50 dark:text-blue-400">
                                        <Building2 class="h-6 w-6" />
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-foreground transition-colors group-hover:text-[#0066cc]">
                                            <Link :href="`/jobs/${job.id}`">
                                                {{ job.title }}
                                            </Link>
                                        </h3>
                                        <div class="mt-2 flex flex-wrap items-center gap-y-1 gap-x-4 text-xs text-muted-foreground">
                                            <span class="font-medium text-foreground/80">{{ job.department }}</span>
                                            <div class="flex items-center gap-1">
                                                <MapPin class="h-3.5 w-3.5 text-slate-400" />
                                                <span>{{ job.location }}</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <Clock class="h-3.5 w-3.5 text-slate-400" />
                                                <span>Deadline: {{ job.deadline }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-row sm:flex-col items-center sm:items-end justify-between gap-2 border-t border-border pt-4 sm:mt-0 sm:border-t-0 sm:pt-0">
                                    <span class="inline-flex items-center rounded-md border border-blue-500/30 bg-blue-50 px-3 py-1 text-xs font-semibold text-[#0066cc] dark:bg-blue-950/40 dark:text-blue-300">
                                        {{ job.employmentType }}
                                    </span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs text-muted-foreground">{{ job.publishedAt }}</span>
                                        <Link
                                            :href="`/jobs/${job.id}`"
                                            class="inline-flex items-center gap-1 rounded-md bg-[#0066cc] px-3.5 py-1.5 text-xs font-semibold text-white transition-colors hover:bg-[#0052cc]"
                                        >
                                            <span>Apply</span>
                                            <ArrowRight class="h-3 w-3" />
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div v-else class="rounded-xl border border-dashed border-border p-12 text-center bg-card">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400 dark:bg-slate-800">
                                <Briefcase class="h-6 w-6" />
                            </div>
                            <h3 class="mt-4 text-base font-bold text-foreground">No jobs matching your filters</h3>
                            <p class="mt-1 text-sm text-muted-foreground">Try clearing some filter criteria or searching for a different keyword.</p>
                            <div class="mt-6">
                                <button
                                    type="button"
                                    @click="clearFilters"
                                    class="inline-flex items-center gap-2 rounded-md bg-[#0066cc] px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#0052cc]"
                                >
                                    <RotateCcw class="h-4 w-4" />
                                    <span>Reset All Filters</span>
                                </button>
                            </div>
                        </div>

                        <!-- Pagination Navigation -->
                        <div v-if="jobs.links && jobs.links.length > 3" class="mt-10 flex justify-center">
                            <nav class="inline-flex items-center gap-1 rounded-lg border border-border bg-card p-1 shadow-xs">
                                <template v-for="(link, index) in jobs.links" :key="index">
                                    <Link
                                        v-if="link.url"
                                        :href="link.url"
                                        v-html="link.label"
                                        class="rounded-md px-3 py-1.5 text-xs font-semibold transition-colors"
                                        :class="link.active ? 'bg-[#0066cc] text-white' : 'text-foreground hover:bg-muted'"
                                    />
                                    <span
                                        v-else
                                        v-html="link.label"
                                        class="rounded-md px-3 py-1.5 text-xs font-medium text-muted-foreground/60"
                                    />
                                </template>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <PublicFooter />
    </div>
</template>
