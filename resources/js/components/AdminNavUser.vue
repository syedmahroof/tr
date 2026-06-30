<script setup lang="ts">
import { Link, usePage, router } from '@inertiajs/vue3';
import { ChevronsUpDown, LogOut, Settings } from '@lucide/vue';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from '@/components/ui/sidebar';

const page = usePage();
const user = page.props.auth?.user;
const { isMobile, state } = useSidebar();

const handleLogout = () => {
    router.post('/admin/logout');
};
</script>

<template>
    <SidebarMenu>
        <SidebarMenuItem>
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <SidebarMenuButton
                        size="lg"
                        class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
                    >
                        <div class="flex h-8 w-8 items-center justify-center rounded-md bg-indigo-600 text-white">
                            {{ user?.name?.charAt(0) || 'A' }}
                        </div>
                        <div class="grid flex-1 text-left text-sm leading-tight">
                            <span class="truncate font-semibold">{{ user?.name || 'Administrator' }}</span>
                            <span class="truncate text-xs text-muted-foreground">{{ user?.email || 'admin@example.com' }}</span>
                        </div>
                        <ChevronsUpDown class="ml-auto size-4" />
                    </SidebarMenuButton>
                </DropdownMenuTrigger>
                <DropdownMenuContent
                    class="w-[--reka-dropdown-menu-trigger-width] min-w-56 rounded-lg"
                    :side="
                        isMobile
                            ? 'bottom'
                            : state === 'collapsed'
                              ? 'left'
                              : 'bottom'
                    "
                    align="end"
                    :side-offset="4"
                >
                    <DropdownMenuLabel class="p-0 font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                            <div class="flex h-8 w-8 items-center justify-center rounded-md bg-indigo-600 text-white">
                                {{ user?.name?.charAt(0) || 'A' }}
                            </div>
                            <div class="grid flex-1 text-left text-sm leading-tight">
                                <span class="truncate font-semibold">{{ user?.name || 'Administrator' }}</span>
                                <span class="truncate text-xs text-muted-foreground">{{ user?.email || 'admin@example.com' }}</span>
                            </div>
                        </div>
                    </DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuGroup>
                        <DropdownMenuItem :as-child="true">
                            <Link class="block w-full cursor-pointer" href="#" prefetch>
                                <Settings class="mr-2 h-4 w-4" />
                                Admin Settings
                            </Link>
                        </DropdownMenuItem>
                    </DropdownMenuGroup>
                    <DropdownMenuSeparator />
                    <DropdownMenuItem @click="handleLogout" class="cursor-pointer">
                        <LogOut class="mr-2 h-4 w-4" />
                        Log out
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </SidebarMenuItem>
    </SidebarMenu>
</template>
