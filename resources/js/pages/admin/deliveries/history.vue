<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Clock, PackageCheck, CheckCircle2 } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';
import Pagination from '@/components/Pagination.vue';

defineProps<{
    deliveries: any;
}>();

import { computed } from 'vue';
const deliveriesList = computed(() => {
    if (deliveries && (deliveries as any).data) {
        return (deliveries as any).data;
    }
    return deliveries || [];
});
</script>

<template>
    <Head title="Full Delivery History" />
    <AdminSidebarLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <div class="flex items-center gap-4">
                <Link href="/admin/deliveries">
                    <Button variant="outline" size="icon">
                        <ArrowLeft class="h-4 w-4" />
                    </Button>
                </Link>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Full Delivery History Logs</h1>
                    <p class="text-muted-foreground mt-1">Chronological record of all delivery status changes.</p>
                </div>
            </div>
            
            <Card>
                <CardHeader>
                    <CardTitle>Delivery Logs</CardTitle>
                </CardHeader>
                <CardContent class="p-0">
                    <div class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        <div v-if="deliveriesList.length === 0" class="p-8 text-center text-zinc-500">
                            No delivery history found.
                        </div>
                        <template v-for="delivery in deliveriesList" :key="delivery.id">
                            <!-- Collected Log -->
                            <div v-if="delivery.collected_at" class="p-4 hover:bg-zinc-50 dark:hover:bg-zinc-900/30 transition-colors flex items-start gap-4">
                                <div class="bg-emerald-100 dark:bg-emerald-900/30 p-2 rounded-full text-emerald-600 dark:text-emerald-400 mt-0.5">
                                    <CheckCircle2 class="w-4 h-4" />
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Package Collected</h4>
                                        <span class="text-xs text-zinc-500 font-mono bg-zinc-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">{{ delivery.delivery_id }}</span>
                                    </div>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                                        Package from <span class="font-medium">{{ delivery.from_whom }}</span> was picked up by <span class="font-medium">{{ delivery.for_whom }}</span>.
                                    </p>
                                    <p class="text-xs text-zinc-500 mt-1.5 flex items-center gap-1">
                                        <Clock class="w-3 h-3" /> {{ new Date(delivery.collected_at).toLocaleString() }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Received Log -->
                            <div v-if="delivery.received_at" class="p-4 hover:bg-zinc-50 dark:hover:bg-zinc-900/30 transition-colors flex items-start gap-4">
                                <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-full text-blue-600 dark:text-blue-400 mt-0.5">
                                    <PackageCheck class="w-4 h-4" />
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Package Received by Reception</h4>
                                        <span class="text-xs text-zinc-500 font-mono bg-zinc-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">{{ delivery.delivery_id }}</span>
                                    </div>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                                        Package from <span class="font-medium">{{ delivery.from_whom }}</span> has been received and processed.
                                    </p>
                                    <p class="text-xs text-zinc-500 mt-1.5 flex items-center gap-1">
                                        <Clock class="w-3 h-3" /> {{ new Date(delivery.received_at).toLocaleString() }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Arrived Log -->
                            <div v-if="delivery.arrived_at" class="p-4 hover:bg-zinc-50 dark:hover:bg-zinc-900/30 transition-colors flex items-start gap-4">
                                <div class="bg-amber-100 dark:bg-amber-900/30 p-2 rounded-full text-amber-600 dark:text-amber-400 mt-0.5">
                                    <Clock class="w-4 h-4" />
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Package Arrived</h4>
                                        <span class="text-xs text-zinc-500 font-mono bg-zinc-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">{{ delivery.delivery_id }}</span>
                                    </div>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                                        New delivery logged from <span class="font-medium">{{ delivery.from_whom }}</span> {{ delivery.company ? `(${delivery.company})` : '' }} for <span class="font-medium">{{ delivery.for_whom }}</span>.
                                    </p>
                                    <p class="text-xs text-zinc-500 mt-1.5 flex items-center gap-1">
                                        <Clock class="w-3 h-3" /> {{ new Date(delivery.arrived_at).toLocaleString() }}
                                    </p>
                                </div>
                            </div>
                        </template>
                    </div>
                </CardContent>
            </Card>
            
            <!-- Pagination -->
            <Pagination v-if="deliveries && (deliveries as any).meta" :links="(deliveries as any).meta.links" :meta="(deliveries as any).meta" />
            <Pagination v-else-if="deliveries && (deliveries as any).links" :links="(deliveries as any).links" :meta="(deliveries as any)" />
        </div>
    </AdminSidebarLayout>
</template>
