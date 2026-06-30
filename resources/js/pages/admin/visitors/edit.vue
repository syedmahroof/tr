<script setup lang="ts">
import { useForm, Head, Link } from '@inertiajs/vue3';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Loader2, ArrowLeft } from '@lucide/vue';

const props = defineProps<{
    visitor: any;
}>();

const form = useForm({
    name: props.visitor.name,
    phone: props.visitor.phone,
    email: props.visitor.email || '',
    company: props.visitor.company || '',
    category: props.visitor.category,
    host_employee: props.visitor.host_employee,
    purpose: props.visitor.purpose,
});

const submit = () => {
    form.put(`/admin/visitors/${props.visitor.id}`);
};
</script>

<template>
    <Head title="Edit Visitor" />
    <AdminSidebarLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <div class="flex items-center gap-4">
                <Link href="/admin/visitors">
                    <Button variant="outline" size="icon">
                        <ArrowLeft class="h-4 w-4" />
                    </Button>
                </Link>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Edit Visitor</h1>
                    <p class="text-muted-foreground mt-1">Update details for {{ visitor.visitor_id }}</p>
                </div>
            </div>
            
            <Card class="max-w-2xl">
                <CardHeader>
                    <CardTitle>Visitor Information</CardTitle>
                    <CardDescription>Update the visitor's details below.</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <Label for="name">Full Name *</Label>
                                <Input id="name" v-model="form.name" required />
                                <span class="text-sm text-red-500" v-if="form.errors.name">{{ form.errors.name }}</span>
                            </div>
                            
                            <div class="space-y-2">
                                <Label for="phone">Phone Number *</Label>
                                <Input id="phone" v-model="form.phone" required />
                                <span class="text-sm text-red-500" v-if="form.errors.phone">{{ form.errors.phone }}</span>
                            </div>
                            
                            <div class="space-y-2">
                                <Label for="email">Email Address</Label>
                                <Input id="email" type="email" v-model="form.email" />
                                <span class="text-sm text-red-500" v-if="form.errors.email">{{ form.errors.email }}</span>
                            </div>
                            
                            <div class="space-y-2">
                                <Label for="company">Company</Label>
                                <Input id="company" v-model="form.company" />
                                <span class="text-sm text-red-500" v-if="form.errors.company">{{ form.errors.company }}</span>
                            </div>
                            
                            <div class="space-y-2">
                                <Label for="category">Visitor Category *</Label>
                                <select id="category" v-model="form.category" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                    <option value="guest">Guest</option>
                                    <option value="vendor">Vendor</option>
                                    <option value="contractor">Contractor</option>
                                    <option value="interviewee">Interviewee</option>
                                </select>
                                <span class="text-sm text-red-500" v-if="form.errors.category">{{ form.errors.category }}</span>
                            </div>
                            
                            <div class="space-y-2">
                                <Label for="host_employee">Host Employee *</Label>
                                <Input id="host_employee" v-model="form.host_employee" required />
                                <span class="text-sm text-red-500" v-if="form.errors.host_employee">{{ form.errors.host_employee }}</span>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <Label for="purpose">Purpose of Visit *</Label>
                            <textarea 
                                id="purpose" 
                                v-model="form.purpose" 
                                required 
                                rows="3"
                                class="flex min-h-[80px] w-full rounded-md border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950/50 px-3 py-2 text-sm text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 dark:placeholder:text-zinc-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:border-indigo-500 disabled:cursor-not-allowed disabled:opacity-50 transition-all"
                            ></textarea>
                            <span class="text-sm text-red-500" v-if="form.errors.purpose">{{ form.errors.purpose }}</span>
                        </div>
                        
                        <div class="pt-4 flex justify-end">
                            <Button type="submit" :disabled="form.processing" class="bg-indigo-600 hover:bg-indigo-700 text-white">
                                <Loader2 v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                                Save Changes
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AdminSidebarLayout>
</template>
