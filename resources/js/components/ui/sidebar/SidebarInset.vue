<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <main
        :class="
            cn(
                'relative flex min-h-svh flex-1 min-w-0 flex-col bg-background transition-all duration-200 ease-in-out',
                props.class,
            )
        "
    >
        <slot />
    </main>
</template>
