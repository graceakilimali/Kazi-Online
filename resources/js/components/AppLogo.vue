<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';

const name = usePage().props.name || 'KaziOnline';
</script>

<template>
    <div class="flex aspect-square size-8 items-center justify-center rounded-lg overflow-hidden">
        <img src="/images/logo.png" alt="KaziOnline Logo" class="size-7 object-contain rounded-md" />
    </div>
    <div class="ml-1 grid flex-1 text-left text-sm">
        <span class="mb-0.5 truncate leading-tight font-semibold">
            Kazi<span class="text-[#0066cc]">Online</span>
        </span>
    </div>
</template>
