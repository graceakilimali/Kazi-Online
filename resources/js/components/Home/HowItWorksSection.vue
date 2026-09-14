<script setup lang="ts">
import { Search, FileText, CheckCircle } from '@lucide/vue';
</script>

<template>
    <section
        class="relative border-b border-border bg-slate-950 bg-fixed bg-cover bg-center py-20 text-white overflow-hidden"
        style="background-image: url('/images/dark-bg.jpg');"
    >
        <!-- Dark gradient overlay for contrast -->
        <div class="absolute inset-0 bg-gradient-to-b from-slate-950/85 via-slate-950/60 to-slate-950/85 backdrop-blur-[0.5px]"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Section Title -->
            <div class="text-center max-w-2xl mx-auto">
                <span class="text-xs font-bold uppercase tracking-widest text-cyan-400">Process</span>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-white sm:text-4xl drop-shadow-[0_2px_8px_rgba(0,0,0,0.8)]">How it works</h2>
                <p class="mt-2 text-sm font-medium text-slate-200">Three straightforward steps to finding and securing your career across our companies.</p>
            </div>

            <!-- Apply Process Grid -->
            <div class="mt-14 grid grid-cols-1 gap-8 md:grid-cols-3">
                <!-- Step 1 -->
                <div class="rounded-2xl border border-white/15 bg-slate-950/80 backdrop-blur-md p-8 text-center shadow-xl transition-all duration-200 hover:border-cyan-400/50 hover:bg-slate-950">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-cyan-500/20 text-cyan-400 shadow-inner">
                        <Search class="h-8 w-8" />
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-white">1. Search a job</h3>
                    <p class="mt-3 text-sm leading-relaxed text-slate-300">
                        Find the right job that matches your skills and interests from our latest listings.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="rounded-2xl border border-white/15 bg-slate-950/80 backdrop-blur-md p-8 text-center shadow-xl transition-all duration-200 hover:border-cyan-400/50 hover:bg-slate-950">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-cyan-500/20 text-cyan-400 shadow-inner">
                        <FileText class="h-8 w-8" />
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-white">2. Apply for job</h3>
                    <p class="mt-3 text-sm leading-relaxed text-slate-300">
                        Submit your application by filling out the online form and uploading your resume.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="rounded-2xl border border-white/15 bg-slate-950/80 backdrop-blur-md p-8 text-center shadow-xl transition-all duration-200 hover:border-cyan-400/50 hover:bg-slate-950">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-cyan-500/20 text-cyan-400 shadow-inner">
                        <CheckCircle class="h-8 w-8" />
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-white">3. Get your job</h3>
                    <p class="mt-3 text-sm leading-relaxed text-slate-300">
                        Wait for approval, attend interviews, and secure your dream job effortlessly.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
