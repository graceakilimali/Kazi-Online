<script setup lang="ts">
import type { FeaturedJob } from '@/types';
import { Link } from '@inertiajs/vue3';
import { ArrowRight, Briefcase } from '@lucide/vue';
import JobCardItem from './JobCardItem.vue';

defineProps<{
    jobs: FeaturedJob[];
}>();
</script>

<template>
    <section class="py-16 sm:py-20 bg-background">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-[#0066cc]">Opportunities</span>
                    <h2 class="mt-2 text-3xl font-bold tracking-tight text-foreground sm:text-4xl">Featured Jobs</h2>
                    <p class="mt-2 text-sm text-muted-foreground">Explore current career openings across our media network.</p>
                </div>

                <Link
                    href="/jobs"
                    class="inline-flex items-center gap-1.5 rounded-md border border-[#0066cc] px-4 py-2 text-sm font-semibold text-[#0066cc] transition-all hover:bg-[#0066cc] hover:text-white"
                >
                    <span>Browse All Jobs</span>
                    <ArrowRight class="h-4 w-4" />
                </Link>
            </div>

            <div v-if="jobs.length > 0" class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <JobCardItem
                    v-for="job in jobs"
                    :key="job.id"
                    :job="job"
                />
            </div>

            <div v-else class="mt-10 rounded-xl border border-dashed border-border p-12 text-center bg-card/50">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-500 dark:bg-slate-800">
                    <Briefcase class="h-6 w-6" />
                </div>
                <h3 class="mt-4 text-base font-bold text-foreground">No active job listings published at the moment</h3>
                <p class="mt-1 text-sm text-muted-foreground">Register your candidate profile to get notified when new positions become available.</p>
                <div class="mt-6">
                    <Link
                        href="/register"
                        class="inline-flex items-center rounded-md bg-[#0066cc] px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#0052cc]"
                    >
                        Register Candidate Profile
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
