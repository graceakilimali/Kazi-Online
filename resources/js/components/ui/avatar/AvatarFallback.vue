<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';
import { AvatarFallback, type AvatarFallbackProps } from 'reka-ui';

const props = defineProps<
    AvatarFallbackProps & { class?: HTMLAttributes['class'] }
>();
</script>

<template>
    <AvatarFallback
        v-bind="props"
        :class="
            cn(
                'flex h-full w-full items-center justify-center rounded-full bg-muted font-medium',
                props.class,
            )
        "
    >
        <slot />
    </AvatarFallback>
</template>
