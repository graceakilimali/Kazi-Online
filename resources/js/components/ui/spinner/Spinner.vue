<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';
import { Loader2 } from '@lucide/vue';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <Loader2 :class="cn('animate-spin text-muted-foreground', props.class)" />
</template>
