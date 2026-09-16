<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicNavbar from '@/components/Layout/PublicNavbar.vue';
import PublicFooter from '@/components/Layout/PublicFooter.vue';
import {
    MapPin,
    Building2,
    Clock,
    Calendar,
    CheckCircle2,
    ArrowLeft,
    ArrowRight,
    Briefcase,
    GraduationCap,
    Award,
    FileText,
    Download,
    ExternalLink,
    Star,
    FolderTree,
    Phone,
    Mail,
    Info,
} from '@lucide/vue';
import type { FeaturedJob } from '@/types';

interface JobDetail extends FeaturedJob {}

const props = defineProps<{
    job: JobDetail;
    relatedJobs: { data: FeaturedJob[] };
}>();
</script>

<template>
    <Head :title="`${job.title} - ${job.company || 'Kazi Online'}`" />

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
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-md bg-cyan-500/20 border border-cyan-400/40 px-2.5 py-1 text-xs font-bold text-cyan-300">
                                    {{ job.employmentType }}
                                </span>
                                <span class="rounded-md bg-blue-500/20 border border-blue-400/30 px-2.5 py-1 text-xs font-semibold text-blue-200">
                                    {{ job.company || 'EATV Group' }}
                                </span>
                                <span class="text-xs font-medium text-slate-300">
                                    {{ job.department }}
                                </span>
                            </div>
                            <h1 class="mt-3 text-2xl font-extrabold text-white sm:text-3xl lg:text-4xl drop-shadow-[0_2px_12px_rgba(0,0,0,0.9)]">
                                {{ job.title }}
                            </h1>
                            <div class="mt-3 flex flex-wrap items-center gap-y-2 gap-x-6 text-xs text-slate-300">
                                <div class="flex items-center gap-1.5">
                                    <Building2 class="h-4 w-4 text-cyan-400" />
                                    <span>{{ job.company || 'EATV Group' }}</span>
                                </div>
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
                    <!-- Left Column: Details -->
                    <div class="lg:col-span-8 space-y-8">
                        <!-- Job Description -->
                        <div class="rounded-xl border border-border bg-card p-6 sm:p-8 shadow-xs">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-[#0066cc] dark:bg-blue-950/50 dark:text-blue-400">
                                    <Briefcase class="h-4 w-4" />
                                </div>
                                <h2 class="text-xl font-bold text-foreground">Job Description</h2>
                            </div>
                            <div class="prose dark:prose-invert max-w-none text-sm leading-relaxed text-muted-foreground whitespace-pre-line">
                                {{ job.description || 'No specific description provided for this opening.' }}
                            </div>
                        </div>

                        <!-- Key Responsibilities -->
                        <div v-if="job.top_responsibilities && job.top_responsibilities.length > 0" class="rounded-xl border border-border bg-card p-6 sm:p-8 shadow-xs">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400">
                                    <CheckCircle2 class="h-4 w-4" />
                                </div>
                                <h2 class="text-xl font-bold text-foreground">Key Responsibilities</h2>
                            </div>
                            <ul class="space-y-3 text-sm text-muted-foreground">
                                <li v-for="(resp, index) in job.top_responsibilities" :key="index" class="flex items-start gap-3">
                                    <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-100 text-[11px] font-bold text-[#0066cc] dark:bg-blue-950 dark:text-blue-300 mt-0.5">
                                        {{ index + 1 }}
                                    </span>
                                    <span class="leading-relaxed">{{ resp }}</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Key Skills & Competencies -->
                        <div v-if="job.skills_requirements && job.skills_requirements.length > 0" class="rounded-xl border border-border bg-card p-6 sm:p-8 shadow-xs">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-950/50 dark:text-amber-400">
                                    <Star class="h-4 w-4" />
                                </div>
                                <h2 class="text-xl font-bold text-foreground">Key Skills & Competencies</h2>
                            </div>
                            <div class="flex flex-wrap gap-2.5">
                                <span
                                    v-for="(skill, index) in job.skills_requirements"
                                    :key="index"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-muted px-3.5 py-1.5 text-xs font-semibold text-foreground border border-border transition-colors hover:border-[#0066cc]/40"
                                >
                                    <span class="h-1.5 w-1.5 rounded-full bg-[#0066cc]"></span>
                                    {{ skill }}
                                </span>
                            </div>
                        </div>

                        <!-- Education Requirements -->
                        <div v-if="job.education_requirements && job.education_requirements.length > 0" class="rounded-xl border border-border bg-card p-6 sm:p-8 shadow-xs">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-950/50 dark:text-indigo-400">
                                    <GraduationCap class="h-4 w-4" />
                                </div>
                                <h2 class="text-xl font-bold text-foreground">Education Requirements</h2>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div
                                    v-for="(edu, index) in job.education_requirements"
                                    :key="index"
                                    class="flex items-center gap-3 rounded-lg border border-border bg-muted/40 p-3.5 text-sm font-medium text-foreground"
                                >
                                    <GraduationCap class="h-4 w-4 text-[#0066cc] shrink-0" />
                                    <span>{{ edu }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Experience & Other Qualifications -->
                        <div v-if="job.experience_requirements || job.other_qualifications" class="rounded-xl border border-border bg-card p-6 sm:p-8 shadow-xs">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-50 text-purple-600 dark:bg-purple-950/50 dark:text-purple-400">
                                    <Award class="h-4 w-4" />
                                </div>
                                <h2 class="text-xl font-bold text-foreground">Experience & Qualifications</h2>
                            </div>
                            <div class="space-y-4 text-sm text-muted-foreground">
                                <div v-if="job.experience_requirements">
                                    <h4 class="font-bold text-foreground text-xs uppercase tracking-wider mb-1">Experience Required</h4>
                                    <p class="leading-relaxed">{{ job.experience_requirements }}</p>
                                </div>
                                <div v-if="job.other_qualifications" class="border-t border-border pt-4">
                                    <h4 class="font-bold text-foreground text-xs uppercase tracking-wider mb-1">Other Qualifications & Certifications</h4>
                                    <p class="leading-relaxed">{{ job.other_qualifications }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- General Requirements (if distinct from education) -->
                        <div v-if="job.requirements" class="rounded-xl border border-border bg-card p-6 sm:p-8 shadow-xs">
                            <h2 class="text-xl font-bold text-foreground mb-4">General Requirements</h2>
                            <div class="prose dark:prose-invert max-w-none text-sm leading-relaxed text-muted-foreground whitespace-pre-line">
                                {{ job.requirements }}
                            </div>
                        </div>

                        <!-- Job Description (JD) Attached Document -->
                        <div v-if="job.jd_file_url" class="rounded-xl border border-blue-500/30 bg-blue-50/50 dark:bg-blue-950/20 p-6 sm:p-8 shadow-xs">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div class="flex items-start gap-3.5">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#0066cc] text-white">
                                        <FileText class="h-5 w-5" />
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-foreground">Official Job Description (JD)</h3>
                                        <p class="text-xs text-muted-foreground mt-0.5">
                                            {{ job.jd_file_name || 'Job_Description.pdf' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2.5 shrink-0">
                                    <a
                                        :href="job.jd_file_url"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-border bg-card px-3.5 py-2 text-xs font-semibold text-foreground shadow-xs transition-colors hover:bg-muted"
                                    >
                                        <ExternalLink class="h-3.5 w-3.5" />
                                        <span>View Document</span>
                                    </a>
                                    <a
                                        :href="`${job.jd_file_url}?download=1`"
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-[#0066cc] px-3.5 py-2 text-xs font-semibold text-white shadow-xs transition-colors hover:bg-[#0052cc]"
                                    >
                                        <Download class="h-3.5 w-3.5" />
                                        <span>Download</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Job Summary & Company Box -->
                    <div class="lg:col-span-4 space-y-6">
                        <!-- Summary Card -->
                        <div class="rounded-xl border border-border bg-card p-6 shadow-xs">
                            <div class="flex items-center gap-2 border-b border-border pb-3">
                                <Info class="h-4 w-4 text-[#0066cc]" />
                                <h3 class="text-base font-bold text-foreground">Job Overview</h3>
                            </div>
                            <div class="mt-4 space-y-4 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-1.5 text-muted-foreground">
                                        <Building2 class="h-3.5 w-3.5 text-slate-400" />
                                        <span>Company:</span>
                                    </span>
                                    <span class="font-bold text-foreground text-right">{{ job.company || 'EATV Group' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-1.5 text-muted-foreground">
                                        <FolderTree class="h-3.5 w-3.5 text-slate-400" />
                                        <span>Department:</span>
                                    </span>
                                    <span class="font-bold text-foreground">{{ job.department }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-1.5 text-muted-foreground">
                                        <Briefcase class="h-3.5 w-3.5 text-slate-400" />
                                        <span>Employment Type:</span>
                                    </span>
                                    <span class="font-bold text-foreground">{{ job.employmentType }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-1.5 text-muted-foreground">
                                        <MapPin class="h-3.5 w-3.5 text-slate-400" />
                                        <span>Location:</span>
                                    </span>
                                    <span class="font-bold text-foreground">{{ job.location }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-1.5 text-muted-foreground">
                                        <Calendar class="h-3.5 w-3.5 text-slate-400" />
                                        <span>Published Date:</span>
                                    </span>
                                    <span class="font-bold text-foreground">{{ job.publishedAt }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-1.5 text-muted-foreground">
                                        <Clock class="h-3.5 w-3.5 text-slate-400" />
                                        <span>Application Deadline:</span>
                                    </span>
                                    <span class="font-bold text-[#0066cc] dark:text-blue-400">{{ job.deadline }}</span>
                                </div>
                            </div>

                            <div class="mt-6 border-t border-border pt-5">
                                <Link
                                    href="/register"
                                    class="w-full inline-flex items-center justify-center gap-2 rounded-md bg-[#0066cc] py-3 text-sm font-bold text-white transition-colors hover:bg-[#0052cc]"
                                >
                                    <span>Apply for this Position</span>
                                    <ArrowRight class="h-4 w-4" />
                                </Link>
                                <p class="mt-2 text-center text-[11px] text-muted-foreground">
                                    New applicants must create a candidate profile
                                </p>
                            </div>
                        </div>

                        <!-- Hiring Company Box -->
                        <div class="rounded-xl border border-border bg-card p-6 shadow-xs">
                            <div class="flex items-center gap-2 border-b border-border pb-3">
                                <Building2 class="h-4 w-4 text-[#0066cc]" />
                                <h3 class="text-base font-bold text-foreground">About the Company</h3>
                            </div>
                            <div class="mt-4 space-y-3.5 text-xs text-muted-foreground">
                                <div class="text-foreground font-bold text-sm">
                                    {{ job.company || 'East Africa Television Ltd (EATV)' }}
                                </div>
                                <div class="flex items-start gap-2">
                                    <MapPin class="h-4 w-4 text-[#0066cc] shrink-0 mt-0.5" />
                                    <p class="leading-relaxed">
                                        Mikocheni Light Industrial Area<br />
                                        P.O. Box 4374 Dar es Salaam, Tanzania
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <Phone class="h-4 w-4 text-[#0066cc] shrink-0" />
                                    <span>+255 22 277 5914/6</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <Mail class="h-4 w-4 text-[#0066cc] shrink-0" />
                                    <span>info@eatv.tv</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <PublicFooter />
    </div>
</template>
