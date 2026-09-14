<script setup lang="ts">
import { DialogClose as SheetClose, type DialogCloseProps as SheetCloseProps } from 'reka-ui';

const props = defineProps<SheetCloseProps>();
</script>

<template>
    <SheetClose v-bind="props">
        <slot />
    </SheetClose>
</template>
