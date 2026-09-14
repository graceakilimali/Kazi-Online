<script setup lang="ts">
import { useAppearance } from '@/composables/useAppearance';
import { Sun, Moon, Laptop } from '@lucide/vue';

const { appearance, updateAppearance } = useAppearance();

const toggleTheme = () => {
    if (appearance.value === 'light') {
        updateAppearance('dark');
    } else if (appearance.value === 'dark') {
        updateAppearance('system');
    } else {
        updateAppearance('light');
    }
};
</script>

<template>
    <button
        @click="toggleTheme"
        type="button"
        class="relative inline-flex h-9 w-9 items-center justify-center rounded-lg border border-border bg-card text-foreground shadow-sm transition hover:bg-muted focus:outline-none focus:ring-2 focus:ring-primary/20"
        :title="`Current theme: ${appearance}. Click to switch.`"
        aria-label="Toggle theme"
    >
        <Sun v-if="appearance === 'light'" class="h-4 w-4 text-amber-500 transition-transform" />
        <Moon v-else-if="appearance === 'dark'" class="h-4 w-4 text-blue-400 transition-transform" />
        <Laptop v-else class="h-4 w-4 text-muted-foreground transition-transform" />
    </button>
</template>
