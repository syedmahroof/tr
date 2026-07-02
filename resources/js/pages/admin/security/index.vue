<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ShieldAlert, Edit, Trash2, Search } from '@lucide/vue';
import { ref, watch } from 'vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';

const props = defineProps<{
    watchlists: any[];
    filters?: any;
}>();

const search = ref(props.filters?.search || '');
let searchTimeout: any = null;

watch(search, (newSearch) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        router.get('/admin/security', { search: newSearch }, { preserveState: true, replace: true, preserveScroll: true });
    }, 300);
});

const removeWatchlist = (id: number) => {
    if (confirm('Are you sure you want to remove this person from the watchlist?')) {
        router.delete(`/admin/security/${id}`);
    }
};

const formatDate = (dateString: string) => {
    const date = new Date(dateString);

    return new Intl.DateTimeFormat('en-US', {
        month: 'short',
        day: '2-digit',
        year: 'numeric'
    }).format(date);
};
</script>

<template>
    <Head title="Security & Watchlist" />
    <AdminSidebarLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-red-600 dark:text-red-500">Security Watchlist</h1>
                    <p class="text-muted-foreground mt-1">Manage flagged and banned individuals.</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="relative group hidden sm:block">
                        <Search class="absolute left-2.5 top-2.5 h-4 w-4 text-zinc-400 group-focus-within:text-red-500 transition-colors" />
                        <Input v-model="search" type="search" placeholder="Search names..." class="w-32 focus:w-64 transition-all duration-300 pl-9 h-9 border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 rounded-full shadow-sm focus:border-red-500 focus:ring-red-500" />
                    </div>

                    <Link href="/admin/security/create">
                        <Button class="bg-red-600 hover:bg-red-700 text-white shadow-sm">
                            <ShieldAlert class="mr-2 h-4 w-4" />
                            Add to Watchlist
                        </Button>
                    </Link>
                </div>
            </div>
            
            <div v-if="!watchlists || watchlists.length === 0" class="flex flex-col items-center justify-center py-24 text-center border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-xl bg-zinc-50/50 dark:bg-zinc-950/20">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400 rounded-full flex items-center justify-center mb-4">
                    <ShieldAlert class="w-8 h-8" />
                </div>
                <h3 class="text-xl font-semibold mb-2">No active watchlists</h3>
                <p class="text-zinc-500 dark:text-zinc-400 max-w-sm mx-auto mb-6">
                    The watchlist is empty. Add individuals to prevent them from checking in.
                </p>
                <Link href="/admin/security/create">
                    <Button class="bg-red-600 hover:bg-red-700 text-white shadow-sm">
                        <ShieldAlert class="mr-2 h-4 w-4" />
                        Add to Watchlist
                    </Button>
                </Link>
            </div>
            
            <div v-else class="rounded-md border border-red-200 dark:border-red-900/30 bg-white dark:bg-zinc-950 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-zinc-500 uppercase bg-zinc-50 dark:bg-zinc-900/50 border-b border-zinc-200 dark:border-zinc-800">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-medium">Name</th>
                                <th scope="col" class="px-6 py-4 font-medium">Reason</th>
                                <th scope="col" class="px-6 py-4 font-medium">Added By</th>
                                <th scope="col" class="px-6 py-4 font-medium">Date Added</th>
                                <th scope="col" class="px-6 py-4 font-medium">Status</th>
                                <th scope="col" class="px-6 py-4 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            <tr v-for="item in watchlists" :key="item.id" class="hover:bg-red-50/50 dark:hover:bg-red-900/10 transition-colors">
                                <td class="px-6 py-4 font-bold text-red-600 dark:text-red-400">
                                    {{ item.name }}
                                </td>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400 max-w-xs truncate" :title="item.reason">
                                    {{ item.reason }}
                                </td>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                    {{ item.added_by }}
                                </td>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400 whitespace-nowrap">
                                    {{ formatDate(item.created_at) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium uppercase tracking-wider" 
                                          :class="{
                                              'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300': item.status === 'active',
                                              'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300': item.status === 'inactive'
                                          }">
                                        {{ item.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Link :href="`/admin/security/${item.id}/edit`">
                                            <Button variant="ghost" size="icon" class="h-8 w-8 text-zinc-500 hover:text-indigo-600 dark:hover:text-indigo-400">
                                                <Edit class="h-4 w-4" />
                                            </Button>
                                        </Link>
                                        <Button variant="ghost" size="icon" @click="removeWatchlist(item.id)" class="h-8 w-8 text-zinc-500 hover:text-red-600 dark:hover:text-red-400">
                                            <Trash2 class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminSidebarLayout>
</template>
