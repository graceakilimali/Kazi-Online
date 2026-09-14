<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';
import {
    NavigationMenuList,
    type NavigationMenuListProps,
    useForwardProps,
} from 'reka-ui';

const props = defineProps<
    NavigationMenuListProps & { class?: HTMLAttributes['class'] }
>();
const forwarded = useForwardProps(props);
</script>

<template>
    <NavigationMenuList
        v-bind="forwarded"
        :class="
            cn(
                'group flex flex-1 list-none items-center justify-center space-x-1',
                props.class,
            )
        "
    >
        <slot />
    </NavigationMenuList>
</template>
