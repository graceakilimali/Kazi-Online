<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
};

defineProps<Props>();
</script>

<template>
    <img
        src="/images/logo.png?v=4"
        alt="KaziOnline Logo"
        :class="className"
        v-bind="$attrs"
        class="object-contain"
    />
</template>
