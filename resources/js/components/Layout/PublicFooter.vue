<script setup lang="ts">
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { MapPin, Phone, Mail, Send, CheckCircle2 } from '@lucide/vue';

const currentYear = new Date().getFullYear();
const newsletterEmail = ref('');
const isSubscribed = ref(false);

const handleSubscribe = () => {
    if (newsletterEmail.value.trim()) {
        isSubscribed.value = true;
        newsletterEmail.value = '';
        setTimeout(() => {
            isSubscribed.value = false;
        }, 5000);
    }
};
</script>

<template>
    <footer class="border-t border-border bg-[#0b1c39] text-slate-300 dark:bg-slate-950 dark:border-slate-800">
        <div class="mx-auto max-w-7xl px-4 pt-16 pb-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-4">
                <!-- About Us -->
                <div>
                    <h4 class="text-lg font-bold text-white tracking-tight mb-5">About Us</h4>
                    <p class="text-sm leading-relaxed text-slate-300">
                        Bridging the gap between opportunity and talent. Making hiring faster, fairer, and easier.
                    </p>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-bold text-white tracking-tight mb-5">Contact Info</h4>
                    <ul class="space-y-3.5 text-sm text-slate-300">
                        <li class="flex items-start gap-2.5">
                            <MapPin class="h-4 w-4 shrink-0 text-[#0066cc] dark:text-blue-400 mt-0.5" />
                            <div>
                                <p class="text-white font-medium">Address:</p>
                                <p class="text-slate-300">Mikocheni Light Industrial Area<br />P.O. Box 4374 Dar es Salaam, Tanzania</p>
                            </div>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <Phone class="h-4 w-4 shrink-0 text-[#0066cc] dark:text-blue-400" />
                            <div>
                                <a href="tel:+255222775914" class="hover:text-white transition-colors">
                                    Phone: +255 22 277 5914/6
                                </a>
                            </div>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <Mail class="h-4 w-4 shrink-0 text-[#0066cc] dark:text-blue-400" />
                            <div>
                                <a href="mailto:info@eatv.tv" class="hover:text-white transition-colors">
                                    Email: info@eatv.tv
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Important Link -->
                <div>
                    <h4 class="text-lg font-bold text-white tracking-tight mb-5">Important Link</h4>
                    <ul class="space-y-3 text-sm text-slate-300">
                        <li>
                            <Link href="/jobs" class="hover:text-blue-400 transition-colors">
                                Find Jobs
                            </Link>
                        </li>
                        <li>
                            <Link href="/contacts" class="hover:text-blue-400 transition-colors">
                                Contact Us
                            </Link>
                        </li>
                        <li>
                            <Link href="/register" class="hover:text-blue-400 transition-colors">
                                Candidate Registration
                            </Link>
                        </li>
                        <li>
                            <Link href="/login" class="hover:text-blue-400 transition-colors">
                                Applicant Login
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h4 class="text-lg font-bold text-white tracking-tight mb-5">Newsletter</h4>
                    <p class="text-sm leading-relaxed text-slate-300 mb-4">
                        Enter your email below to receive any updates from EATV
                    </p>

                    <form @submit.prevent="handleSubscribe" class="space-y-2">
                        <div class="relative flex items-center">
                            <input
                                v-model="newsletterEmail"
                                type="email"
                                required
                                placeholder="Email Address"
                                class="w-full rounded-md border border-slate-700 bg-slate-900/90 py-3 pl-3.5 pr-12 text-sm text-white placeholder-slate-400 focus:border-[#0066cc] focus:outline-none"
                            />
                            <button
                                type="submit"
                                class="absolute right-1 top-1 bottom-1 flex items-center justify-center rounded bg-[#0066cc] px-3 text-white transition-colors hover:bg-[#0052cc]"
                                aria-label="Subscribe to newsletter"
                            >
                                <Send class="h-4 w-4" />
                            </button>
                        </div>
                        <div v-if="isSubscribed" class="flex items-center gap-1.5 text-xs text-emerald-400 pt-1">
                            <CheckCircle2 class="h-3.5 w-3.5" />
                            <span>Thank you for subscribing!</span>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bottom Copyright Bar -->
            <div class="mt-12 border-t border-slate-800/80 pt-8 text-center text-xs text-slate-400">
                <p>&copy; {{ currentYear }} All rights reserved | Kazi Online Portal</p>
            </div>
        </div>
    </footer>
</template>
