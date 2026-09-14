<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';
import {
    DropdownMenuItem,
    type DropdownMenuItemProps,
    useForwardProps,
} from 'reka-ui';

const props = defineProps<
    DropdownMenuItemProps & {
        class?: HTMLAttributes['class'];
        inset?: boolean;
    }
>();

const forwarded = useForwardProps(props);
</script>

<template>
    <DropdownMenuItem
        v-bind="forwarded"
        :class="
            cn(
                'relative flex cursor-default select-none items-center gap-2 rounded-sm px-2 py-1.5 text-sm outline-none transition-colors focus:bg-accent focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 [&>svg]:size-4 [&>svg]:shrink-0',
                props.inset && 'pl-8',
                props.class,
            )
        "
    >
        <slot />
    </DropdownMenuItem>
</template>
