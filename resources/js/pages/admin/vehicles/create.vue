<script setup lang="ts">
import { useForm, Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Loader2, ChevronDown, ArrowLeft } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';

const form = useForm({
    owner_name: '',
    owner_type: 'employee',
    license_plate: '',
    make: '',
    model: '',
    color: '',
    photo: null,
    notes: '',
});

const submit = () => {
    form.post('/admin/vehicles/registration');
};

const vehicleData: Record<string, string[]> = {
    'Toyota': ['Corolla', 'Camry', 'RAV4', 'Highlander', 'Tacoma', 'Tundra', 'Prius', 'Sienna', '4Runner', 'Yaris'],
    'Honda': ['Civic', 'Accord', 'CR-V', 'Pilot', 'Odyssey', 'HR-V', 'Ridgeline', 'Fit', 'Passport', 'Insight'],
    'Ford': ['F-150', 'Mustang', 'Explorer', 'Escape', 'Focus', 'Edge', 'Ranger', 'Bronco', 'Expedition', 'Fusion'],
    'Chevrolet': ['Silverado', 'Equinox', 'Malibu', 'Tahoe', 'Traverse', 'Colorado', 'Impala', 'Camaro', 'Suburban', 'Trailblazer'],
    'Nissan': ['Altima', 'Rogue', 'Sentra', 'Pathfinder', 'Maxima', 'Murano', 'Frontier', 'Titan', 'Versa', 'Kicks'],
    'Hyundai': ['Elantra', 'Sonata', 'Tucson', 'Santa Fe', 'Palisade', 'Kona', 'Venue', 'Ioniq', 'Accent', 'Veloster'],
    'Kia': ['Forte', 'Optima', 'Sorento', 'Sportage', 'Telluride', 'Soul', 'Seltos', 'Rio', 'Stinger', 'Carnival'],
    'Volkswagen': ['Jetta', 'Passat', 'Tiguan', 'Atlas', 'Golf', 'Taos', 'Arteon', 'ID.4', 'Touareg', 'Beetle'],
    'BMW': ['3 Series', '5 Series', 'X3', 'X5', '4 Series', '7 Series', 'X1', 'X7', 'M3', 'i4'],
    'Mercedes-Benz': ['C-Class', 'E-Class', 'GLC', 'GLE', 'S-Class', 'A-Class', 'GLS', 'CLA', 'G-Class', 'EQE']
};

const brands = Object.keys(vehicleData);
const availableModels = computed(() => {
    if (form.make && vehicleData[form.make]) {
        return vehicleData[form.make];
    }
    return [];
});

const showBrand = ref(false);
const showModel = ref(false);

const selectBrand = (brand: string) => {
    form.make = brand;
    showBrand.value = false;
};

const selectModel = (mod: string) => {
    form.model = mod;
    showModel.value = false;
};
</script>

<template>
    <Head title="Register Vehicle" />
    <AdminSidebarLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <div class="flex items-center gap-4">
                <Link href="/admin/vehicles">
                    <Button variant="outline" size="icon">
                        <ArrowLeft class="h-4 w-4" />
                    </Button>
                </Link>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Register Vehicle</h1>
                    <p class="text-muted-foreground mt-1">Fill in the details to register a new vehicle for parking access.</p>
                </div>
            </div>
            
            <Card class="max-w-2xl">
                <CardHeader>
                    <CardTitle>Vehicle Information</CardTitle>
                    <CardDescription>Enter the vehicle and owner details below.</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <Label for="owner_name">Owner Name *</Label>
                                <Input id="owner_name" v-model="form.owner_name" required placeholder="John Doe" />
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
                                <Input id="license_plate" v-model="form.license_plate" required placeholder="ABC-1234" class="uppercase" />
                                <span class="text-sm text-red-500" v-if="form.errors.license_plate">{{ form.errors.license_plate }}</span>
                            </div>
                            
                            <div class="space-y-2">
                                <Label for="color">Color</Label>
                                <Input id="color" v-model="form.color" placeholder="Silver" />
                                <span class="text-sm text-red-500" v-if="form.errors.color">{{ form.errors.color }}</span>
                            </div>
                            
                            <div class="space-y-2 relative">
                                <Label for="make">Make / Brand</Label>
                                <div class="relative">
                                    <Input id="make" v-model="form.make" placeholder="Toyota" autocomplete="off" @focus="showBrand = true" @blur="showBrand = false" />
                                    <button type="button" tabindex="-1" @mousedown.prevent @click="showBrand = !showBrand" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <ChevronDown class="h-4 w-4 text-zinc-400/50 hover:text-zinc-500" />
                                    </button>
                                </div>
                                <div v-show="showBrand" class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 shadow-lg max-h-60 overflow-auto">
                                    <div v-for="brand in brands" :key="brand" @mousedown.prevent="selectBrand(brand)" class="cursor-pointer px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-sm">
                                        {{ brand }}
                                    </div>
                                </div>
                                <span class="text-sm text-red-500" v-if="form.errors.make">{{ form.errors.make }}</span>
                            </div>
                            
                            <div class="space-y-2 relative">
                                <Label for="model">Model</Label>
                                <div class="relative">
                                    <Input id="model" v-model="form.model" placeholder="Camry" autocomplete="off" @focus="showModel = true" @blur="showModel = false" />
                                    <button type="button" tabindex="-1" @mousedown.prevent @click="showModel = !showModel" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <ChevronDown class="h-4 w-4 text-zinc-400/50 hover:text-zinc-500" />
                                    </button>
                                </div>
                                <div v-show="showModel && availableModels.length > 0" class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 shadow-lg max-h-60 overflow-auto">
                                    <div v-for="mod in availableModels" :key="mod" @mousedown.prevent="selectModel(mod)" class="cursor-pointer px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-sm">
                                        {{ mod }}
                                    </div>
                                </div>
                                <span class="text-sm text-red-500" v-if="form.errors.model">{{ form.errors.model }}</span>
                            </div>

                            <div class="space-y-2 md:col-span-2">
                                <Label for="photo">Vehicle Photo</Label>
                                <Input id="photo" type="file" @change="e => form.photo = e.target.files[0]" accept="image/*" capture="environment" class="cursor-pointer file:cursor-pointer file:border-0 file:bg-zinc-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-600 hover:file:bg-zinc-200 dark:file:bg-zinc-800 dark:hover:file:bg-zinc-700" />
                                <span class="text-sm text-red-500" v-if="form.errors.photo">{{ form.errors.photo }}</span>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <Label for="notes">Additional Notes</Label>
                            <textarea 
                                id="notes" 
                                v-model="form.notes" 
                                rows="3"
                                class="flex min-h-[80px] w-full rounded-md border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950/50 px-3 py-2 text-sm text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 dark:placeholder:text-zinc-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:border-indigo-500 disabled:cursor-not-allowed disabled:opacity-50 transition-all"
                                placeholder="Parking slot preference or other details..." 
                            ></textarea>
                            <span class="text-sm text-red-500" v-if="form.errors.notes">{{ form.errors.notes }}</span>
                        </div>
                        
                        <div class="pt-4 flex justify-end">
                            <Button type="submit" :disabled="form.processing" class="bg-indigo-600 hover:bg-indigo-700 text-white">
                                <Loader2 v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                                Register Vehicle
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AdminSidebarLayout>
</template>
