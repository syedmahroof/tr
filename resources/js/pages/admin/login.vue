<script setup lang="ts">
import { useForm, Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import PasswordInput from '@/components/PasswordInput.vue';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Loader2, AlertCircle } from '@lucide/vue';
import ThemeToggle from '@/components/ThemeToggle.vue';

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post('/admin/login', {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Admin Login" />
    
    <div class="min-h-screen flex items-center justify-center bg-zinc-50 dark:bg-zinc-950 relative overflow-hidden text-zinc-900 dark:text-zinc-100 transition-colors duration-300">
        
        <!-- Theme Toggle -->
        <div class="absolute top-6 right-6 z-50">
            <ThemeToggle />
        </div>

        <!-- Abstract gradient background -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-[25%] -left-[10%] w-[50%] h-[50%] bg-indigo-600/20 blur-[120px] rounded-full animate-pulse duration-[10000ms]" />
            <div class="absolute bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-blue-600/20 blur-[100px] rounded-full animate-pulse duration-[7000ms] delay-1000" />
        </div>

        <div class="z-10 w-full max-w-md px-4">
            <Card class="bg-white/80 dark:bg-zinc-900/60 backdrop-blur-xl border-zinc-200 dark:border-zinc-800 shadow-2xl overflow-hidden relative transition-colors duration-300">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 via-blue-500 to-indigo-500" />
                
                <CardHeader class="space-y-3 pb-6 pt-8 text-center">
                    <div class="mx-auto h-20 flex items-center justify-center mb-2">
                        <img src="/logo.png" alt="Entrio" class="h-full w-auto object-contain rounded-xl transition-all dark:drop-shadow-[0_0_12px_rgba(255,255,255,0.8)]" />
                    </div>
                    <CardTitle class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                        Login
                    </CardTitle>
                </CardHeader>
                
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-5">
                        <div class="space-y-2 text-left">
                            <Label for="email" class="text-zinc-700 dark:text-zinc-300 font-medium">Email Address</Label>
                            <Input 
                                id="email" 
                                type="email" 
                                v-model="form.email" 
                                required 
                                autofocus 
                                class="bg-zinc-50 dark:bg-zinc-950/50 border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 dark:placeholder:text-zinc-600 focus-visible:ring-indigo-500 focus-visible:border-indigo-500 transition-all h-11"
                                placeholder="admin@example.com"
                            />
                            <div v-if="form.errors.email" class="text-sm text-red-400 mt-1.5 flex items-center gap-1.5">
                                <AlertCircle class="w-3.5 h-3.5" />
                                {{ form.errors.email }}
                            </div>
                        </div>

                        <div class="space-y-2 text-left">
                            <div class="flex items-center justify-between">
                                <Label for="password" class="text-zinc-700 dark:text-zinc-300 font-medium">Password</Label>
                            </div>
                            <PasswordInput 
                                id="password" 
                                v-model="form.password" 
                                required 
                                class="bg-zinc-50 dark:bg-zinc-950/50 border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 dark:placeholder:text-zinc-600 focus-visible:ring-indigo-500 focus-visible:border-indigo-500 transition-all h-11"
                                placeholder="••••••••"
                            />
                        </div>

                        <Button 
                            type="submit" 
                            :disabled="form.processing" 
                            class="w-full h-11 bg-indigo-600 hover:bg-indigo-500 text-white font-medium transition-colors shadow-[0_0_15px_rgba(79,70,229,0.3)] hover:shadow-[0_0_20px_rgba(79,70,229,0.5)] border-0 mt-2"
                        >
                            <Loader2 v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                            <span v-else>Sign In</span>
                        </Button>

                        <div class="text-center mt-4 text-sm text-zinc-600 dark:text-zinc-400">
                            Don't have an admin account? 
                            <Link href="/admin/register" class="text-indigo-600 hover:text-indigo-500 font-medium">Register here</Link>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </div>
</template>
