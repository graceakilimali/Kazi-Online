<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import type { DepartmentCategory, FeaturedJob, HomeStats } from '@/types';
import PublicNavbar from '@/components/Layout/PublicNavbar.vue';
import PublicFooter from '@/components/Layout/PublicFooter.vue';
import HeroSection from '@/components/Home/HeroSection.vue';
import CategoryGrid from '@/components/Home/CategoryGrid.vue';
import HowItWorksSection from '@/components/Home/HowItWorksSection.vue';
import FeaturedJobsGrid from '@/components/Home/FeaturedJobsGrid.vue';
import CtaSection from '@/components/Home/CtaSection.vue';

defineProps<{
    featuredJobs: { data: FeaturedJob[] };
    departments: { data: DepartmentCategory[] };
    stats: HomeStats;
}>();
</script>

<template>
    <Head title="Kazi Online Portal - Careers & Opportunities" />

    <div class="flex min-h-screen flex-col bg-background text-foreground transition-colors duration-200">
        <PublicNavbar />

        <main class="flex-1">
            <HeroSection
                :departments="departments.data"
                :stats="stats"
            />

            <CategoryGrid
                v-if="departments.data.length > 0"
                :departments="departments.data"
            />

            <HowItWorksSection />

            <FeaturedJobsGrid
                :jobs="featuredJobs.data"
            />

            <CtaSection />
        </main>

        <PublicFooter />
    </div>
</template>
