<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { ArrowLeft, Save } from '@lucide/vue';

const props = defineProps<{
    watchlist: any;
}>();

const form = useForm({
    name: props.watchlist.name,
    reason: props.watchlist.reason,
    status: props.watchlist.status,
});

const submit = () => {
    form.put(`/admin/security/${props.watchlist.id}`);
};
</script>

<template>
    <Head title="Edit Watchlist" />
    <AdminSidebarLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6 max-w-3xl">
            <div class="flex items-center gap-4">
                <Link href="/admin/security">
                    <Button variant="outline" size="icon" class="h-8 w-8 rounded-full">
                        <ArrowLeft class="h-4 w-4" />
                    </Button>
                </Link>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-red-600 dark:text-red-500">Edit Watchlist Entry</h1>
                    <p class="text-muted-foreground mt-1">Update details or change status of a flagged individual.</p>
                </div>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div class="rounded-xl border border-red-200 dark:border-red-900/30 bg-white dark:bg-zinc-950 p-6 shadow-sm">
                    <div class="grid grid-cols-1 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-medium">Individual's Name <span class="text-red-500">*</span></label>
                            <Input v-model="form.name" type="text" required class="focus-visible:ring-red-500" />
                            <div v-if="form.errors.name" class="text-sm text-red-500 mt-1">{{ form.errors.name }}</div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium">Status <span class="text-red-500">*</span></label>
                            <select v-model="form.status" class="w-full h-10 rounded-md border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-red-500" required>
                                <option value="active">Active - Alert Security</option>
                                <option value="inactive">Inactive - Lifted</option>
                            </select>
                            <div v-if="form.errors.status" class="text-sm text-red-500 mt-1">{{ form.errors.status }}</div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium">Reason for Watchlist <span class="text-red-500">*</span></label>
                            <textarea v-model="form.reason" rows="4" class="w-full rounded-md border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-red-500" required></textarea>
                            <div v-if="form.errors.reason" class="text-sm text-red-500 mt-1">{{ form.errors.reason }}</div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <Link href="/admin/security">
                        <Button variant="outline" type="button">Cancel</Button>
                    </Link>
                    <Button type="submit" :disabled="form.processing" class="bg-red-600 hover:bg-red-700 text-white">
                        <Save class="mr-2 h-4 w-4" />
                        Update Entry
                    </Button>
                </div>
            </form>
        </div>
    </AdminSidebarLayout>
</template>
