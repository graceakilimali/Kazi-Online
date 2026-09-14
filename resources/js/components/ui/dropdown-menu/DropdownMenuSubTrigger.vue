<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';
import { ChevronRight } from '@lucide/vue';
import {
    DropdownMenuSubTrigger,
    type DropdownMenuSubTriggerProps,
    useForwardProps,
} from 'reka-ui';

const props = defineProps<
    DropdownMenuSubTriggerProps & {
        class?: HTMLAttributes['class'];
        inset?: boolean;
    }
>();

const forwarded = useForwardProps(props);
</script>

<template>
    <DropdownMenuSubTrigger
        v-bind="forwarded"
        :class="
            cn(
                'flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none focus:bg-accent data-[state=open]:bg-accent',
                props.inset && 'pl-8',
                props.class,
            )
        "
    >
        <slot />
        <ChevronRight class="ml-auto h-4 w-4" />
    </DropdownMenuSubTrigger>
</template>
