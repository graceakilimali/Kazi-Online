<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';
import {
    DialogDescription as SheetDescription,
    type DialogDescriptionProps as SheetDescriptionProps,
    useForwardProps,
} from 'reka-ui';

const props = defineProps<
    SheetDescriptionProps & { class?: HTMLAttributes['class'] }
>();
const forwarded = useForwardProps(props);
</script>

<template>
    <SheetDescription
        v-bind="forwarded"
        :class="cn('text-sm text-muted-foreground', props.class)"
    >
        <slot />
    </SheetDescription>
</template>
