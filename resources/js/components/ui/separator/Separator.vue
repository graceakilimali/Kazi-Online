<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';
import { Separator, type SeparatorProps } from 'reka-ui';

const props = withDefaults(
    defineProps<SeparatorProps & { class?: HTMLAttributes['class'] }>(),
    {
        orientation: 'horizontal',
        decorative: true,
    },
);
</script>

<template>
    <Separator
        v-bind="props"
        :class="
            cn(
                'shrink-0 bg-border',
                props.orientation === 'horizontal' ? 'h-[1px] w-full' : 'h-full w-[1px]',
                props.class,
            )
        "
    />
</template>
