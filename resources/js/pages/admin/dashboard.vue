<script setup>
import { usePage, useForm, Head } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { 
    Users, Activity, Settings, LogOut, UserCheck, UserX, UserPlus, 
    CalendarCheck, ClipboardCheck, Briefcase, FileSignature, AlertTriangle, Package, Building
} from '@lucide/vue';
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({})
    }
});
const user = usePage().props.auth?.user;
const form = useForm({});

const logout = () => {
    form.post('/admin/logout');
};

import { VisXYContainer, VisLine, VisAxis, VisDonut, VisStackedBar } from '@unovis/vue';
import { ChartContainer, ChartTooltip, ChartCrosshair } from '@/components/ui/chart';

const trendData = [
    { name: 'Mon', total: 120 },
    { name: 'Tue', total: 150 },
    { name: 'Wed', total: 180 },
    { name: 'Thu', total: 140 },
    { name: 'Fri', total: 200 },
    { name: 'Sat', total: 80 },
    { name: 'Sun', total: 60 },
];

const typeData = [
    { name: 'Guest', value: 45 },
    { name: 'Vendor', value: 30 },
    { name: 'Contractor', value: 25 },
];

const peakHoursData = [
    { hour: '9AM', count: 50 },
    { hour: '10AM', count: 80 },
    { hour: '11AM', count: 40 },
    { hour: '12PM', count: 30 },
    { hour: '1PM', count: 60 },
    { hour: '2PM', count: 70 },
];

const deptData = [
    { name: 'HR', count: 45 },
    { name: 'Engineering', count: 120 },
    { name: 'Sales', count: 85 },
    { name: 'Support', count: 50 },
    { name: 'Marketing', count: 30 },
];

const hostData = [
    { name: 'Jane Smith', count: 25 },
    { name: 'Robert Brown', count: 18 },
    { name: 'Mike Davis', count: 15 },
    { name: 'Sarah', count: 12 },
    { name: 'John', count: 8 },
];

const chartConfig = {
    total: { color: '#6366f1' }, // indigo-500
    value: { color: '#10b981' }, // green-500
    count: { color: '#f59e0b' }, // amber-500
};
</script>

