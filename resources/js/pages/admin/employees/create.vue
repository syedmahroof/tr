<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, Save } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';

const form = useForm({
    name: '',
    email: '',
    department: '',
    phone: '',
    password: '',
});

const submit = () => {
    form.post('/admin/employees');
};
</script>

<template>
    <Head title="Add Employee" />
    <AdminSidebarLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6 max-w-3xl">
            <div class="flex items-center gap-4">
                <Link href="/admin/employees">
                    <Button variant="outline" size="icon" class="h-8 w-8 rounded-full">
                        <ArrowLeft class="h-4 w-4" />
                    </Button>
                </Link>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Add Employee</h1>
                    <p class="text-muted-foreground mt-1">Register a new staff member to the system.</p>
                </div>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div class="rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 p-6 shadow-sm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-medium">Full Name <span class="text-red-500">*</span></label>
                            <Input v-model="form.name" type="text" placeholder="John Doe" required />
                            <div v-if="form.errors.name" class="text-sm text-red-500 mt-1">{{ form.errors.name }}</div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium">Email Address <span class="text-red-500">*</span></label>
                            <Input v-model="form.email" type="email" placeholder="john@example.com" required />
                            <div v-if="form.errors.email" class="text-sm text-red-500 mt-1">{{ form.errors.email }}</div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium">Department</label>
                            <Input v-model="form.department" type="text" placeholder="e.g. IT, HR, Operations" />
                            <div v-if="form.errors.department" class="text-sm text-red-500 mt-1">{{ form.errors.department }}</div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium">Phone Number</label>
                            <Input v-model="form.phone" type="text" placeholder="+1 234 567 8900" />
                            <div v-if="form.errors.phone" class="text-sm text-red-500 mt-1">{{ form.errors.phone }}</div>
                        </div>

                        <div class="space-y-2 md:col-span-2">
                            <label class="text-sm font-medium">Initial Password <span class="text-red-500">*</span></label>
                            <Input v-model="form.password" type="password" required />
                            <div v-if="form.errors.password" class="text-sm text-red-500 mt-1">{{ form.errors.password }}</div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <Link href="/admin/employees">
                        <Button variant="outline" type="button">Cancel</Button>
                    </Link>
                    <Button type="submit" :disabled="form.processing" class="bg-indigo-600 hover:bg-indigo-700 text-white">
                        <Save class="mr-2 h-4 w-4" />
                        Save Employee
                    </Button>
                </div>
            </form>
        </div>
    </AdminSidebarLayout>
</template>
