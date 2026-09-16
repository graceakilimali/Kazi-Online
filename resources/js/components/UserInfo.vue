<script setup lang="ts">
import { computed } from 'vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/composables/useInitials';
import type { User } from '@/types';

type Props = {
    user: User;
    showEmail?: boolean;
    collapsed?: boolean;
};

const props = withDefaults(defineProps<Props>(), {
    showEmail: false,
    collapsed: false,
});

const { getInitials } = useInitials();

// Compute whether we should show the avatar image
const showAvatar = computed(
    () => props.user.avatar && props.user.avatar !== '',
);
</script>

<template>
    <div class="flex items-center gap-2 overflow-hidden w-full" :class="collapsed ? 'justify-center' : ''">
        <Avatar class="h-8 w-8 shrink-0 overflow-hidden rounded-lg">
            <AvatarImage v-if="showAvatar" :src="user.avatar!" :alt="user.name" />
            <AvatarFallback class="rounded-lg text-black dark:text-white font-medium text-xs">
                {{ getInitials(user.name) }}
            </AvatarFallback>
        </Avatar>

        <div v-if="!collapsed" class="grid flex-1 text-left text-sm leading-tight min-w-0">
            <span class="truncate font-medium">{{ user.name }}</span>
            <span v-if="showEmail" class="text-muted-foreground truncate text-xs">{{
                user.email
            }}</span>
        </div>
    </div>
</template>
