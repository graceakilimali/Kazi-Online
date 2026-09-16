<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import {
    Briefcase,
    Building2,
    Calendar,
    ChevronRight,
    Clock,
    FileText,
    ClipboardList,
    MapPin,
    Search,
    Inbox,
} from '@lucide/vue';
import { dashboard } from '@/routes';

interface ApplicationItem {
    id: number;
    job_id: number;
    job_title: string;
    company: string;
    department: string;
    location: string;
    employment_type: string;
    status: string;
    applied_at: string;
}

interface DashboardStats {
    total_applications: number;
    under_review: number;
    interview_invites: number;
    active_jobs: number;
}

const props = withDefaults(
    defineProps<{
        stats?: DashboardStats;
        recentApplications?: ApplicationItem[];
    }>(),
    {
        stats: () => ({
            total_applications: 0,
            under_review: 0,
            interview_invites: 0,
            active_jobs: 0,
        }),
        recentApplications: () => [],
    },
);

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
});

const page = usePage();
const user = computed(() => page.props.auth?.user || { name: 'Applicant' });

const getStatusBadge = (status: string) => {
    switch (status) {
        case 'interview_scheduled':
        case 'Interview Scheduled':
            return 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/50 dark:text-emerald-300 dark:border-emerald-800';
        case 'under_review':
        case 'Under Review':
        case 'pending':
        case 'Pending Review':
            return 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/50 dark:text-amber-300 dark:border-amber-800';
        case 'assessment':
        case 'Under Assessment':
            return 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-950/50 dark:text-blue-300 dark:border-blue-800';
        case 'rejected':
        case 'Rejected':
            return 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/50 dark:text-rose-300 dark:border-rose-800';
        default:
            return 'bg-neutral-100 text-neutral-700 border-neutral-200 dark:bg-neutral-800 dark:text-neutral-300 dark:border-neutral-700';
    }
};

const formatStatus = (status: string) => {
    const map: Record<string, string> = {
        pending: 'Pending Review',
        under_review: 'Under Review',
        hod_approved: 'HOD Approved',
        hod_rejected: 'HOD Rejected',
        interview_scheduled: 'Interview Scheduled',
        interviewed: 'Interviewed',
        second_interview: 'Second Interview',
        assessment: 'Under Assessment',
        hired: 'Hired',
        rejected: 'Rejected',
        withdrawn: 'Withdrawn',
    };
    return map[status] || status.replace(/_/g, ' ');
};
</script>

