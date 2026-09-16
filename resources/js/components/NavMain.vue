<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import type { NavItem } from '@/types';

defineProps<{
    items: NavItem[];
}>();

const { isCurrentUrl } = useCurrentUrl();
const { state } = useSidebar();
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel v-if="state === 'expanded'" class="text-xs uppercase tracking-wider text-muted-foreground/80 font-semibold px-2 mb-1">
            Applicant Portal
        </SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton
                    as-child
                    :is-active="item.href !== '#' && isCurrentUrl(item.href)"
                    :tooltip="item.title"
                    :class="state === 'collapsed' ? 'justify-center px-0' : ''"
                >
                    <Link
                        :href="item.href"
                        :title="item.title"
                        @click="item.href === '#' && $event.preventDefault()"
                        :class="[
                            'flex items-center gap-3 w-full rounded-lg px-2.5 py-2 text-sm font-medium transition-colors',
                            state === 'collapsed' ? 'justify-center px-0' : '',
                            item.href !== '#' && isCurrentUrl(item.href)
                                ? 'bg-neutral-100 text-neutral-900 font-semibold dark:bg-neutral-800 dark:text-white'
                                : 'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100/80 dark:text-neutral-400 dark:hover:text-white dark:hover:bg-neutral-800/80'
                        ]"
                    >
                        <component :is="item.icon" class="size-5 shrink-0" />
                        <span v-if="state === 'expanded'" class="truncate">{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
