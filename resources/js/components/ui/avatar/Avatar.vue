<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';
import { AvatarRoot, type AvatarRootProps } from 'reka-ui';

const props = defineProps<
    AvatarRootProps & { class?: HTMLAttributes['class'] }
>();
</script>

<template>
    <AvatarRoot
        :class="
            cn(
                'relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full',
                props.class,
            )
        "
        v-bind="props"
    >
        <slot />
    </AvatarRoot>
</template>
