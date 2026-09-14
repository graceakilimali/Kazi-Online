<script setup lang="ts">
import {
    DialogRoot as SheetRoot,
    type DialogRootEmits as SheetRootEmits,
    type DialogRootProps as SheetRootProps,
    useForwardPropsEmits,
} from 'reka-ui';

const props = defineProps<SheetRootProps>();
const emits = defineEmits<SheetRootEmits>();

const forwarded = useForwardPropsEmits(props, emits);
</script>

<template>
    <SheetRoot v-bind="forwarded">
        <slot />
    </SheetRoot>
</template>
