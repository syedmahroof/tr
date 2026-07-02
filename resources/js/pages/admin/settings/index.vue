<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Switch } from '@/components/ui/switch';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';
</script>

<template>
    <Head title="System Settings" />
    <AdminSidebarLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6 max-w-4xl">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">System Settings</h1>
                <p class="text-muted-foreground mt-1">Manage global preferences and configurations.</p>
            </div>
            
            <div class="space-y-6">
                <!-- General Settings -->
                <div class="rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50">
                        <h3 class="font-medium">General Configuration</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid gap-2">
                            <label class="text-sm font-medium">Facility Name</label>
                            <Input value="Main Headquarters" class="max-w-md" />
                        </div>
                        <div class="grid gap-2">
                            <label class="text-sm font-medium">Support Contact Email</label>
                            <Input value="security@company.com" class="max-w-md" />
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50">
                        <h3 class="font-medium">Security & Access</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="flex items-center justify-between max-w-xl">
                            <div>
                                <label class="text-sm font-medium">Require Host Approval</label>
                                <p class="text-xs text-muted-foreground mt-1">Visitors must be approved by their host before check-in.</p>
                            </div>
                            <Switch :default-checked="true" />
                        </div>
                        <div class="flex items-center justify-between max-w-xl">
                            <div>
                                <label class="text-sm font-medium">Email Notifications</label>
                                <p class="text-xs text-muted-foreground mt-1">Send automatic email alerts to hosts upon visitor arrival.</p>
                            </div>
                            <Switch :default-checked="true" />
                        </div>
                        <div class="flex items-center justify-between max-w-xl">
                            <div>
                                <label class="text-sm font-medium">Strict Watchlist Enforcement</label>
                                <p class="text-xs text-muted-foreground mt-1">Block check-in entirely if a visitor matches the watchlist.</p>
                            </div>
                            <Switch :default-checked="false" />
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end pt-4">
                    <Button class="bg-indigo-600 hover:bg-indigo-700 text-white">Save Changes</Button>
                </div>
            </div>
        </div>
    </AdminSidebarLayout>
</template>
