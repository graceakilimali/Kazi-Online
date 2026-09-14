<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';
import {
    DropdownMenuLabel,
    type DropdownMenuLabelProps,
    useForwardProps,
} from 'reka-ui';

const props = defineProps<
    DropdownMenuLabelProps & {
        class?: HTMLAttributes['class'];
        inset?: boolean;
    }
>();

const forwarded = useForwardProps(props);
</script>

<template>
    <DropdownMenuLabel
        v-bind="forwarded"
        :class="
            cn(
                'px-2 py-1.5 text-sm font-semibold',
                props.inset && 'pl-8',
                props.class,
            )
        "
    >
        <slot />
    </DropdownMenuLabel>
</template>
