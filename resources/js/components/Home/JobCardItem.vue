<script setup lang="ts">
import type { FeaturedJob } from '@/types';
import { Link } from '@inertiajs/vue3';
import { MapPin, Clock, ArrowRight, Building2, Briefcase } from '@lucide/vue';

defineProps<{
    job: FeaturedJob;
}>();
</script>

<template>
    <div class="group flex flex-col justify-between rounded-xl border border-border bg-card p-6 shadow-xs transition-all duration-200 hover:-translate-y-1 hover:border-[#0066cc]/60 hover:shadow-md">
        <div>
            <!-- Header: Company Name & Employment Type -->
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-2 min-w-0">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-[#0066cc] dark:bg-blue-950/50 dark:text-blue-400">
                        <Building2 class="h-4 w-4" />
                    </div>
                    <div class="min-w-0">
                        <p class="truncate text-xs font-bold text-foreground" :title="job.company">
                            {{ job.company || 'EATV Group' }}
                        </p>
                        <p class="truncate text-[11px] font-medium text-muted-foreground">
                            {{ job.department }}
                        </p>
                    </div>
                </div>
                <span class="inline-flex shrink-0 items-center rounded-md border border-blue-500/30 bg-blue-50 px-2.5 py-1 text-xs font-semibold text-[#0066cc] dark:bg-blue-950/40 dark:text-blue-300">
                    {{ job.employmentType }}
                </span>
            </div>

            <!-- Job Title -->
            <h3 class="mt-4 text-lg font-bold text-foreground transition-colors group-hover:text-[#0066cc]">
                <Link :href="`/jobs/${job.id}`">
                    {{ job.title }}
                </Link>
            </h3>

            <!-- Details metadata -->
            <div class="mt-3 flex flex-wrap items-center gap-y-2 gap-x-4 text-xs text-muted-foreground">
                <div class="flex items-center gap-1.5">
                    <MapPin class="h-3.5 w-3.5 text-slate-400" />
                    <span>{{ job.location }}</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <Clock class="h-3.5 w-3.5 text-slate-400" />
                    <span>Deadline: {{ job.deadline }}</span>
                </div>
            </div>
        </div>

        <!-- Footer Action -->
        <div class="mt-6 flex items-center justify-between border-t border-border pt-4 text-xs">
            <span class="text-muted-foreground">Posted {{ job.publishedAt }}</span>
            <Link
                :href="`/jobs/${job.id}`"
                class="inline-flex items-center gap-1 font-semibold text-[#0066cc] hover:text-[#0052cc]"
            >
                <span>View Details</span>
                <ArrowRight class="h-3.5 w-3.5 transition-transform group-hover:translate-x-1" />
            </Link>
        </div>
    </div>
</template>
