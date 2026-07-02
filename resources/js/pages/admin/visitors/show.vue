<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Edit, Trash2, CheckCircle, LogOut } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';

defineProps<{
    visitor: any;
}>();
</script>

<template>
    <Head title="Visitor Details" />
    <AdminSidebarLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <Link href="/admin/visitors">
                        <Button variant="outline" size="icon">
                            <ArrowLeft class="h-4 w-4" />
                        </Button>
                    </Link>
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">Visitor Details</h1>
                        <p class="text-muted-foreground mt-1">{{ visitor.visitor_id }}</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <Link v-if="visitor.status === 'pending'" :href="`/admin/visitors/${visitor.id}/status`" method="patch" :data="{ status: 'checked_in' }" as="button" type="button">
                        <Button variant="outline" class="text-emerald-600 border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700 dark:border-emerald-900 dark:hover:bg-emerald-900/30 dark:text-emerald-400">
                            <CheckCircle class="mr-2 h-4 w-4" />
                            Check In
                        </Button>
                    </Link>
                    <Link v-if="visitor.status === 'checked_in'" :href="`/admin/visitors/${visitor.id}/status`" method="patch" :data="{ status: 'checked_out' }" as="button" type="button">
                        <Button variant="outline" class="text-orange-600 border-orange-200 hover:bg-orange-50 hover:text-orange-700 dark:border-orange-900 dark:hover:bg-orange-900/30 dark:text-orange-400">
                            <LogOut class="mr-2 h-4 w-4" />
                            Check Out
                        </Button>
                    </Link>
                    <Link :href="`/admin/visitors/${visitor.id}/edit`">
                        <Button variant="outline" class="text-blue-600 border-blue-200 hover:bg-blue-50 hover:text-blue-700 dark:border-blue-900 dark:hover:bg-blue-900/30 dark:text-blue-400">
                            <Edit class="mr-2 h-4 w-4" />
                            Edit
                        </Button>
                    </Link>
                    <Link :href="`/admin/visitors/${visitor.id}`" method="delete" as="button">
                        <Button variant="outline" class="text-red-600 border-red-200 hover:bg-red-50 hover:text-red-700 dark:border-red-900 dark:hover:bg-red-900/30 dark:text-red-400">
                            <Trash2 class="mr-2 h-4 w-4" />
                            Delete
                        </Button>
                    </Link>
                </div>
            </div>
            
            <Card class="max-w-3xl">
                <CardHeader>
                    <CardTitle>Visitor Information</CardTitle>
                </CardHeader>
                <CardContent>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Full Name</dt>
                            <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ visitor.name }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Status</dt>
                            <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100 capitalize">{{ visitor.status.replace('_', ' ') }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Phone</dt>
                            <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ visitor.phone }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Email Address</dt>
                            <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ visitor.email || '-' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Company</dt>
                            <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ visitor.company || '-' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Category</dt>
                            <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100 capitalize">{{ visitor.category }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Host Employee</dt>
                            <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ visitor.host_employee }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Registered On</dt>
                            <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ new Date(visitor.created_at).toLocaleString() }}</dd>
                        </div>
                        <div class="sm:col-span-2 border-t border-zinc-200 dark:border-zinc-800 pt-4 mt-2">
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Purpose of Visit</dt>
                            <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100 whitespace-pre-wrap">{{ visitor.purpose }}</dd>
                        </div>
                    </dl>
                </CardContent>
            </Card>
        </div>
    </AdminSidebarLayout>
</template>
