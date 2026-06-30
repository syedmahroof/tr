<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { 
    LayoutDashboard, 
    Users, 
    UserCheck, 
    CalendarCheck, 
    ShieldAlert, 
    Car, 
    Package, 
    BarChart3, 
    Settings 
} from '@lucide/vue';
import { computed } from 'vue';
import AppLogo from '@/components/AppLogo.vue';
import NavMain from '@/components/NavMain.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import type { NavItem } from '@/types';

const mainNavItems = computed<NavItem[]>(() => [
    {
        title: 'Dashboard',
        href: '/admin/dashboard',
        icon: LayoutDashboard,
        iconClass: 'text-blue-500',
    },
    {
        title: 'Visitor Management',
        href: '/admin/visitors',
        icon: Users,
        iconClass: 'text-indigo-500',
    },
    {
        title: 'Employee / Hosts',
        href: '/admin/employees',
        icon: UserCheck,
        iconClass: 'text-emerald-500',
    },
    {
        title: 'Appointments',
        href: '/admin/appointments',
        icon: CalendarCheck,
        iconClass: 'text-amber-500',
    },
    {
        title: 'Security & Watchlist',
        href: '/admin/security',
        icon: ShieldAlert,
        iconClass: 'text-red-500',
    },
    {
        title: 'Vehicle Management',
        href: '/admin/vehicles',
        icon: Car,
        iconClass: 'text-cyan-500',
    },
    {
        title: 'Deliveries',
        href: '/admin/deliveries',
        icon: Package,
        iconClass: 'text-orange-500',
    },
    {
        title: 'Reports & Analytics',
        href: '/admin/reports',
        icon: BarChart3,
        iconClass: 'text-purple-500',
    },
    {
        title: 'Settings',
        href: '/admin/settings',
        icon: Settings,
        iconClass: 'text-zinc-500',
    },
]);
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link href="/admin/dashboard">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>
    </Sidebar>
    <slot />
</template>
