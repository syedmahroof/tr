<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Package, Edit, Trash2, Eye, History, Search } from '@lucide/vue';
import { ref, watch } from 'vue';

const props = defineProps<{
    deliveries: any[];
    filters?: any;
}>();

const search = ref(props.filters?.search || '');
const status = ref(props.filters?.status || '');
let searchTimeout: any = null;

watch([search, status], ([newSearch, newStatus]) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        router.get('/admin/deliveries', { search: newSearch, status: newStatus }, { preserveState: true, replace: true, preserveScroll: true });
    }, 300);
});
</script>

<template>
    <Head title="Delivery Management" />
    <AdminSidebarLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Deliveries</h1>
                    <p class="text-muted-foreground mt-1">Manage and track all incoming deliveries and packages.</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="relative group hidden sm:block">
                        <Search class="absolute left-2.5 top-2.5 h-4 w-4 text-zinc-400 group-focus-within:text-indigo-500 transition-colors" />
                        <Input v-model="search" type="search" placeholder="Search..." class="w-32 focus:w-64 transition-all duration-300 pl-9 h-9 border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 rounded-full shadow-sm" />
                    </div>
                    
                    <select v-model="status" class="h-9 w-32 md:w-36 rounded-full border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-3 py-1 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-zinc-300 outline-none transition-colors">
                        <option value="">All Status</option>
                        <option value="arrived">Arrived</option>
                        <option value="received">Received</option>
                        <option value="collected">Collected</option>
                    </select>

                    <Link href="/admin/deliveries/create" v-if="deliveries && deliveries.length > 0">
                        <Button class="bg-indigo-600 hover:bg-indigo-700 text-white">
                            <Package class="mr-2 h-4 w-4" />
                            Add Delivery
                        </Button>
                    </Link>
                </div>
            </div>
            
            <!-- Empty State -->
            <div v-if="!deliveries || deliveries.length === 0" class="flex flex-col items-center justify-center py-24 text-center border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-xl bg-zinc-50/50 dark:bg-zinc-950/20">
                <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center mb-4">
                    <Package class="w-8 h-8" />
                </div>
                <h3 class="text-xl font-semibold mb-2">No deliveries recorded</h3>
                <p class="text-zinc-500 dark:text-zinc-400 max-w-sm mx-auto mb-6">
                    Get started by logging a new delivery package.
                </p>
                <Link href="/admin/deliveries/create">
                    <Button class="bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm">
                        <Package class="mr-2 h-4 w-4" />
                        Add Delivery
                    </Button>
                </Link>
            </div>
            
            <!-- Data Table -->
            <div v-else class="rounded-md border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-zinc-500 uppercase bg-zinc-50 dark:bg-zinc-900/50 dark:text-zinc-400 border-b border-zinc-200 dark:border-zinc-800">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-medium">Tracking ID</th>
                                <th scope="col" class="px-6 py-4 font-medium">From</th>
                                <th scope="col" class="px-6 py-4 font-medium">For Whom</th>
                                <th scope="col" class="px-6 py-4 font-medium">Status</th>
                                <th scope="col" class="px-6 py-4 font-medium">Received At</th>
                                <th scope="col" class="px-6 py-4 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            <tr v-for="delivery in deliveries" :key="delivery.id" class="hover:bg-zinc-50/50 dark:hover:bg-zinc-900/20 transition-colors">
                                <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ delivery.delivery_id }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-zinc-900 dark:text-zinc-100">{{ delivery.from_whom }}</div>
                                    <div class="text-xs text-zinc-500" v-if="delivery.company">{{ delivery.company }}</div>
                                </td>
                                <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ delivery.for_whom }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize"
                                          :class="{
                                              'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300': delivery.status === 'arrived',
                                              'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300': delivery.status === 'received',
                                              'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300': delivery.status === 'collected'
                                          }">
                                        {{ delivery.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                    {{ delivery.received_at ? new Date(delivery.received_at).toLocaleString() : '-' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <Link :href="`/admin/deliveries/${delivery.id}`" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300" title="History / View">
                                            <Eye class="w-4 h-4" />
                                        </Link>
                                        <Link :href="`/admin/deliveries/${delivery.id}/edit`" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" title="Edit">
                                            <Edit class="w-4 h-4" />
                                        </Link>
                                        <Link :href="`/admin/deliveries/${delivery.id}`" method="delete" as="button" type="button" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" title="Delete">
                                            <Trash2 class="w-4 h-4" />
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="flex justify-center p-4 border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50">
                    <Link href="/admin/deliveries/history">
                        <Button variant="outline" class="text-zinc-600 dark:text-zinc-300 border-zinc-300 dark:border-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-800">
                            <History class="mr-2 h-4 w-4" />
                            View Full Delivery History Logs
                        </Button>
                    </Link>
                </div>
            </div>
            
        </div>
    </AdminSidebarLayout>
</template>
