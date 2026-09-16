<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';
import { computed } from 'vue';
import { X } from '@lucide/vue';
import { useSidebar, SIDEBAR_WIDTH, SIDEBAR_WIDTH_ICON } from './utils';

const props = withDefaults(
    defineProps<{
        side?: 'left' | 'right';
        variant?: 'sidebar' | 'floating' | 'inset';
        collapsible?: 'offcanvas' | 'icon' | 'none';
        class?: HTMLAttributes['class'];
    }>(),
    {
        side: 'left',
        variant: 'sidebar',
        collapsible: 'icon',
    },
);

const { isMobile, state, openMobile, setOpenMobile } = useSidebar();

const isCollapsed = computed(() => state.value === 'collapsed');

const desktopWidth = computed(() => {
    if (props.collapsible === 'none') return SIDEBAR_WIDTH;
    if (props.collapsible === 'offcanvas') {
        return isCollapsed.value ? '0px' : SIDEBAR_WIDTH;
    }
    // icon mode: 3.5rem (56px) when collapsed, 16rem (256px) when expanded
    return isCollapsed.value ? '3.5rem' : SIDEBAR_WIDTH;
});
</script>

<template>
    <!-- Desktop Sidebar -->
    <div
        v-if="!isMobile"
        class="group peer text-sidebar-foreground shrink-0 select-none hidden md:block"
        :data-state="state"
        :data-collapsible="isCollapsed ? collapsible : ''"
        :data-variant="variant"
        :data-side="side"
    >
        <!-- Layout Spacer to push main content correctly and prevent overlap -->
        <div
            class="relative h-svh bg-transparent transition-[width] duration-200 ease-in-out shrink-0"
            :style="{ width: desktopWidth }"
        />

        <!-- Fixed Sidebar Content -->
        <div
            :class="
                cn(
                    'fixed inset-y-0 z-20 flex h-svh flex-col border-r border-sidebar-border bg-sidebar transition-[width,left,right] duration-200 ease-in-out',
                    side === 'left' ? 'left-0' : 'right-0',
                    props.class,
                )
            "
            :style="{ width: desktopWidth }"
        >
            <div
                data-sidebar="sidebar"
                class="flex h-full w-full flex-col overflow-hidden"
            >
                <slot />
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Overlay -->
    <div v-else>
        <!-- Backdrop -->
        <div
            v-if="openMobile"
            class="fixed inset-0 z-40 bg-black/50 backdrop-blur-xs transition-opacity duration-200"
            @click="setOpenMobile(false)"
        />

        <!-- Mobile Drawer -->
        <div
            :class="
                cn(
                    'fixed inset-y-0 left-0 z-50 flex h-full w-72 flex-col bg-sidebar shadow-2xl transition-transform duration-200 ease-in-out border-r border-sidebar-border',
                    openMobile ? 'translate-x-0' : '-translate-x-full',
                    props.class,
                )
            "
        >
            <div class="flex items-center justify-between p-3 border-b border-sidebar-border">
                <span class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Menu</span>
                <button
                    @click="setOpenMobile(false)"
                    class="p-1 rounded-md text-neutral-500 hover:text-neutral-900 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors"
                    title="Close"
                >
                    <X class="size-5" />
                </button>
            </div>
            <div class="flex-1 overflow-y-auto">
                <slot />
            </div>
        </div>
    </div>
</template>