<template>
    <Head title="Dashboard - KaziOnline" />

    <div class="flex-1 space-y-6 p-4 md:p-6 max-w-7xl mx-auto w-full">
        <!-- 1. Clean Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-neutral-200 dark:border-neutral-800 pb-5">
            <div>
                <h1 class="text-xl font-bold tracking-tight text-neutral-900 dark:text-white">
                    Applicant Dashboard
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                    Welcome back, {{ user.name }}!
                </p>
            </div>

            <div class="flex items-center gap-3">
                <Link
                    href="/jobs"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#0066cc] px-4 py-2 text-xs font-semibold text-white hover:bg-blue-700 transition-colors shadow-xs"
                >
                    <Search class="size-3.5" />
                    Browse Jobs
                </Link>
            </div>
        </div>

        <!-- 2. Real Stat Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Applications -->
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 p-4 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">Total Applications</span>
                    <div class="size-8 rounded-lg bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center text-neutral-600 dark:text-neutral-300">
                        <ClipboardList class="size-4" />
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-2xl font-bold text-neutral-900 dark:text-white">
                        {{ stats.total_applications }}
                    </span>
                </div>
                <p class="mt-1 text-xs text-neutral-400 dark:text-neutral-500">Submitted positions</p>
            </div>

            <!-- Under Review -->
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 p-4 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">Under Review</span>
                    <div class="size-8 rounded-lg bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center text-neutral-600 dark:text-neutral-300">
                        <Clock class="size-4" />
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-2xl font-bold text-neutral-900 dark:text-white">
                        {{ stats.under_review }}
                    </span>
                </div>
                <p class="mt-1 text-xs text-neutral-400 dark:text-neutral-500">In screening stage</p>
            </div>

            <!-- Interview Invitations -->
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 p-4 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">Interviews</span>
                    <div class="size-8 rounded-lg bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center text-neutral-600 dark:text-neutral-300">
                        <Calendar class="size-4" />
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-2xl font-bold text-neutral-900 dark:text-white">
                        {{ stats.interview_invites }}
                    </span>
                </div>
                <p class="mt-1 text-xs text-neutral-400 dark:text-neutral-500">Scheduled sessions</p>
            </div>

            <!-- Open Vacancies -->
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 p-4 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">Open Vacancies</span>
                    <div class="size-8 rounded-lg bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center text-neutral-600 dark:text-neutral-300">
                        <Briefcase class="size-4" />
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-2xl font-bold text-neutral-900 dark:text-white">
                        {{ stats.active_jobs }}
                    </span>
                </div>
                <p class="mt-1 text-xs text-neutral-400 dark:text-neutral-500">Available to apply</p>
            </div>
        </div>

        <!-- 3. Quick Actions -->
        <div class="space-y-3">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">Quick Actions</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                <Link
                    href="#"
                    class="group flex items-center gap-3 p-3.5 rounded-xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 hover:border-neutral-300 dark:hover:border-neutral-700 hover:bg-neutral-50/50 dark:hover:bg-neutral-800/50 transition-colors"
                >
                    <div class="size-9 rounded-lg bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center text-neutral-700 dark:text-neutral-300">
                        <FileText class="size-4.5" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xs font-semibold text-neutral-900 dark:text-white truncate">My CV Profile</h3>
                        <p class="text-[11px] text-neutral-500 truncate">Manage resume & skills</p>
                    </div>
                    <ChevronRight class="size-4 text-neutral-400" />
                </Link>

                <Link
                    href="#"
                    class="group flex items-center gap-3 p-3.5 rounded-xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 hover:border-neutral-300 dark:hover:border-neutral-700 hover:bg-neutral-50/50 dark:hover:bg-neutral-800/50 transition-colors"
                >
                    <div class="size-9 rounded-lg bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center text-neutral-700 dark:text-neutral-300">
                        <ClipboardList class="size-4.5" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xs font-semibold text-neutral-900 dark:text-white truncate">My Applications</h3>
                        <p class="text-[11px] text-neutral-500 truncate">View all submissions</p>
                    </div>
                    <ChevronRight class="size-4 text-neutral-400" />
                </Link>

                <Link
                    href="#"
                    class="group flex items-center gap-3 p-3.5 rounded-xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 hover:border-neutral-300 dark:hover:border-neutral-700 hover:bg-neutral-50/50 dark:hover:bg-neutral-800/50 transition-colors"
                >
                    <div class="size-9 rounded-lg bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center text-neutral-700 dark:text-neutral-300">
                        <Calendar class="size-4.5" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xs font-semibold text-neutral-900 dark:text-white truncate">My Interviews</h3>
                        <p class="text-[11px] text-neutral-500 truncate">Check upcoming sessions</p>
                    </div>
                    <ChevronRight class="size-4 text-neutral-400" />
                </Link>
            </div>
        </div>

        <!-- 4. Latest Application History Section -->
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 shadow-xs overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b border-neutral-200 dark:border-neutral-800">
                <div>
                    <h2 class="text-sm font-bold text-neutral-900 dark:text-white">
                        Latest Application History
                    </h2>
                </div>
            </div>

            <!-- List of Applications -->
            <div v-if="recentApplications && recentApplications.length > 0" class="divide-y divide-neutral-100 dark:divide-neutral-800">
                <div
                    v-for="app in recentApplications"
                    :key="app.id"
                    class="p-4 hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors"
                >
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-start gap-3 min-w-0">
                            <div class="size-9 rounded-lg bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 flex items-center justify-center shrink-0">
                                <Building2 class="size-4.5 text-neutral-600 dark:text-neutral-300" />
                            </div>
                            <div class="space-y-0.5 min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-semibold text-xs text-neutral-900 dark:text-white">
                                        {{ app.job_title }}
                                    </h3>
                                    <span :class="['inline-flex items-center rounded-md px-2 py-0.5 text-[10px] font-semibold border', getStatusBadge(app.status)]">
                                        {{ formatStatus(app.status) }}
                                    </span>
                                </div>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                    {{ app.company }} • {{ app.department }}
                                </p>
                                <div class="flex items-center gap-2 text-[11px] text-neutral-400 pt-0.5">
                                    <span class="flex items-center gap-1">
                                        <MapPin class="size-3 text-neutral-400" />
                                        {{ app.location }}
                                    </span>
                                    <span>•</span>
                                    <span>Applied on {{ app.applied_at }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 sm:self-center shrink-0">
                            <Link
                                v-if="app.job_id"
                                :href="`/jobs/${app.job_id}`"
                                class="rounded-lg border border-neutral-200 dark:border-neutral-700 px-2.5 py-1 text-xs font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors"
                            >
                                View Job
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Clean, Minimal Empty State -->
            <div v-else class="py-12 px-4 text-center space-y-3">
                <div class="size-10 rounded-full bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center mx-auto text-neutral-400">
                    <Inbox class="size-5" />
                </div>
                <div class="space-y-1">
                    <h3 class="text-xs font-semibold text-neutral-900 dark:text-white">No applications submitted yet</h3>
                </div>
                <div class="pt-1">
                    <Link
                        href="/jobs"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-neutral-300 dark:border-neutral-700 px-3.5 py-1.5 text-xs font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors"
                    >
                        <Search class="size-3.5" />
                        Explore Open Vacancies
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
