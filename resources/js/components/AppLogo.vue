<script setup lang="ts">
import { useSidebar } from '@/components/ui/sidebar/utils';

let sidebar: ReturnType<typeof useSidebar> | null = null;
try {
    sidebar = useSidebar();
} catch {
    sidebar = null;
}
</script>

<template>
    <div class="flex items-center gap-2 overflow-hidden">
        <div class="flex aspect-square size-8 shrink-0 items-center justify-center rounded-lg overflow-hidden">
            <img src="/images/logo.png?v=4" alt="KaziOnline Logo" class="size-7 object-contain rounded-md" />
        </div>
        <div v-if="!sidebar || sidebar.state.value === 'expanded'" class="grid flex-1 text-left text-sm leading-tight transition-opacity">
            <span class="truncate leading-tight font-semibold">
                Kazi<span class="text-[#0066cc]">Online</span>
            </span>
        </div>
    </div>
</template>
