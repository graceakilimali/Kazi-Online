<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';
import { PanelLeft, PanelLeftClose } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import { useSidebar } from './utils';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();

const { toggleSidebar, state, isMobile } = useSidebar();
</script>

<template>
    <Button
        data-sidebar="trigger"
        variant="ghost"
        size="icon"
        :class="cn('h-8 w-8 text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100 dark:text-neutral-300 dark:hover:bg-neutral-800 rounded-lg cursor-pointer transition-colors', props.class)"
        @click="toggleSidebar"
        :title="!isMobile && state === 'collapsed' ? 'Expand sidebar' : 'Collapse sidebar'"
    >
        <PanelLeftClose v-if="!isMobile && state === 'expanded'" class="size-4.5" />
        <PanelLeft v-else class="size-4.5" />
        <span class="sr-only">Toggle Sidebar</span>
    </Button>
</template>
