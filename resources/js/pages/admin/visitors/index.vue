<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { UserPlus, Edit, Trash2, Eye, Search, CheckCircle, LogOut } from '@lucide/vue';
import { ref, watch } from 'vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';
import Pagination from '@/components/Pagination.vue';

const props = defineProps<{
    visitors: any[];
    filters?: any;
}>();

const search = ref(props.filters?.search || '');
const status = ref(props.filters?.status || '');
let searchTimeout: any = null;

import { computed } from 'vue';
const visitorsList = computed(() => {
    if (props.visitors && (props.visitors as any).data) {
        return (props.visitors as any).data;
    }
    return props.visitors || [];
});

watch([search, status], ([newSearch, newStatus]) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        router.get('/admin/visitors', { search: newSearch, status: newStatus }, { preserveState: true, replace: true, preserveScroll: true });
    }, 300);
});
</script>

<template>
    <Head title="Visitor Management" />
    <AdminSidebarLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Visitors</h1>
                    <p class="text-muted-foreground mt-1">Manage and view all registered visitors.</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="relative group hidden sm:block">
                        <Search class="absolute left-2.5 top-2.5 h-4 w-4 text-zinc-400 group-focus-within:text-indigo-500 transition-colors" />
                        <Input v-model="search" type="search" placeholder="Search..." class="w-32 focus:w-64 transition-all duration-300 pl-9 h-9 border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 rounded-full shadow-sm" />
                    </div>
                    
                    <select v-model="status" class="h-9 w-32 md:w-36 rounded-full border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-3 py-1 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-zinc-300 outline-none transition-colors">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="checked_in">Checked In</option>
                        <option value="checked_out">Checked Out</option>
                    </select>

                    <Link href="/admin/visitors/registration" v-if="visitorsList.length > 0">
                        <Button class="bg-indigo-600 hover:bg-indigo-700 text-white">
                            <UserPlus class="mr-2 h-4 w-4" />
                            Add Visitor
                        </Button>
                    </Link>
                </div>
            </div>
            
            <!-- Empty State -->
            <div v-if="visitorsList.length === 0" class="flex flex-col items-center justify-center py-24 text-center border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-xl bg-zinc-50/50 dark:bg-zinc-950/20">
                <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center mb-4">
                    <UserPlus class="w-8 h-8" />
                </div>
                <h3 class="text-xl font-semibold mb-2">No visitors currently</h3>
                <p class="text-zinc-500 dark:text-zinc-400 max-w-sm mx-auto mb-6">
                    Get started by registering your first visitor. You can manage check-ins and appointments from here.
                </p>
                <Link href="/admin/visitors/registration">
                    <Button class="bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm">
                        <UserPlus class="mr-2 h-4 w-4" />
                        Add Visitor
                    </Button>
                </Link>
            </div>
            
            <!-- Data Table -->
            <div v-else class="rounded-md border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-zinc-500 uppercase bg-zinc-50 dark:bg-zinc-900/50 dark:text-zinc-400 border-b border-zinc-200 dark:border-zinc-800">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-medium">Visitor ID</th>
                                <th scope="col" class="px-6 py-4 font-medium">Name</th>
                                <th scope="col" class="px-6 py-4 font-medium">Company</th>
                                <th scope="col" class="px-6 py-4 font-medium">Category</th>
                                <th scope="col" class="px-6 py-4 font-medium">Host Employee</th>
                                <th scope="col" class="px-6 py-4 font-medium">Status</th>
                                <th scope="col" class="px-6 py-4 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            <tr v-for="visitor in visitorsList" :key="visitor.id" class="hover:bg-zinc-50/50 dark:hover:bg-zinc-900/20 transition-colors">
                                <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ visitor.visitor_id }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-zinc-900 dark:text-zinc-100">{{ visitor.name }}</div>
                                    <div class="text-xs text-zinc-500 mt-0.5">{{ visitor.email || visitor.phone }}</div>
                                </td>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                    {{ visitor.company || '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize" 
                                          :class="{
                                              'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300': visitor.category === 'guest',
                                              'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300': visitor.category === 'vendor',
                                              'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300': visitor.category === 'contractor',
                                              'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300': visitor.category === 'interviewee'
                                          }">
                                        {{ visitor.category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                    {{ visitor.host_employee }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize"
                                          :class="{
                                              'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300': visitor.status === 'pending',
                                              'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300': visitor.status === 'checked_in',
                                              'bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-500 line-through': visitor.status === 'checked_out'
                                          }">
                                        {{ visitor.status.replace('_', ' ') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <Link v-if="visitor.status === 'pending'" :href="`/admin/visitors/${visitor.id}/status`" method="patch" :data="{ status: 'checked_in' }" as="button" type="button" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300" title="Check In">
                                            <CheckCircle class="w-4 h-4" />
                                        </Link>
                                        <Link v-if="visitor.status === 'checked_in'" :href="`/admin/visitors/${visitor.id}/status`" method="patch" :data="{ status: 'checked_out' }" as="button" type="button" class="text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-300" title="Check Out">
                                            <LogOut class="w-4 h-4" />
                                        </Link>
                                        <Link :href="`/admin/visitors/${visitor.id}`" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300" title="View">
                                            <Eye class="w-4 h-4" />
                                        </Link>
                                        <Link :href="`/admin/visitors/${visitor.id}/edit`" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" title="Edit">
                                            <Edit class="w-4 h-4" />
                                        </Link>
                                        <Link :href="`/admin/visitors/${visitor.id}`" method="delete" as="button" type="button" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" title="Delete">
                                            <Trash2 class="w-4 h-4" />
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <Pagination v-if="visitors && (visitors as any).meta" :links="(visitors as any).meta.links" :meta="(visitors as any).meta" />
                <Pagination v-else-if="visitors && (visitors as any).links" :links="(visitors as any).links" :meta="(visitors as any)" />
            </div>
            
        </div>
    </AdminSidebarLayout>
</template>
