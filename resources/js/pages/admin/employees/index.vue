<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { UserPlus, Edit, Trash2, Search, UserCheck } from '@lucide/vue';
import { ref, watch } from 'vue';

const props = defineProps<{
    employees: any[];
    filters?: any;
}>();

const search = ref(props.filters?.search || '');
let searchTimeout: any = null;

watch(search, (newSearch) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        router.get('/admin/employees', { search: newSearch }, { preserveState: true, replace: true, preserveScroll: true });
    }, 300);
});

const deleteEmployee = (id: number) => {
    if (confirm('Are you sure you want to remove this employee?')) {
        router.delete(`/admin/employees/${id}`);
    }
};
</script>

<template>
    <Head title="Employee Management" />
    <AdminSidebarLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Employees & Hosts</h1>
                    <p class="text-muted-foreground mt-1">Manage staff members who can host visitors.</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="relative group hidden sm:block">
                        <Search class="absolute left-2.5 top-2.5 h-4 w-4 text-zinc-400 group-focus-within:text-indigo-500 transition-colors" />
                        <Input v-model="search" type="search" placeholder="Search..." class="w-32 focus:w-64 transition-all duration-300 pl-9 h-9 border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 rounded-full shadow-sm" />
                    </div>

                    <Link href="/admin/employees/create">
                        <Button class="bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm">
                            <UserPlus class="mr-2 h-4 w-4" />
                            Add Employee
                        </Button>
                    </Link>
                </div>
            </div>
            
            <div v-if="!employees || employees.length === 0" class="flex flex-col items-center justify-center py-24 text-center border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-xl bg-zinc-50/50 dark:bg-zinc-950/20">
                <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center mb-4">
                    <UserCheck class="w-8 h-8" />
                </div>
                <h3 class="text-xl font-semibold mb-2">No employees found</h3>
                <p class="text-zinc-500 dark:text-zinc-400 max-w-sm mx-auto mb-6">
                    Add employees to the system so they can be assigned as hosts for visitors.
                </p>
                <Link href="/admin/employees/create">
                    <Button class="bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm">
                        <UserPlus class="mr-2 h-4 w-4" />
                        Add Employee
                    </Button>
                </Link>
            </div>
            
            <div v-else class="rounded-md border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-zinc-500 uppercase bg-zinc-50 dark:bg-zinc-900/50 border-b border-zinc-200 dark:border-zinc-800">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-medium">Name</th>
                                <th scope="col" class="px-6 py-4 font-medium">Email</th>
                                <th scope="col" class="px-6 py-4 font-medium">Department</th>
                                <th scope="col" class="px-6 py-4 font-medium">Phone</th>
                                <th scope="col" class="px-6 py-4 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            <tr v-for="employee in employees" :key="employee.id" class="hover:bg-zinc-50/50 dark:hover:bg-zinc-900/20 transition-colors">
                                <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ employee.name }}
                                </td>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                    {{ employee.email }}
                                </td>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                    {{ employee.department || '-' }}
                                </td>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                    {{ employee.phone || '-' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Link :href="`/admin/employees/${employee.id}/edit`">
                                            <Button variant="ghost" size="icon" class="h-8 w-8 text-zinc-500 hover:text-indigo-600 dark:hover:text-indigo-400">
                                                <Edit class="h-4 w-4" />
                                            </Button>
                                        </Link>
                                        <Button variant="ghost" size="icon" @click="deleteEmployee(employee.id)" class="h-8 w-8 text-zinc-500 hover:text-red-600 dark:hover:text-red-400">
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
