<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { ArrowLeft, Save } from '@lucide/vue';

const props = defineProps<{
    appointment: any;
    employees: any[];
}>();

// Format datetime string for the HTML datetime-local input
const formatForInput = (dateString: string) => {
    try {
        const date = new Date(dateString);
        return date.toISOString().slice(0, 16);
    } catch (e) {
        return '';
    }
};

const form = useForm({
    visitor_name: props.appointment.visitor_name,
    visitor_email: props.appointment.visitor_email || '',
    visitor_company: props.appointment.visitor_company || '',
    host_id: props.appointment.host_id,
    date_time: formatForInput(props.appointment.date_time),
    purpose: props.appointment.purpose,
    status: props.appointment.status,
});

const submit = () => {
    form.put(`/admin/appointments/${props.appointment.id}`);
};
</script>

<template>
    <Head title="Edit Appointment" />
    <AdminSidebarLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6 max-w-3xl">
            <div class="flex items-center gap-4">
                <Link href="/admin/appointments">
                    <Button variant="outline" size="icon" class="h-8 w-8 rounded-full">
                        <ArrowLeft class="h-4 w-4" />
                    </Button>
                </Link>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Edit Appointment</h1>
                    <p class="text-muted-foreground mt-1">Update pre-registration details.</p>
                </div>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div class="rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 p-6 shadow-sm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-medium">Visitor Name <span class="text-red-500">*</span></label>
                            <Input v-model="form.visitor_name" type="text" required />
                            <div v-if="form.errors.visitor_name" class="text-sm text-red-500 mt-1">{{ form.errors.visitor_name }}</div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium">Visitor Email</label>
                            <Input v-model="form.visitor_email" type="email" />
                            <div v-if="form.errors.visitor_email" class="text-sm text-red-500 mt-1">{{ form.errors.visitor_email }}</div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium">Visitor Company</label>
                            <Input v-model="form.visitor_company" type="text" />
                            <div v-if="form.errors.visitor_company" class="text-sm text-red-500 mt-1">{{ form.errors.visitor_company }}</div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium">Host Employee <span class="text-red-500">*</span></label>
                            <select v-model="form.host_id" class="w-full h-10 rounded-md border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                                <option v-for="emp in employees" :key="emp.id" :value="emp.id">
                                    {{ emp.name }} {{ emp.department ? `(${emp.department})` : '' }}
                                </option>
                            </select>
                            <div v-if="form.errors.host_id" class="text-sm text-red-500 mt-1">{{ form.errors.host_id }}</div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium">Date and Time <span class="text-red-500">*</span></label>
                            <Input v-model="form.date_time" type="datetime-local" required />
                            <div v-if="form.errors.date_time" class="text-sm text-red-500 mt-1">{{ form.errors.date_time }}</div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium">Status <span class="text-red-500">*</span></label>
                            <select v-model="form.status" class="w-full h-10 rounded-md border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                                <option value="scheduled">Scheduled</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <div v-if="form.errors.status" class="text-sm text-red-500 mt-1">{{ form.errors.status }}</div>
                        </div>

                        <div class="space-y-2 md:col-span-2">
                            <label class="text-sm font-medium">Purpose of Visit <span class="text-red-500">*</span></label>
                            <textarea v-model="form.purpose" rows="3" class="w-full rounded-md border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500" required></textarea>
                            <div v-if="form.errors.purpose" class="text-sm text-red-500 mt-1">{{ form.errors.purpose }}</div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <Link href="/admin/appointments">
                        <Button variant="outline" type="button">Cancel</Button>
                    </Link>
                    <Button type="submit" :disabled="form.processing" class="bg-indigo-600 hover:bg-indigo-700 text-white">
                        <Save class="mr-2 h-4 w-4" />
                        Update
                    </Button>
                </div>
            </form>
        </div>
    </AdminSidebarLayout>
</template>
