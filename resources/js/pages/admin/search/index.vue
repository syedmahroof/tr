<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { Users, Truck, Package, ArrowRight, Search } from '@lucide/vue';
import { Button } from '@/components/ui/button';

defineProps<{
    query: string;
    results: {
        visitors: any[];
        vehicles: any[];
        deliveries: any[];
    };
}>();
</script>

<template>
    <Head :title="`Search Results for '${query}'`" />
    <AdminSidebarLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6 max-w-7xl mx-auto w-full">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Search Results</h1>
                <p class="text-muted-foreground mt-1 text-zinc-500">
                    Showing results for <span class="font-semibold text-zinc-900 dark:text-zinc-100">"{{ query }}"</span> across all directories.
                </p>
            </div>

            <div v-if="results.visitors.length === 0 && results.vehicles.length === 0 && results.deliveries.length === 0" class="flex flex-col items-center justify-center p-12 text-center border rounded-lg bg-zinc-50/50 dark:bg-zinc-900/50 border-zinc-200 dark:border-zinc-800 border-dashed">
                <Search class="h-10 w-10 text-zinc-400 mb-4" />
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">No results found</h3>
                <p class="text-sm text-zinc-500 mt-1 max-w-sm">We couldn't find any matches across visitors, vehicles, or deliveries for that query.</p>
            </div>

            <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Visitors -->
                <Card class="bg-white dark:bg-zinc-900/60 shadow-sm border-t-4 border-t-indigo-500">
                    <CardHeader class="pb-3">
                        <div class="flex items-center gap-2">
                            <Users class="h-5 w-5 text-indigo-500" />
                            <CardTitle>Visitors ({{ results.visitors.length }})</CardTitle>
                        </div>
                    </CardHeader>
                    <CardContent class="p-0">
                        <div v-if="results.visitors.length === 0" class="p-4 text-sm text-zinc-500 text-center">No visitors match.</div>
                        <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            <Link 
                                v-for="visitor in results.visitors" :key="visitor.id" 
                                :href="`/admin/visitors/${visitor.id}`"
                                class="flex items-center justify-between p-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors group"
                            >
                                <div>
                                    <p class="font-medium text-sm">{{ visitor.name }}</p>
                                    <p class="text-xs text-zinc-500">{{ visitor.visitor_id }} • {{ visitor.company || visitor.category }}</p>
                                </div>
                                <ArrowRight class="h-4 w-4 text-zinc-400 group-hover:text-indigo-500 transition-colors" />
                            </Link>
                        </div>
                    </CardContent>
                </Card>

                <!-- Vehicles -->
                <Card class="bg-white dark:bg-zinc-900/60 shadow-sm border-t-4 border-t-cyan-500">
                    <CardHeader class="pb-3">
                        <div class="flex items-center gap-2">
                            <Truck class="h-5 w-5 text-cyan-500" />
                            <CardTitle>Vehicles ({{ results.vehicles.length }})</CardTitle>
                        </div>
                    </CardHeader>
                    <CardContent class="p-0">
                        <div v-if="results.vehicles.length === 0" class="p-4 text-sm text-zinc-500 text-center">No vehicles match.</div>
                        <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            <Link 
                                v-for="vehicle in results.vehicles" :key="vehicle.id" 
                                :href="`/admin/vehicles/${vehicle.id}`"
                                class="flex items-center justify-between p-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors group"
                            >
                                <div>
                                    <p class="font-medium text-sm">{{ vehicle.driver_name }}</p>
                                    <p class="text-xs text-zinc-500">{{ vehicle.license_plate }} • {{ vehicle.vehicle_id }}</p>
                                </div>
                                <ArrowRight class="h-4 w-4 text-zinc-400 group-hover:text-cyan-500 transition-colors" />
                            </Link>
                        </div>
                    </CardContent>
                </Card>

                <!-- Deliveries -->
                <Card class="bg-white dark:bg-zinc-900/60 shadow-sm border-t-4 border-t-orange-500">
                    <CardHeader class="pb-3">
                        <div class="flex items-center gap-2">
                            <Package class="h-5 w-5 text-orange-500" />
                            <CardTitle>Deliveries ({{ results.deliveries.length }})</CardTitle>
                        </div>
                    </CardHeader>
                    <CardContent class="p-0">
                        <div v-if="results.deliveries.length === 0" class="p-4 text-sm text-zinc-500 text-center">No deliveries match.</div>
                        <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            <Link 
                                v-for="delivery in results.deliveries" :key="delivery.id" 
                                :href="`/admin/deliveries/${delivery.id}`"
                                class="flex items-center justify-between p-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors group"
                            >
                                <div>
                                    <p class="font-medium text-sm">For: {{ delivery.for_whom }}</p>
                                    <p class="text-xs text-zinc-500">From: {{ delivery.from_whom }} • {{ delivery.delivery_id }}</p>
                                </div>
                                <ArrowRight class="h-4 w-4 text-zinc-400 group-hover:text-orange-500 transition-colors" />
                            </Link>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AdminSidebarLayout>
</template>
