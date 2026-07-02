<script setup lang="ts">
import { Moon, Sun } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import { useAppearance } from '@/composables/useAppearance';

const { resolvedAppearance, updateAppearance } = useAppearance();

const toggleTheme = () => {
    updateAppearance(resolvedAppearance.value === 'dark' ? 'light' : 'dark');
};
</script>

<template>
    <Button variant="ghost" size="icon" @click="toggleTheme" class="rounded-full text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100 transition-colors">
        <Sun v-if="resolvedAppearance === 'dark'" class="h-[1.2rem] w-[1.2rem]" />
        <Moon v-else class="h-[1.2rem] w-[1.2rem]" />
        <span class="sr-only">Toggle theme</span>
    </Button>
</template>
