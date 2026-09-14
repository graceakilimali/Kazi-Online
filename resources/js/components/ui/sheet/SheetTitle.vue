<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';
import { DialogTitle as SheetTitle, type DialogTitleProps as SheetTitleProps, useForwardProps } from 'reka-ui';

const props = defineProps<
    SheetTitleProps & { class?: HTMLAttributes['class'] }
>();
const forwarded = useForwardProps(props);
</script>

<template>
    <SheetTitle
        v-bind="forwarded"
        :class="
            cn(
                'text-lg font-semibold text-foreground',
                props.class,
            )
        "
    >
        <slot />
    </SheetTitle>
</template>
