<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                oswaldo
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex flex-col items-center justify-center p-8">
                    <img src="/images/mantenimiento.webp" alt="En mantenimiento" class="w-125 h-125 mb-6">
                    <p class="text-lg text-gray-700 text-center">Actualmente estamos en mantenimiento de nuestro sitio web. Por favor, vuelva más tarde.</p>
                </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
