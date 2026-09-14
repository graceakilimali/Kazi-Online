<script setup lang="ts">
import type { DepartmentCategory, HomeStats } from '@/types';
import { useHomeSearch } from '@/composables/useHomeSearch';
import { Search, Building2, Briefcase, Users } from '@lucide/vue';

defineProps<{
    departments: DepartmentCategory[];
    stats: HomeStats;
}>();

const { keyword, departmentId, handleSearch } = useHomeSearch();
</script>

<template>
    <section
        class="relative bg-slate-950 bg-fixed bg-cover bg-center py-20 sm:py-28 text-white overflow-hidden"
        style="background-image: url('/images/dark-bg.jpg');"
    >
        <!-- Dark gradient overlay for high text contrast while keeping background depth visible -->
        <div class="absolute inset-0 bg-gradient-to-b from-slate-950/85 via-slate-950/60 to-slate-950/85 backdrop-blur-[0.5px]"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <!-- Main Heading with strong drop-shadow and vibrant cyan highlight matching logo -->
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl text-white drop-shadow-[0_2px_12px_rgba(0,0,0,0.9)]">
                    Connecting Talent with <span class="text-cyan-400 font-black drop-shadow-[0_0_20px_rgba(34,211,238,0.5)]">Opportunities</span>
                </h1>

                <!-- Subtitle with bright readable white-slate font and shadow -->
                <p class="mt-5 text-base sm:text-lg text-slate-100 font-medium leading-relaxed max-w-2xl mx-auto drop-shadow-[0_2px_6px_rgba(0,0,0,0.9)]">
                    Find the right job that matches your skills and interests from our latest listings across our Companies.
                </p>

                <!-- Search Box -->
                <form @submit.prevent="handleSearch" class="mt-10 rounded-2xl bg-white p-3 shadow-2xl ring-1 ring-black/10 dark:bg-slate-900 dark:ring-white/10">
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-12 sm:items-center">
                        <!-- Keyword Input -->
                        <div class="relative sm:col-span-6">
                            <Search class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                            <input
                                v-model="keyword"
                                type="text"
                                placeholder="Job Title or keyword"
                                class="w-full rounded-xl border-0 bg-slate-50 py-3.5 pl-10 pr-3 text-sm font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0066cc]/30 dark:bg-slate-800 dark:text-white dark:placeholder-slate-500"
                            />
                        </div>

                        <!-- Department Selection -->
                        <div class="relative sm:col-span-4">
                            <Building2 class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                            <select
                                v-model="departmentId"
                                class="w-full rounded-xl border-0 bg-slate-50 py-3.5 pl-10 pr-8 text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0066cc]/30 dark:bg-slate-800 dark:text-white"
                            >
                                <option value="">All Departments</option>
                                <option v-for="dept in departments" :key="dept.id" :value="dept.id">
                                    {{ dept.name }} ({{ dept.openPositionsCount }})
                                </option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="sm:col-span-2">
                            <button
                                type="submit"
                                class="w-full rounded-xl bg-[#0066cc] py-3.5 text-sm font-bold text-white shadow-md transition-all hover:bg-[#0052cc] hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#0066cc]"
                            >
                                Find Job
                            </button>
                        </div>
                    </div>
                </form>

                <!-- High-contrast frosted glass pill for stats -->
                <div class="mt-8 inline-flex flex-wrap items-center justify-center gap-6 sm:gap-8 rounded-full border border-white/15 bg-slate-950/75 backdrop-blur-md px-6 py-2.5 text-xs font-medium text-slate-200 shadow-xl">
                    <div class="flex items-center gap-2">
                        <div class="flex h-6 w-6 items-center justify-center rounded-md bg-cyan-500/20 text-cyan-400">
                            <Briefcase class="h-3.5 w-3.5" />
                        </div>
                        <span><strong class="text-white font-bold text-sm">{{ stats.totalOpenings }}</strong> Live Openings</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <div class="flex h-6 w-6 items-center justify-center rounded-md bg-cyan-500/20 text-cyan-400">
                            <Building2 class="h-3.5 w-3.5" />
                        </div>
                        <span><strong class="text-white font-bold text-sm">{{ stats.totalDepartments }}</strong> Departments</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
