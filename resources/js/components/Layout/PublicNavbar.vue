<script setup lang="ts">
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Home as HomeIcon, Search, Mail, Menu, X, User as UserIcon, Building2 } from '@lucide/vue';
import ThemeToggle from '@/components/ThemeToggle.vue';

const isMobileMenuOpen = ref<boolean>(false);
const page = usePage();
const user = page.props.auth?.user;
</script>

<template>
    <header class="sticky top-0 z-50 w-full border-b border-border/80 bg-background/95 backdrop-blur-md shadow-xs">
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <!-- Brand Logo -->
            <Link href="/" class="flex items-center gap-2.5 group">
                <img
                    src="/images/logo.png"
                    alt="KaziOnline Logo"
                    class="h-9 w-9 object-contain rounded-lg transition-transform duration-200 group-hover:scale-105"
                />
                <div class="flex flex-col">
                    <span class="text-xl font-bold tracking-tight text-foreground">
                        Kazi<span class="text-[#0066cc]">Online</span>
                    </span>
                </div>
            </Link>

            <!-- Navigation Links (Home, Find Jobs, Contact) -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-foreground/80">
                <Link
                    href="/"
                    class="flex items-center gap-1.5 transition-colors hover:text-[#0066cc]"
                    :class="{ 'text-[#0066cc] font-bold': $page.url === '/' }"
                >
                    <HomeIcon class="h-4 w-4" />
                    <span>Home</span>
                </Link>

                <Link
                    href="/jobs"
                    class="flex items-center gap-1.5 transition-colors hover:text-[#0066cc]"
                    :class="{ 'text-[#0066cc] font-bold': $page.url.startsWith('/jobs') }"
                >
                    <Search class="h-4 w-4" />
                    <span>Find Jobs</span>
                </Link>

                <Link
                    href="/contacts"
                    class="flex items-center gap-1.5 transition-colors hover:text-[#0066cc]"
                    :class="{ 'text-[#0066cc] font-bold': $page.url.startsWith('/contact') }"
                >
                    <Mail class="h-4 w-4" />
                    <span>Contact</span>
                </Link>
            </nav>

            <!-- Actions (Theme Toggle & Auth Buttons) -->
            <div class="hidden md:flex items-center gap-3">
                <ThemeToggle />
                
                <template v-if="user">
                    <Link
                        href="/dashboard"
                        class="inline-flex items-center gap-2 rounded-lg bg-[#0066cc] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-[#0052cc]"
                    >
                        <UserIcon class="h-4 w-4" />
                        <span>Dashboard</span>
                    </Link>
                </template>
                <template v-else>
                    <Link
                        href="/register"
                        class="inline-flex items-center justify-center rounded-md bg-[#0066cc] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#0052cc]"
                    >
                        Register
                    </Link>
                    <Link
                        href="/login"
                        class="inline-flex items-center justify-center rounded-md border border-[#0066cc] bg-transparent px-5 py-2.5 text-sm font-semibold text-[#0066cc] transition-all hover:bg-[#0066cc] hover:text-white"
                    >
                        Login
                    </Link>
                </template>
            </div>

            <!-- Mobile Controls -->
            <div class="flex items-center gap-2 md:hidden">
                <ThemeToggle />
                <button
                    @click="isMobileMenuOpen = !isMobileMenuOpen"
                    class="rounded-lg p-2 text-foreground hover:bg-muted focus:outline-none"
                    aria-label="Toggle navigation menu"
                >
                    <X v-if="isMobileMenuOpen" class="h-6 w-6" />
                    <Menu v-else class="h-6 w-6" />
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div v-show="isMobileMenuOpen" class="border-b border-border bg-background px-4 py-4 md:hidden">
            <div class="flex flex-col gap-3">
                <Link
                    href="/"
                    class="flex items-center gap-2 rounded-md px-3 py-2.5 text-sm font-medium hover:bg-muted"
                    :class="{ 'text-[#0066cc] font-semibold bg-muted/60': $page.url === '/' }"
                    @click="isMobileMenuOpen = false"
                >
                    <HomeIcon class="h-4 w-4" />
                    <span>Home</span>
                </Link>

                <Link
                    href="/jobs"
                    class="flex items-center gap-2 rounded-md px-3 py-2.5 text-sm font-medium hover:bg-muted"
                    :class="{ 'text-[#0066cc] font-semibold bg-muted/60': $page.url.startsWith('/jobs') }"
                    @click="isMobileMenuOpen = false"
                >
                    <Search class="h-4 w-4" />
                    <span>Find Jobs</span>
                </Link>

                <Link
                    href="/contacts"
                    class="flex items-center gap-2 rounded-md px-3 py-2.5 text-sm font-medium hover:bg-muted"
                    :class="{ 'text-[#0066cc] font-semibold bg-muted/60': $page.url.startsWith('/contact') }"
                    @click="isMobileMenuOpen = false"
                >
                    <Mail class="h-4 w-4" />
                    <span>Contact</span>
                </Link>

                <div class="mt-2 flex flex-col gap-2 border-t border-border pt-3">
                    <template v-if="user">
                        <Link
                            href="/dashboard"
                            class="w-full text-center rounded-md bg-[#0066cc] py-2.5 text-sm font-semibold text-white hover:bg-[#0052cc]"
                            @click="isMobileMenuOpen = false"
                        >
                            Dashboard
                        </Link>
                    </template>
                    <template v-else>
                        <Link
                            href="/register"
                            class="w-full text-center rounded-md bg-[#0066cc] py-2.5 text-sm font-semibold text-white hover:bg-[#0052cc]"
                            @click="isMobileMenuOpen = false"
                        >
                            Register
                        </Link>
                        <Link
                            href="/login"
                            class="w-full text-center rounded-md border border-[#0066cc] py-2.5 text-sm font-semibold text-[#0066cc] hover:bg-[#0066cc] hover:text-white"
                            @click="isMobileMenuOpen = false"
                        >
                            Login
                        </Link>
                    </template>
                </div>
            </div>
        </div>
    </header>
</template>
