<script setup lang="ts">
import { useForm, Head, Link } from '@inertiajs/vue3';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Loader2, ArrowLeft } from '@lucide/vue';

const props = defineProps<{
    delivery: any;
}>();

const form = useForm({
    from_whom: props.delivery.from_whom,
    for_whom: props.delivery.for_whom,
    company: props.delivery.company || '',
    package_details: props.delivery.package_details || '',
    status: props.delivery.status,
    notes: props.delivery.notes || '',
});

const submit = () => {
    form.put(`/admin/deliveries/${props.delivery.id}`);
};
</script>

<template>
    <Head title="Edit Delivery" />
    <AdminSidebarLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <div class="flex items-center gap-4">
                <Link href="/admin/deliveries">
                    <Button variant="outline" size="icon">
                        <ArrowLeft class="h-4 w-4" />
                    </Button>
                </Link>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Edit Delivery</h1>
                    <p class="text-muted-foreground mt-1">Update details for {{ delivery.delivery_id }}</p>
                </div>
            </div>
            
            <Card class="max-w-2xl">
                <CardHeader>
                    <CardTitle>Delivery Information</CardTitle>
                    <CardDescription>Update the package details and tracking status.</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <Label for="from_whom">From (Sender Name) *</Label>
                                <Input id="from_whom" v-model="form.from_whom" required />
                                <span class="text-sm text-red-500" v-if="form.errors.from_whom">{{ form.errors.from_whom }}</span>
                            </div>
                            
                            <div class="space-y-2">
                                <Label for="company">Company / Courier</Label>
                                <Input id="company" v-model="form.company" />
                                <span class="text-sm text-red-500" v-if="form.errors.company">{{ form.errors.company }}</span>
                            </div>
                            
                            <div class="space-y-2">
                                <Label for="for_whom">For Whom (Recipient Name) *</Label>
                                <Input id="for_whom" v-model="form.for_whom" required />
                                <span class="text-sm text-red-500" v-if="form.errors.for_whom">{{ form.errors.for_whom }}</span>
                            </div>
                            
                            <div class="space-y-2">
                                <Label for="status">Tracking Status *</Label>
                                <select id="status" v-model="form.status" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                    <option value="arrived">Arrived (Dropped off)</option>
                                    <option value="received">Received (Processed by Reception)</option>
                                    <option value="collected">Collected (Picked up by recipient)</option>
                                </select>
                                <span class="text-sm text-red-500" v-if="form.errors.status">{{ form.errors.status }}</span>
                            </div>
                            
                            <div class="space-y-2 md:col-span-2">
                                <Label for="package_details">Package Details</Label>
                                <Input id="package_details" v-model="form.package_details" />
                                <span class="text-sm text-red-500" v-if="form.errors.package_details">{{ form.errors.package_details }}</span>
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
