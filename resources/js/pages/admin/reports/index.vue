<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Users, Car, Package, ShieldAlert } from '@lucide/vue';
</script>

<template>
    <Head title="Reports & Analytics" />
    <AdminSidebarLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Reports & Analytics</h1>
                <p class="text-muted-foreground mt-1">Overview of facility metrics and traffic.</p>
            </div>
            
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Total Visitors (Monthly)</CardTitle>
                        <Users class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">1,248</div>
                        <p class="text-xs text-muted-foreground">+12% from last month</p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Deliveries Received</CardTitle>
                        <Package class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">342</div>
                        <p class="text-xs text-muted-foreground">+4% from last month</p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Vehicles Logged</CardTitle>
                        <Car class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">892</div>
                        <p class="text-xs text-muted-foreground">-2% from last month</p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Watchlist Alerts</CardTitle>
                        <ShieldAlert class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">3</div>
                        <p class="text-xs text-muted-foreground">Active alerts this week</p>
                    </CardContent>
                </Card>
            </div>

            <div class="mt-4 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 p-6 shadow-sm min-h-[400px] flex items-center justify-center flex-col text-center">
                <BarChart3 class="h-12 w-12 text-zinc-300 dark:text-zinc-700 mb-4" />
                <h3 class="text-lg font-medium">Detailed Analytics Coming Soon</h3>
                <p class="text-sm text-muted-foreground max-w-sm mt-2">Historical charts and data export features will be available in the next system update.</p>
            </div>
        </div>
    </AdminSidebarLayout>
</template>

<script lang="ts">
import { BarChart3 } from '@lucide/vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';
</script>