<template>
    <Head title="Management Overview" />
    
    <AdminSidebarLayout>
        <div class="bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 transition-colors duration-300 min-h-screen">
            <!-- Top Header (Inside the Content Area) -->
            <header class="border-b border-zinc-200 dark:border-zinc-800 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md sticky top-0 z-30 transition-colors duration-300 flex items-center justify-between px-6 h-16">
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">Management Overview</h1>
                </div>
            </header>

            <!-- Main Content -->
            <main class="p-6 max-w-[1600px] mx-auto space-y-8">
                
                <!-- KPI Cards Section -->
                <div>
                    <h2 class="text-lg font-semibold tracking-tight mb-4">Key Performance Indicators</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <Card class="bg-white dark:bg-zinc-900/60 shadow-sm">
                            <CardContent class="p-3 flex flex-row items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Visitors</p>
                                    <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ stats.visitorsToday || 0 }}</h3>
                                </div>
                                <div class="p-1.5 bg-blue-50 dark:bg-blue-900/20 rounded-md text-blue-500">
                                    <Users class="w-4 h-4" />
                                </div>
                            </CardContent>
                        </Card>

                        <Card class="bg-white dark:bg-zinc-900/60 shadow-sm">
                            <CardContent class="p-3 flex flex-row items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">On-Premises</p>
                                    <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ stats.onPremises || 0 }}</h3>
                                </div>
                                <div class="p-1.5 bg-green-50 dark:bg-green-900/20 rounded-md text-green-500">
                                    <Activity class="w-4 h-4" />
                                </div>
                            </CardContent>
                        </Card>

                        <Card class="bg-white dark:bg-zinc-900/60 shadow-sm">
                            <CardContent class="p-3 flex flex-row items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Pre-Registered</p>
                                    <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ stats.preRegistered || 0 }}</h3>
                                </div>
                                <div class="p-1.5 bg-indigo-50 dark:bg-indigo-900/20 rounded-md text-indigo-500">
                                    <CalendarCheck class="w-4 h-4" />
                                </div>
                            </CardContent>
                        </Card>

                        <Card class="bg-white dark:bg-zinc-900/60 shadow-sm">
                            <CardContent class="p-3 flex flex-row items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Pending</p>
                                    <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ stats.pendingApprovals || 0 }}</h3>
                                </div>
                                <div class="p-1.5 bg-amber-50 dark:bg-amber-900/20 rounded-md text-amber-500">
                                    <AlertTriangle class="w-4 h-4" />
                                </div>
                            </CardContent>
                        </Card>

                        <Card class="bg-white dark:bg-zinc-900/60 shadow-sm">
                            <CardContent class="p-3 flex flex-row items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Passes</p>
                                    <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ stats.passesIssued || 0 }}</h3>
                                </div>
                                <div class="p-1.5 bg-purple-50 dark:bg-purple-900/20 rounded-md text-purple-500">
                                    <FileSignature class="w-4 h-4" />
                                </div>
                            </CardContent>
                        </Card>

                        <Card class="bg-white dark:bg-zinc-900/60 shadow-sm">
                            <CardContent class="p-3 flex flex-row items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Employees</p>
                                    <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ stats.totalEmployees || 0 }}</h3>
                                </div>
                                <div class="p-1.5 bg-cyan-50 dark:bg-cyan-900/20 rounded-md text-cyan-500">
                                    <Briefcase class="w-4 h-4" />
                                </div>
                            </CardContent>
                        </Card>

                        <Card class="bg-white dark:bg-zinc-900/60 shadow-sm">
                            <CardContent class="p-3 flex flex-row items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Deliveries</p>
                                    <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ stats.deliveriesToday || 0 }}</h3>
                                </div>
                                <div class="p-1.5 bg-orange-50 dark:bg-orange-900/20 rounded-md text-orange-500">
                                    <Package class="w-4 h-4" />
                                </div>
                            </CardContent>
                        </Card>

                        <Card class="bg-white dark:bg-zinc-900/60 shadow-sm">
                            <CardContent class="p-3 flex flex-row items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Contractors</p>
                                    <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ stats.contractorsOnSite || 0 }}</h3>
                                </div>
                                <div class="p-1.5 bg-rose-50 dark:bg-rose-900/20 rounded-md text-rose-500">
                                    <Building class="w-4 h-4" />
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                </div>

                <!-- Analytics Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    <Card class="bg-white dark:bg-zinc-900/60 shadow-sm col-span-1 lg:col-span-2 xl:col-span-2">
                        <CardHeader>
                            <CardTitle>Daily/Weekly/Monthly Visitor Trends</CardTitle>
                            <CardDescription>Overall foot traffic over time.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div class="h-[250px] w-full p-2">
                                <ChartContainer :config="chartConfig">
                                    <VisXYContainer :data="trendData">
                                        <VisLine :x="(d, i) => i" :y="(d) => d.total" color="#6366f1" />
                                        <VisAxis type="x" :tickFormat="(i) => trendData[i]?.name" />
                                        <VisAxis type="y" />
                                        <ChartCrosshair />
                                        <ChartTooltip />
                                    </VisXYContainer>
                                </ChartContainer>
                            </div>
                        </CardContent>
                    </Card>

                    <Card class="bg-white dark:bg-zinc-900/60 shadow-sm">
                        <CardHeader>
                            <CardTitle>Visitor Type Distribution</CardTitle>
                            <CardDescription>Guests vs. Vendors vs. Contractors</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div class="h-[250px] w-full p-2">
                                <ChartContainer :config="chartConfig">
                                    <VisXYContainer :data="typeData">
                                        <VisDonut :value="(d) => d.value" :arcWidth="40" />
                                        <ChartTooltip />
                                    </VisXYContainer>
                                </ChartContainer>
                            </div>
                        </CardContent>
                    </Card>

                    <Card class="bg-white dark:bg-zinc-900/60 shadow-sm">
                        <CardHeader>
                            <CardTitle>Peak Visiting Hours</CardTitle>
                            <CardDescription>Busiest times of the day.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div class="h-[200px] w-full p-2">
                                <ChartContainer :config="chartConfig">
                                    <VisXYContainer :data="peakHoursData">
                                        <VisStackedBar :x="(d, i) => i" :y="(d) => d.count" color="#f59e0b" :barPadding="0.1" />
                                        <VisAxis type="x" :tickFormat="(i) => peakHoursData[i]?.hour" />
                                        <ChartCrosshair />
                                        <ChartTooltip />
                                    </VisXYContainer>
                                </ChartContainer>
                            </div>
                        </CardContent>
                    </Card>

                    <Card class="bg-white dark:bg-zinc-900/60 shadow-sm">
                        <CardHeader>
                            <CardTitle>Department-wise Visits</CardTitle>
                            <CardDescription>Which departments receive the most guests.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div class="h-[200px] w-full p-2">
                                <ChartContainer :config="chartConfig">
                                    <VisXYContainer :data="deptData">
                                        <VisStackedBar :x="(d, i) => i" :y="(d) => d.count" color="#3b82f6" :barPadding="0.15" />
                                        <VisAxis type="x" :tickFormat="(i) => deptData[i]?.name" />
                                        <ChartCrosshair />
                                        <ChartTooltip />
                                    </VisXYContainer>
                                </ChartContainer>
                            </div>
                        </CardContent>
                    </Card>

                    <Card class="bg-white dark:bg-zinc-900/60 shadow-sm">
                        <CardHeader>
                            <CardTitle>Host-wise Visitor Count</CardTitle>
                            <CardDescription>Top employees hosting visitors.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div class="h-[200px] w-full p-2">
                                <ChartContainer :config="chartConfig">
                                    <VisXYContainer :data="hostData">
                                        <VisStackedBar :x="(d, i) => i" :y="(d) => d.count" color="#10b981" :barPadding="0.15" />
                                        <VisAxis type="x" :tickFormat="(i) => hostData[i]?.name" />
                                        <ChartCrosshair />
                                        <ChartTooltip />
                                    </VisXYContainer>
                                </ChartContainer>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Recent Activity Feed -->
                <div>
                    <h2 class="text-lg font-semibold tracking-tight mb-4">Recent Activity Feed</h2>
                    <Card class="bg-white dark:bg-zinc-900/60 shadow-sm">
                        <CardContent class="p-0">
                            <div class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                <div class="p-4 flex items-start gap-4">
                                    <div class="bg-green-100 dark:bg-green-900/30 p-2 rounded-full text-green-600 dark:text-green-400">
                                        <UserCheck class="w-4 h-4" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium">Visitor Check-in: John Doe</p>
                                        <p class="text-xs text-zinc-500">Host: Jane Smith (HR) • 2 mins ago</p>
                                    </div>
                                </div>
                                <div class="p-4 flex items-start gap-4">
                                    <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-full text-blue-600 dark:text-blue-400">
                                        <UserPlus class="w-4 h-4" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium">New Registration: Alice Johnson</p>
                                        <p class="text-xs text-zinc-500">Category: Vendor • 15 mins ago</p>
                                    </div>
                                </div>
                                <div class="p-4 flex items-start gap-4">
                                    <div class="bg-amber-100 dark:bg-amber-900/30 p-2 rounded-full text-amber-600 dark:text-amber-400">
                                        <AlertTriangle class="w-4 h-4" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium">Approval Event: Request Pending</p>
                                        <p class="text-xs text-zinc-500">Host Robert Brown needs to approve visitor Mike Davis • 22 mins ago</p>
                                    </div>
                                </div>
                                <div class="p-4 flex items-start gap-4">
                                    <div class="bg-zinc-100 dark:bg-zinc-800 p-2 rounded-full text-zinc-600 dark:text-zinc-400">
                                        <UserX class="w-4 h-4" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium">Visitor Check-out: Sarah Connor</p>
                                        <p class="text-xs text-zinc-500">Automatic check-out via Kiosk • 1 hour ago</p>
                                    </div>
                                </div>
                                <div class="p-4 flex items-start gap-4">
                                    <div class="bg-red-100 dark:bg-red-900/30 p-2 rounded-full text-red-600 dark:text-red-400">
                                        <ShieldAlert class="w-4 h-4" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium">Security Alert: Watchlist Match</p>
                                        <p class="text-xs text-zinc-500">Attempted check-in matched watchlist criteria at Gate B. Security notified. • 2 hours ago</p>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
                
            </main>
        </div>
    </AdminSidebarLayout>
</template>
