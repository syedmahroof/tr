<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Plus, Edit, Trash2, Search, CalendarCheck } from '@lucide/vue';
import { ref, watch } from 'vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';
import Pagination from '@/components/Pagination.vue';

const props = defineProps<{
    appointments: any[];
    filters?: any;
}>();

const search = ref(props.filters?.search || '');
const status = ref(props.filters?.status || '');
let searchTimeout: any = null;

import { computed } from 'vue';
const appointmentsList = computed(() => {
    if (props.appointments && (props.appointments as any).data) {
        return (props.appointments as any).data;
    }
    return props.appointments || [];
});

watch([search, status], ([newSearch, newStatus]) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        router.get('/admin/appointments', { search: newSearch, status: newStatus }, { preserveState: true, replace: true, preserveScroll: true });
    }, 300);
});

const deleteAppointment = (id: number) => {
    if (confirm('Are you sure you want to cancel and delete this appointment?')) {
        router.delete(`/admin/appointments/${id}`);
    }
};

const formatDate = (dateString: string) => {
    const date = new Date(dateString);

    return new Intl.DateTimeFormat('en-US', {
        month: 'short',
        day: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
    }).format(date).replace(',', ' -');
};
</script>

<template>
    <Head title="Appointments" />
    <AdminSidebarLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Appointments</h1>
                    <p class="text-muted-foreground mt-1">Schedule and manage upcoming visits.</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="relative group hidden sm:block">
                        <Search class="absolute left-2.5 top-2.5 h-4 w-4 text-zinc-400 group-focus-within:text-indigo-500 transition-colors" />
                        <Input v-model="search" type="search" placeholder="Search..." class="w-32 focus:w-64 transition-all duration-300 pl-9 h-9 border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 rounded-full shadow-sm" />
                    </div>

                    <select v-model="status" class="h-9 w-32 md:w-36 rounded-full border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-3 py-1 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:text-zinc-300 outline-none transition-colors">
                        <option value="">All Status</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>

                    <Link href="/admin/appointments/create">
                        <Button class="bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm">
                            <Plus class="mr-2 h-4 w-4" />
                            Schedule Visit
                        </Button>
                    </Link>
                </div>
            </div>
            
            <div v-if="appointmentsList.length === 0" class="flex flex-col items-center justify-center py-24 text-center border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-xl bg-zinc-50/50 dark:bg-zinc-950/20">
                <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center mb-4">
                    <CalendarCheck class="w-8 h-8" />
                </div>
                <h3 class="text-xl font-semibold mb-2">No appointments scheduled</h3>
                <p class="text-zinc-500 dark:text-zinc-400 max-w-sm mx-auto mb-6">
                    Pre-register a visitor by scheduling an appointment.
                </p>
                <Link href="/admin/appointments/create">
                    <Button class="bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm">
                        <Plus class="mr-2 h-4 w-4" />
                        Schedule Visit
                    </Button>
                </Link>
            </div>
            
            <div v-else class="rounded-md border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-zinc-500 uppercase bg-zinc-50 dark:bg-zinc-900/50 border-b border-zinc-200 dark:border-zinc-800">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-medium">Date & Time</th>
                                <th scope="col" class="px-6 py-4 font-medium">Visitor Name</th>
                                <th scope="col" class="px-6 py-4 font-medium">Host</th>
                                <th scope="col" class="px-6 py-4 font-medium">Purpose</th>
                                <th scope="col" class="px-6 py-4 font-medium">Status</th>
                                <th scope="col" class="px-6 py-4 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            <tr v-for="appointment in appointmentsList" :key="appointment.id" class="hover:bg-zinc-50/50 dark:hover:bg-zinc-900/20 transition-colors">
                                <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100 whitespace-nowrap">
                                    {{ formatDate(appointment.date_time) }}
                                </td>
                                <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ appointment.visitor_name }}
                                    <div class="text-xs text-zinc-500 font-normal mt-0.5" v-if="appointment.visitor_company">{{ appointment.visitor_company }}</div>
                                </td>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                    {{ appointment.host?.name }}
                                </td>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400 max-w-xs truncate" :title="appointment.purpose">
                                    {{ appointment.purpose }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize" 
                                          :class="{
                                              'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300': appointment.status === 'scheduled',
                                              'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300': appointment.status === 'completed',
                                              'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300': appointment.status === 'cancelled'
                                          }">
                                        {{ appointment.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Link :href="`/admin/appointments/${appointment.id}/edit`">
                                            <Button variant="ghost" size="icon" class="h-8 w-8 text-zinc-500 hover:text-indigo-600 dark:hover:text-indigo-400">
                                                <Edit class="h-4 w-4" />
                                            </Button>
                                        </Link>
                                        <Button variant="ghost" size="icon" @click="deleteAppointment(appointment.id)" class="h-8 w-8 text-zinc-500 hover:text-red-600 dark:hover:text-red-400">
                                            <Trash2 class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <Pagination v-if="appointments && (appointments as any).meta" :links="(appointments as any).meta.links" :meta="(appointments as any).meta" />
                <Pagination v-else-if="appointments && (appointments as any).links" :links="(appointments as any).links" :meta="(appointments as any)" />
            </div>
        </div>
    </AdminSidebarLayout>
</template>
