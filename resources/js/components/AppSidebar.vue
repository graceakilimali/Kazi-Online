<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    Calendar,
    ClipboardList,
    FileText,
    LayoutGrid,
    Plus,
    Bell,
} from '@lucide/vue';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    useSidebar,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import type { NavItem } from '@/types';

const { state } = useSidebar();

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'My CV Profile',
        href: '#',
        icon: FileText,
    },
    {
        title: 'New Application',
        href: '#',
        icon: Plus,
    },
    {
        title: 'My Applications',
        href: '#',
        icon: ClipboardList,
    },
    {
        title: 'My Interviews',
        href: '#',
        icon: Calendar,
    },
    {
        title: 'Notifications',
        href: '#',
        icon: Bell,
    },
];

const footerNavItems: NavItem[] = [];
</script>

<template>
    <Sidebar collapsible="icon" variant="sidebar">
        <SidebarHeader class="border-b border-sidebar-border/60">
            <div
                class="flex items-center h-10 px-1"
                :class="state === 'expanded' ? 'justify-start' : 'justify-center'"
            >
                <Link :href="dashboard()" class="flex items-center overflow-hidden">
                    <AppLogo />
                </Link>
            </div>
        </SidebarHeader>

        <SidebarContent class="py-2">
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter class="border-t border-sidebar-border/60">
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
</template>
