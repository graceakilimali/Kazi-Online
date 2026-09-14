<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';
import {
    NavigationMenuRoot,
    type NavigationMenuRootEmits,
    type NavigationMenuRootProps,
    useForwardPropsEmits,
} from 'reka-ui';
import NavigationMenuViewport from './NavigationMenuViewport.vue';

const props = withDefaults(
    defineProps<
        NavigationMenuRootProps & { class?: HTMLAttributes['class'] }
    >(),
    {
        modelValue: '',
    },
);
const emits = defineEmits<NavigationMenuRootEmits>();

const forwarded = useForwardPropsEmits(props, emits);
</script>

<template>
    <NavigationMenuRoot
        v-bind="forwarded"
        :class="
            cn(
                'relative z-10 flex max-w-max flex-1 items-center justify-center',
                props.class,
            )
        "
    >
        <slot />
        <NavigationMenuViewport />
    </NavigationMenuRoot>
</template>
