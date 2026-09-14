<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { UserCheck, ArrowRight } from '@lucide/vue';
</script>

<template>
    <section
        id="cta-talent-pool"
        class="relative border-t border-border bg-slate-950 bg-fixed bg-cover bg-center py-16 text-white sm:py-20 overflow-hidden"
        style="background-image: url('/images/dark-bg.jpg');"
    >
        <!-- Dark gradient overlay for contrast -->
        <div class="absolute inset-0 bg-gradient-to-b from-slate-950/85 via-slate-950/60 to-slate-950/85 backdrop-blur-[0.5px]"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <span class="text-xs font-bold uppercase tracking-widest text-cyan-400">Join Our Network</span>

                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-white sm:text-4xl drop-shadow-[0_2px_8px_rgba(0,0,0,0.8)]">
                    Register into the Kazi Online Talent Pool
                </h2>

                <p class="mt-4 text-base text-slate-200 font-medium leading-relaxed drop-shadow-[0_1px_4px_rgba(0,0,0,0.8)]">
                    Submit your profile with your resume, skills, and qualifications. Our recruitment team reviews the candidate pool whenever new positions open up.
                </p>

                <div class="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <Link
                        href="/register"
                        class="inline-flex items-center gap-2 rounded-xl bg-[#0066cc] px-7 py-3.5 text-sm font-bold text-white shadow-lg transition-all hover:bg-[#0052cc] hover:shadow-xl"
                    >
                        <UserCheck class="h-4 w-4" />
                        <span>Register Profile</span>
                        <ArrowRight class="h-4 w-4" />
                    </Link>
                    <Link
                        href="/login"
                        class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-slate-900/90 backdrop-blur-md px-7 py-3.5 text-sm font-semibold text-white transition-all hover:bg-slate-800 hover:border-white/40"
                    >
                        <span>Existing Applicant? Login</span>
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
