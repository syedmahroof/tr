<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Edit, Trash2, CheckCircle2, Clock, PackageCheck } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';

defineProps<{
    delivery: any;
}>();
</script>

<template>
    <Head title="Delivery History" />
    <AdminSidebarLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <Link href="/admin/deliveries">
                        <Button variant="outline" size="icon">
                            <ArrowLeft class="h-4 w-4" />
                        </Button>
                    </Link>
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">Delivery History</h1>
                        <p class="text-muted-foreground mt-1">{{ delivery.delivery_id }}</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <Link :href="`/admin/deliveries/${delivery.id}/edit`">
                        <Button variant="outline" class="text-blue-600 border-blue-200 hover:bg-blue-50">
                            <Edit class="mr-2 h-4 w-4" />
                            Update Status / Edit
                        </Button>
                    </Link>
                    <Link :href="`/admin/deliveries/${delivery.id}`" method="delete" as="button">
                        <Button variant="outline" class="text-red-600 border-red-200 hover:bg-red-50">
                            <Trash2 class="mr-2 h-4 w-4" />
                            Delete
                        </Button>
                    </Link>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <Card class="lg:col-span-2">
                    <CardHeader>
                        <CardTitle>Delivery Information</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-zinc-500">From Whom (Sender)</dt>
                                <dd class="mt-1 text-sm text-zinc-900">{{ delivery.from_whom }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-zinc-500">For Whom (Recipient)</dt>
                                <dd class="mt-1 text-sm text-zinc-900 font-semibold">{{ delivery.for_whom }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-zinc-500">Company / Courier</dt>
                                <dd class="mt-1 text-sm text-zinc-900">{{ delivery.company || '-' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-zinc-500">Status</dt>
                                <dd class="mt-1 text-sm text-zinc-900 capitalize font-medium px-2 py-1 bg-zinc-100 inline-block rounded-md">{{ delivery.status }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-zinc-500">Package Details</dt>
                                <dd class="mt-1 text-sm text-zinc-900">{{ delivery.package_details || '-' }}</dd>
                            </div>
                            <div class="sm:col-span-2 border-t border-zinc-200 pt-4 mt-2">
                                <dt class="text-sm font-medium text-zinc-500">Additional Notes</dt>
                                <dd class="mt-1 text-sm text-zinc-900 whitespace-pre-wrap">{{ delivery.notes || 'No notes available.' }}</dd>
                            </div>
                        </dl>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Status Timeline</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="relative border-l border-zinc-200 ml-3 space-y-8">
                            <!-- Arrived -->
                            <div class="relative">
                                <div class="absolute -left-3.5 bg-zinc-100 p-1 rounded-full border border-zinc-200">
                                    <Clock class="w-4 h-4 text-amber-500" />
                                </div>
                                <div class="ml-6">
                                    <h4 class="text-sm font-semibold text-zinc-900">Arrived</h4>
                                    <p class="text-xs text-zinc-500 mt-1" v-if="delivery.arrived_at">
                                        {{ new Date(delivery.arrived_at).toLocaleString() }}
                                    </p>
                                    <p class="text-xs text-zinc-400 mt-1" v-else>Pending</p>
                                </div>
                            </div>
                            
                            <!-- Received by Reception -->
                            <div class="relative">
                                <div class="absolute -left-3.5 bg-zinc-100 p-1 rounded-full border border-zinc-200">
                                    <PackageCheck class="w-4 h-4" :class="delivery.received_at ? 'text-blue-500' : 'text-zinc-300'" />
                                </div>
                                <div class="ml-6">
                                    <h4 class="text-sm font-semibold" :class="delivery.received_at ? 'text-zinc-900' : 'text-zinc-400'">Received</h4>
                                    <p class="text-xs text-zinc-500 mt-1" v-if="delivery.received_at">
                                        {{ new Date(delivery.received_at).toLocaleString() }}
                                    </p>
                                    <p class="text-xs text-zinc-400 mt-1" v-else>Pending</p>
                                </div>
                            </div>

                            <!-- Collected by Recipient -->
                            <div class="relative">
                                <div class="absolute -left-3.5 bg-zinc-100 p-1 rounded-full border border-zinc-200">
                                    <CheckCircle2 class="w-4 h-4" :class="delivery.collected_at ? 'text-emerald-500' : 'text-zinc-300'" />
                                </div>
                                <div class="ml-6">
                                    <h4 class="text-sm font-semibold" :class="delivery.collected_at ? 'text-zinc-900' : 'text-zinc-400'">Collected</h4>
                                    <p class="text-xs text-zinc-500 mt-1" v-if="delivery.collected_at">
                                        {{ new Date(delivery.collected_at).toLocaleString() }}
                                    </p>
                                    <p class="text-xs text-zinc-400 mt-1" v-else>Pending</p>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AdminSidebarLayout>
</template>
