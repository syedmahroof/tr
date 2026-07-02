<script setup lang="ts">
import { usePage, router, Link } from '@inertiajs/vue3';
import { Search, ArrowLeft, Bell, BellRing, Check, CheckCheck } from '@lucide/vue';
import { computed, ref } from 'vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import ThemeToggle from '@/components/ThemeToggle.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { SidebarTrigger } from '@/components/ui/sidebar';
import UserMenuContent from '@/components/UserMenuContent.vue';
import { getInitials } from '@/composables/useInitials';
import type { BreadcrumbItem } from '@/types';

withDefaults(
    defineProps<{
        breadcrumbs?: BreadcrumbItem[];
    }>(),
    {
        breadcrumbs: () => [],
    },
);

const page = usePage();
const auth = computed(() => page.props.auth);
const notifications = computed(() => page.props.notifications || []);

const searchQuery = ref('');

const submitSearch = () => {
    if (searchQuery.value.trim()) {
        router.get('/admin/search', { q: searchQuery.value }, { preserveState: true });
    }
};

const goBack = () => {
    window.history.back();
};

const markAsRead = (id: string) => {
    router.post(`/admin/notifications/${id}/mark-read`, {}, { preserveScroll: true });
};

const markAllAsRead = () => {
    router.post('/admin/notifications/mark-all-read', {}, { preserveScroll: true });
};
</script>

<template>
    <header
        class="flex justify-between h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4"
    >
        <div class="flex items-center gap-2">
            <SidebarTrigger class="-ml-1" />
            <Button variant="ghost" size="icon" @click="goBack" class="h-8 w-8 text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100 rounded-full" title="Go Back">
                <ArrowLeft class="h-4 w-4" />
            </Button>
            <template v-if="breadcrumbs && breadcrumbs.length > 0">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </template>
        </div>

        <div class="flex items-center gap-2">
            <form @submit.prevent="submitSearch" class="relative hidden sm:block mr-2 group">
                <Search class="absolute left-2.5 top-2.5 h-4 w-4 text-zinc-400 group-focus-within:text-indigo-500 transition-colors" />
                <Input 
                    v-model="searchQuery" 
                    type="search" 
                    placeholder="Search..." 
                    class="w-32 focus:w-64 transition-all duration-300 pl-9 bg-zinc-100/50 dark:bg-zinc-800/50 border-transparent focus:border-zinc-200 dark:focus:border-zinc-700 h-9 rounded-full" 
                />
            </form>
            
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <Button variant="ghost" size="icon" class="relative rounded-full text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-100 transition-colors">
                        <Bell v-if="notifications.length === 0" class="h-5 w-5" />
                        <BellRing v-else class="h-5 w-5 text-indigo-600 dark:text-indigo-400" />
                        <span v-if="notifications.length > 0" class="absolute top-1 right-1.5 flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                        </span>
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end" class="w-80">
                    <div class="flex items-center justify-between px-4 py-2 border-b border-zinc-100 dark:border-zinc-800">
                        <span class="font-semibold text-sm">Notifications</span>
                        <Button v-if="notifications.length > 0" @click="markAllAsRead" variant="ghost" size="sm" class="h-auto p-0 text-xs text-indigo-600 hover:text-indigo-700 hover:bg-transparent dark:text-indigo-400">
                            Mark all read <CheckCheck class="ml-1 h-3 w-3" />
                        </Button>
                    </div>
                    <div class="max-h-80 overflow-y-auto">
                        <div v-if="notifications.length === 0" class="px-4 py-6 text-center text-sm text-zinc-500">
                            No new notifications
                        </div>
                        <template v-else>
                            <div v-for="notification in notifications" :key="notification.id" class="px-4 py-3 hover:bg-zinc-50 dark:hover:bg-zinc-900/50 cursor-pointer border-b border-zinc-50 dark:border-zinc-800/50 last:border-0 transition-colors group">
                                <div class="flex justify-between items-start gap-2">
                                    <div class="flex-1 min-w-0" @click="markAsRead(notification.id)">
                                        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ notification.data.title }}</p>
                                        <p class="text-xs text-zinc-500 mt-0.5 line-clamp-2">{{ notification.data.message }}</p>
                                        <p class="text-[10px] text-zinc-400 mt-1">{{ new Date(notification.created_at).toLocaleString() }}</p>
                                    </div>
                                    <Button @click="markAsRead(notification.id)" variant="ghost" size="icon" class="h-6 w-6 text-zinc-400 opacity-0 group-hover:opacity-100 transition-opacity flex-shrink-0 rounded-full hover:text-indigo-600 hover:bg-indigo-50 dark:hover:text-indigo-400 dark:hover:bg-indigo-900/30" title="Mark as read">
                                        <Check class="h-3 w-3" />
                                    </Button>
                                </div>
                            </div>
                        </template>
                    </div>
                </DropdownMenuContent>
            </DropdownMenu>

            <ThemeToggle />
            <DropdownMenu>
                <DropdownMenuTrigger :as-child="true">
                    <Button
                        variant="ghost"
                        size="icon"
                        class="relative size-10 w-auto rounded-full p-1 focus-within:ring-2 focus-within:ring-primary"
                    >
                        <Avatar
                            class="size-8 overflow-hidden rounded-full"
                        >
                            <AvatarImage
                                v-if="auth.user.avatar"
                                :src="auth.user.avatar"
                                :alt="auth.user.name"
                            />
                            <AvatarFallback
                                class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white"
                            >
                                {{ getInitials(auth.user?.name) }}
                            </AvatarFallback>
                        </Avatar>
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end" class="w-56">
                    <UserMenuContent :user="auth.user" />
                </DropdownMenuContent>
            </DropdownMenu>
        </div>
    </header>
</template>
