<script setup lang="ts">
import { useForm, Head, Link } from '@inertiajs/vue3';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Loader2, ArrowLeft } from '@lucide/vue';

const props = defineProps<{
    vehicle: any;
}>();

const form = useForm({
    owner_name: props.vehicle.owner_name,
    owner_type: props.vehicle.owner_type,
    license_plate: props.vehicle.license_plate,
    make: props.vehicle.make || '',
    model: props.vehicle.model || '',
    color: props.vehicle.color || '',
    status: props.vehicle.status,
    notes: props.vehicle.notes || '',
});

const submit = () => {
    form.put(`/admin/vehicles/${props.vehicle.id}`);
};
</script>

<template>
    <Head title="Edit Vehicle" />
    <AdminSidebarLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <div class="flex items-center gap-4">
                <Link href="/admin/vehicles">
                    <Button variant="outline" size="icon">
                        <ArrowLeft class="h-4 w-4" />
                    </Button>
                </Link>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Edit Vehicle</h1>
                    <p class="text-muted-foreground mt-1">Update details for {{ vehicle.vehicle_id }}</p>
                </div>
            </div>
            
            <Card class="max-w-2xl">
                <CardHeader>
                    <CardTitle>Vehicle Information</CardTitle>
                    <CardDescription>Update the vehicle and owner details below.</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <Label for="owner_name">Owner Name *</Label>
                                <Input id="owner_name" v-model="form.owner_name" required />
                                <span class="text-sm text-red-500" v-if="form.errors.owner_name">{{ form.errors.owner_name }}</span>
                            </div>
                            
                            <div class="space-y-2">
                                <Label for="owner_type">Owner Type *</Label>
                                <select id="owner_type" v-model="form.owner_type" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                    <option value="employee">Employee</option>
                                    <option value="visitor">Visitor</option>
                                    <option value="contractor">Contractor</option>
                                </select>
                                <span class="text-sm text-red-500" v-if="form.errors.owner_type">{{ form.errors.owner_type }}</span>
                            </div>
                            
                            <div class="space-y-2">
                                <Label for="license_plate">License Plate *</Label>
                                <Input id="license_plate" v-model="form.license_plate" required class="uppercase" />
                                <span class="text-sm text-red-500" v-if="form.errors.license_plate">{{ form.errors.license_plate }}</span>
                            </div>
                            
                            <div class="space-y-2">
                                <Label for="status">Status *</Label>
                                <select id="status" v-model="form.status" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="banned">Banned</option>
                                </select>
                                <span class="text-sm text-red-500" v-if="form.errors.status">{{ form.errors.status }}</span>
                            </div>
                            
                            <div class="space-y-2">
                                <Label for="color">Color</Label>
                                <Input id="color" v-model="form.color" />
                                <span class="text-sm text-red-500" v-if="form.errors.color">{{ form.errors.color }}</span>
                            </div>
                            
                            <div class="space-y-2">
                                <Label for="make">Make / Brand</Label>
                                <Input id="make" v-model="form.make" />
                                <span class="text-sm text-red-500" v-if="form.errors.make">{{ form.errors.make }}</span>
                            </div>
                            
                            <div class="space-y-2 md:col-span-2">
                                <Label for="model">Model</Label>
                                <Input id="model" v-model="form.model" />
                                <span class="text-sm text-red-500" v-if="form.errors.model">{{ form.errors.model }}</span>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <Label for="notes">Additional Notes</Label>
                            <textarea 
                                id="notes" 
                                v-model="form.notes" 
                                rows="3"
                                class="flex min-h-[80px] w-full rounded-md border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950/50 px-3 py-2 text-sm text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 dark:placeholder:text-zinc-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:border-indigo-500 disabled:cursor-not-allowed disabled:opacity-50 transition-all"
                            ></textarea>
                            <span class="text-sm text-red-500" v-if="form.errors.notes">{{ form.errors.notes }}</span>
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
