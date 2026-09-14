<script setup lang="ts">
import type { DepartmentCategory } from '@/types';
import { useHomeSearch } from '@/composables/useHomeSearch';
import { Building2, ChevronRight } from '@lucide/vue';

defineProps<{
    departments: DepartmentCategory[];
}>();

const { selectDepartment } = useHomeSearch();
</script>

<template>
    <section id="categories" class="border-b border-border bg-background py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto">
                <span class="text-xs font-bold uppercase tracking-widest text-[#0066cc]">Categories</span>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-foreground sm:text-4xl">Browse By Department</h2>
                <p class="mt-2 text-sm text-muted-foreground">Select a department to explore active openings tailored to your expertise.</p>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <button
                    v-for="dept in departments"
                    :key="dept.id"
                    @click="selectDepartment(dept.id)"
                    class="group flex flex-col items-center text-center justify-between rounded-xl border border-border bg-card p-6 transition-all duration-200 hover:-translate-y-1 hover:border-[#0066cc] hover:shadow-md focus:outline-none"
                >
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-blue-50 text-[#0066cc] transition-colors group-hover:bg-[#0066cc] group-hover:text-white dark:bg-blue-950/50 dark:text-blue-400">
                        <Building2 class="h-7 w-7" />
                    </div>

                    <div class="mt-4 w-full">
                        <h3 class="font-bold text-base text-foreground transition-colors group-hover:text-[#0066cc]">
                            {{ dept.name }}
                        </h3>
                        <span class="mt-1 inline-block text-xs font-semibold text-muted-foreground group-hover:text-[#0066cc]">
                            ({{ dept.openPositionsCount }} {{ dept.openPositionsCount === 1 ? 'Job' : 'Jobs' }})
                        </span>
                    </div>

                    <div class="mt-4 flex items-center text-xs font-semibold text-[#0066cc]">
                        <span>Browse jobs</span>
                        <ChevronRight class="ml-1 h-3.5 w-3.5 transition-transform group-hover:translate-x-1" />
                    </div>
                </button>
            </div>
        </div>
    </section>
</template>
