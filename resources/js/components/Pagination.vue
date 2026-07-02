<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    links: { url: string | null; label: string; active: boolean }[];
    meta?: {
        current_page: number;
        from: number;
        last_page: number;
        to: number;
        total: number;
    };
}>();
</script>

<template>
    <div v-if="links && links.length > 3" class="flex items-center justify-between px-4 py-3 sm:px-6 border-t border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950">
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div v-if="meta">
                <p class="text-sm text-zinc-700 dark:text-zinc-400">
                    Showing <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ meta.from || 0 }}</span> to <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ meta.to || 0 }}</span> of <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ meta.total }}</span> results
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <template v-for="(link, key) in links" :key="key">
                        <div v-if="link.url === null" 
                             class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-zinc-400 ring-1 ring-inset ring-zinc-300 dark:ring-zinc-800"
                             v-html="link.label.replace('&amp;laquo; Previous', '&laquo;').replace('Next &amp;raquo;', '&raquo;')">
                        </div>
                        <Link v-else 
                              :href="link.url"
                              :class="[
                                link.active ? 'relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600' : 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-zinc-900 dark:text-zinc-100 ring-1 ring-inset ring-zinc-300 dark:ring-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-900 focus:z-20 focus:outline-offset-0'
                              ]"
                              v-html="link.label.replace('&amp;laquo; Previous', '&laquo;').replace('Next &amp;raquo;', '&raquo;')">
                        </Link>
                    </template>
                </nav>
            </div>
        </div>
        <!-- Mobile View -->
        <div class="flex flex-1 justify-between sm:hidden">
            <Link :href="links[0].url" v-if="links[0].url" class="relative inline-flex items-center rounded-md border border-zinc-300 dark:border-zinc-800 bg-white dark:bg-zinc-950 px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-900">Previous</Link>
            <div v-else class="relative inline-flex items-center rounded-md border border-zinc-300 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900 px-4 py-2 text-sm font-medium text-zinc-400 dark:text-zinc-600">Previous</div>
            
            <Link :href="links[links.length - 1].url" v-if="links[links.length - 1].url" class="relative ml-3 inline-flex items-center rounded-md border border-zinc-300 dark:border-zinc-800 bg-white dark:bg-zinc-950 px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-900">Next</Link>
            <div v-else class="relative ml-3 inline-flex items-center rounded-md border border-zinc-300 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900 px-4 py-2 text-sm font-medium text-zinc-400 dark:text-zinc-600">Next</div>
        </div>
    </div>
</template>
