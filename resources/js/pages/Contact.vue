<script setup lang="ts">
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import PublicNavbar from '@/components/Layout/PublicNavbar.vue';
import PublicFooter from '@/components/Layout/PublicFooter.vue';
import { Home, Smartphone, Mail, Send, CheckCircle2, AlertCircle } from '@lucide/vue';

const props = defineProps<{
    contactInfo: {
        address: string;
        addressLine1: string;
        addressLine2: string;
        phone: string;
        phoneHours: string;
        email: string;
        emailMessage: string;
    };
    success?: string;
}>();

const form = useForm({
    message: '',
    name: '',
    email: '',
    subject: '',
});

const submitContact = () => {
    form.post('/contacts', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Contact Us - Kazi Online" />

    <div class="flex min-h-screen flex-col bg-background text-foreground transition-colors duration-200">
        <PublicNavbar />

        <main class="flex-1">
            <!-- Hero Banner -->
            <div
                class="relative border-b border-border bg-slate-950 bg-fixed bg-cover bg-center py-16 sm:py-20 text-white text-center overflow-hidden"
                style="background-image: url('/images/dark-bg.jpg');"
            >
                <!-- Dark gradient overlay for strong text contrast while preserving image depth -->
                <div class="absolute inset-0 bg-gradient-to-b from-slate-950/85 via-slate-950/60 to-slate-950/85 backdrop-blur-[0.5px]"></div>

                <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <span class="text-xs font-bold uppercase tracking-widest text-cyan-400">Support & Inquiries</span>
                    <h1 class="mt-2 text-3xl font-extrabold sm:text-4xl lg:text-5xl text-white drop-shadow-[0_2px_12px_rgba(0,0,0,0.9)]">
                        Contact us
                    </h1>
                    <p class="mt-3 text-base font-medium text-slate-100 max-w-xl mx-auto drop-shadow-[0_2px_6px_rgba(0,0,0,0.9)]">
                        Get in touch with the talent acquisition and recruitment department
                    </p>
                </div>
            </div>

            <!-- Interactive Map / Location Overview -->
            <div class="border-b border-border bg-slate-100 dark:bg-slate-900">
                <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                    <div class="overflow-hidden rounded-xl border border-border bg-card shadow-xs">
                        <iframe
                            title="EATV Location Map"
                            width="100%"
                            height="380"
                            style="border:0;"
                            loading="lazy"
                            allowfullscreen
                            src="https://www.openstreetmap.org/export/embed.html?bbox=39.225%2C-6.775%2C39.245%2C-6.760&amp;layer=mapnik&amp;marker=-6.76731%2C39.23397"
                        ></iframe>
                    </div>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                <!-- Success Alert -->
                <div v-if="$page.props.flash?.success || success" class="mb-8 rounded-lg border border-emerald-500/30 bg-emerald-50 p-4 text-sm text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-300">
                    <div class="flex items-center gap-2">
                        <CheckCircle2 class="h-5 w-5 text-emerald-600 dark:text-emerald-400" />
                        <span>{{ $page.props.flash?.success || success }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-12 lg:grid-cols-12">
                    <!-- Left: Get in Touch Form -->
                    <div class="lg:col-span-8">
                        <h2 class="text-2xl font-bold tracking-tight text-foreground sm:text-3xl">Get in Touch</h2>
                        <p class="mt-1 text-sm text-muted-foreground">Fill out the form below with your inquiry and our HR desk will get back to you.</p>

                        <form @submit.prevent="submitContact" class="mt-8 space-y-4">
                            <!-- Message -->
                            <div>
                                <textarea
                                    v-model="form.message"
                                    rows="6"
                                    required
                                    placeholder="Enter Message"
                                    class="w-full rounded-md border border-input bg-background p-3.5 text-sm placeholder-muted-foreground focus:border-[#0066cc] focus:outline-none focus:ring-1 focus:ring-[#0066cc]"
                                ></textarea>
                                <p v-if="form.errors.message" class="mt-1 text-xs text-rose-600">{{ form.errors.message }}</p>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <!-- Name -->
                                <div>
                                    <input
                                        v-model="form.name"
                                        type="text"
                                        required
                                        placeholder="Enter your name"
                                        class="w-full rounded-md border border-input bg-background py-2.5 px-3.5 text-sm placeholder-muted-foreground focus:border-[#0066cc] focus:outline-none focus:ring-1 focus:ring-[#0066cc]"
                                    />
                                    <p v-if="form.errors.name" class="mt-1 text-xs text-rose-600">{{ form.errors.name }}</p>
                                </div>

                                <!-- Email -->
                                <div>
                                    <input
                                        v-model="form.email"
                                        type="email"
                                        required
                                        placeholder="Enter email address"
                                        class="w-full rounded-md border border-input bg-background py-2.5 px-3.5 text-sm placeholder-muted-foreground focus:border-[#0066cc] focus:outline-none focus:ring-1 focus:ring-[#0066cc]"
                                    />
                                    <p v-if="form.errors.email" class="mt-1 text-xs text-rose-600">{{ form.errors.email }}</p>
                                </div>
                            </div>

                            <!-- Subject -->
                            <div>
                                <input
                                    v-model="form.subject"
                                    type="text"
                                    required
                                    placeholder="Enter Subject"
                                    class="w-full rounded-md border border-input bg-background py-2.5 px-3.5 text-sm placeholder-muted-foreground focus:border-[#0066cc] focus:outline-none focus:ring-1 focus:ring-[#0066cc]"
                                />
                                <p v-if="form.errors.subject" class="mt-1 text-xs text-rose-600">{{ form.errors.subject }}</p>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-2">
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="inline-flex items-center justify-center gap-2 rounded-md bg-[#0066cc] px-8 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#0052cc] disabled:opacity-50"
                                >
                                    <Send class="h-4 w-4" />
                                    <span>Send</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right: Contact Information -->
                    <div class="lg:col-span-4 space-y-6">
                        <div class="rounded-xl border border-border bg-card p-6 shadow-xs space-y-6">
                            <!-- Address -->
                            <div class="flex items-start gap-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-[#0066cc] dark:bg-blue-950/50 dark:text-blue-400">
                                    <Home class="h-5 w-5" />
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-foreground">{{ contactInfo.addressLine1 }}</h3>
                                    <p class="mt-1 text-xs text-muted-foreground leading-relaxed">{{ contactInfo.addressLine2 }}</p>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="flex items-start gap-4 border-t border-border pt-5">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-[#0066cc] dark:bg-blue-950/50 dark:text-blue-400">
                                    <Smartphone class="h-5 w-5" />
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-foreground">{{ contactInfo.phone }}</h3>
                                    <p class="mt-1 text-xs text-muted-foreground">{{ contactInfo.phoneHours }}</p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="flex items-start gap-4 border-t border-border pt-5">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-[#0066cc] dark:bg-blue-950/50 dark:text-blue-400">
                                    <Mail class="h-5 w-5" />
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-foreground">{{ contactInfo.email }}</h3>
                                    <p class="mt-1 text-xs text-muted-foreground">{{ contactInfo.emailMessage }}</p>
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
