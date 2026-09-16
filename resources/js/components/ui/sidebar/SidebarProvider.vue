<script setup lang="ts">
import type { HTMLAttributes, Ref } from 'vue';
import { cn } from '@/lib/utils';
import { useMediaQuery, useVModel } from '@vueuse/core';
import { computed, ref } from 'vue';
import {
    provideSidebarContext,
    SIDEBAR_COOKIE_MAX_AGE,
    SIDEBAR_COOKIE_NAME,
    SIDEBAR_WIDTH,
    SIDEBAR_WIDTH_ICON,
} from './utils';

const props = withDefaults(
    defineProps<{
        defaultOpen?: boolean;
        open?: boolean;
        class?: HTMLAttributes['class'];
    }>(),
    {
        defaultOpen: true,
        open: undefined,
    },
);

const emits = defineEmits<{
    (e: 'update:open', open: boolean): void;
}>();

const isMobile = useMediaQuery('(max-width: 768px)');
const openMobile = ref(false);

const getInitialOpen = () => {
    if (typeof document !== 'undefined') {
        const match = document.cookie.match(new RegExp(`(?:^|; )${SIDEBAR_COOKIE_NAME}=([^;]*)`));
        if (match) {
            return match[1] === 'true';
        }
    }
    return props.defaultOpen;
};

const open = useVModel(props, 'open', emits, {
    defaultValue: getInitialOpen(),
    passive: (props.open === undefined) as false,
}) as Ref<boolean>;

function setOpen(value: boolean) {
    open.value = value;
    document.cookie = `${SIDEBAR_COOKIE_NAME}=${value}; path=/; max-age=${SIDEBAR_COOKIE_MAX_AGE}`;
}

function setOpenMobile(value: boolean) {
    openMobile.value = value;
}

function toggleSidebar() {
    return isMobile.value
        ? setOpenMobile(!openMobile.value)
        : setOpen(!open.value);
}

const state = computed(() => (open.value ? 'expanded' : 'collapsed'));

provideSidebarContext({
    state,
    open,
    setOpen,
    isMobile,
    openMobile,
    setOpenMobile,
    toggleSidebar,
});
</script>

<template>
    <div
        :style="{
            '--sidebar-width': SIDEBAR_WIDTH,
            '--sidebar-width-icon': SIDEBAR_WIDTH_ICON,
        }"
        :class="
            cn(
                'group/sidebar-wrapper flex min-h-svh w-full has-[[data-variant=inset]]:bg-sidebar',
                props.class,
            )
        "
    >
        <slot />
    </div>
</template>
