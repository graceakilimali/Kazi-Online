<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicNavbar from '@/components/Layout/PublicNavbar.vue';
import PublicFooter from '@/components/Layout/PublicFooter.vue';
import { MapPin, Building2, Clock, Calendar, CheckCircle2, ArrowLeft, ArrowRight, Share2, Briefcase } from '@lucide/vue';
import type { FeaturedJob } from '@/types';

interface JobDetail {
    id: number;
    title: string;
    department: string;
    department_id?: number;
    location: string;
    employmentType: string;
    publishedAt: string;
    deadline: string;
    description: string;
    requirements?: string;
    top_responsibilities?: string[];
    skills_requirements?: string[];
    education_requirements?: string[];
    experience_requirements?: string;
    other_qualifications?: string;
}

const props = defineProps<{
    job: JobDetail;
    relatedJobs: { data: FeaturedJob[] };
}>();
</script>

<template>
    <Head :title="`${job.title} - Kazi Online Portal`" />

    <div class="flex min-h-screen flex-col bg-background text-foreground transition-colors duration-200">
        <PublicNavbar />

        <main class="flex-1">
            <!-- Header Banner -->
            <div
                class="relative border-b border-border bg-slate-950 bg-fixed bg-cover bg-center py-12 sm:py-16 text-white overflow-hidden"
                style="background-image: url('/images/dark-bg.jpg');"
            >
                <!-- Dark gradient overlay for strong text contrast while preserving image depth -->
                <div class="absolute inset-0 bg-gradient-to-b from-slate-950/85 via-slate-950/60 to-slate-950/85 backdrop-blur-[0.5px]"></div>

                <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <Link
                        href="/jobs"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-cyan-400 hover:text-white transition-colors mb-6"
                    >
                        <ArrowLeft class="h-3.5 w-3.5" />
                        <span>Back to All Jobs</span>
                    </Link>

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="rounded-md bg-cyan-500/20 border border-cyan-400/40 px-2.5 py-1 text-xs font-bold text-cyan-300">
                                    {{ job.employmentType }}
                                </span>
                                <span class="text-xs font-medium text-slate-200">
                                    {{ job.department }}
                                </span>
                            </div>
                            <h1 class="mt-3 text-2xl font-extrabold text-white sm:text-3xl lg:text-4xl drop-shadow-[0_2px_12px_rgba(0,0,0,0.9)]">
                                {{ job.title }}
                            </h1>
                            <div class="mt-3 flex flex-wrap items-center gap-y-2 gap-x-6 text-xs text-slate-300">
                                <div class="flex items-center gap-1.5">
                                    <MapPin class="h-4 w-4 text-blue-400" />
                                    <span>{{ job.location }}</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <Calendar class="h-4 w-4 text-blue-400" />
                                    <span>Posted {{ job.publishedAt }}</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <Clock class="h-4 w-4 text-blue-400" />
                                    <span>Deadline: {{ job.deadline }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <Link
                                href="/register"
                                class="inline-flex items-center gap-2 rounded-md bg-[#0066cc] px-6 py-3 text-sm font-bold text-white shadow-sm transition-colors hover:bg-[#0052cc]"
                            >
                                <span>Apply for Job</span>
                                <ArrowRight class="h-4 w-4" />
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Content Body -->
            <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-10 lg:grid-cols-12">
                    <!-- Left Column: Description & Requirements -->
                    <div class="lg:col-span-8 space-y-8">
                        <!-- Description -->
                        <div class="rounded-xl border border-border bg-card p-6 sm:p-8 shadow-xs">
                            <h2 class="text-xl font-bold text-foreground mb-4">Job Description</h2>
                            <div class="prose dark:prose-invert max-w-none text-sm leading-relaxed text-muted-foreground whitespace-pre-line">
                                {{ job.description || 'No specific description provided for this opening.' }}
                            </div>
                        </div>

                        <!-- Responsibilities if available -->
                        <div v-if="job.top_responsibilities && job.top_responsibilities.length > 0" class="rounded-xl border border-border bg-card p-6 sm:p-8 shadow-xs">
                            <h2 class="text-xl font-bold text-foreground mb-4">Key Responsibilities</h2>
                            <ul class="space-y-2.5 text-sm text-muted-foreground">
                                <li v-for="(resp, index) in job.top_responsibilities" :key="index" class="flex items-start gap-2.5">
                                    <CheckCircle2 class="h-4 w-4 text-[#0066cc] shrink-0 mt-0.5" />
                                    <span>{{ resp }}</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Requirements -->
                        <div v-if="job.requirements" class="rounded-xl border border-border bg-card p-6 sm:p-8 shadow-xs">
                            <h2 class="text-xl font-bold text-foreground mb-4">Job Requirements</h2>
                            <div class="prose dark:prose-invert max-w-none text-sm leading-relaxed text-muted-foreground whitespace-pre-line">
                                {{ job.requirements }}
                            </div>
                        </div>

                        <!-- Skills -->
                        <div v-if="job.skills_requirements && job.skills_requirements.length > 0" class="rounded-xl border border-border bg-card p-6 sm:p-8 shadow-xs">
                            <h2 class="text-xl font-bold text-foreground mb-4">Required Skills</h2>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    v-for="(skill, index) in job.skills_requirements"
                                    :key="index"
                                    class="rounded-md bg-muted px-3 py-1.5 text-xs font-semibold text-foreground border border-border"
                                >
                                    {{ skill }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Job Summary & Application Box -->
                    <div class="lg:col-span-4 space-y-6">
                        <!-- Summary Card -->
                        <div class="rounded-xl border border-border bg-card p-6 shadow-xs">
                            <h3 class="text-base font-bold text-foreground border-b border-border pb-3">Job Summary</h3>
                            <div class="mt-4 space-y-4 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="text-muted-foreground">Department:</span>
                                    <span class="font-bold text-foreground">{{ job.department }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-muted-foreground">Employment Type:</span>
                                    <span class="font-bold text-foreground">{{ job.employmentType }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-muted-foreground">Location:</span>
                                    <span class="font-bold text-foreground">{{ job.location }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-muted-foreground">Published Date:</span>
                                    <span class="font-bold text-foreground">{{ job.publishedAt }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-muted-foreground">Application Deadline:</span>
                                    <span class="font-bold text-[#0066cc] dark:text-blue-400">{{ job.deadline }}</span>
                                </div>
                            </div>

                            <div class="mt-6 border-t border-border pt-5">
                                <Link
                                    href="/register"
                                    class="w-full inline-flex items-center justify-center rounded-md bg-[#0066cc] py-3 text-sm font-bold text-white transition-colors hover:bg-[#0052cc]"
                                >
                                    Apply for this Position
                                </Link>
                                <p class="mt-2 text-center text-[11px] text-muted-foreground">
                                    New applicants must create a candidate profile
                                </p>
                            </div>
                        </div>

                        <!-- Company Contact Box -->
                        <div class="rounded-xl border border-border bg-card p-6 shadow-xs">
                            <h3 class="text-base font-bold text-foreground border-b border-border pb-3">Recruitment Office</h3>
                            <div class="mt-4 space-y-3 text-xs text-muted-foreground">
                                <p><strong class="text-foreground">EATV Headquarters:</strong><br />Mikocheni Light Industrial Area<br />P.O. Box 4374 Dar es Salaam, Tanzania</p>
                                <p><strong class="text-foreground">Phone:</strong> +255 22 277 5914/6</p>
                                <p><strong class="text-foreground">Email:</strong> info@eatv.tv</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <PublicFooter />
    </div>
</template>
