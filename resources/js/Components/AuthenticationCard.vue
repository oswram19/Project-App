<script setup>
import { ref, onMounted, watch } from 'vue';

const isDark = ref(false);

onMounted(() => {
    const stored = localStorage.getItem('theme');
    if (stored === 'dark') {
        isDark.value = true;
    }
});

watch(isDark, (value) => {
    localStorage.setItem('theme', value ? 'dark' : 'light');
});
</script>

<template>
    <div
        :class="[
            'min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden',
            isDark ? 'bg-gradient-to-br from-gray-900 via-gray-800 to-blue-900' : 'bg-gray-100'
        ]"
    >
        <!-- Botón modo claro/oscuro (luna/sol) -->
        <div class="absolute top-4 right-4 z-20">
            <button
                type="button"
                class="inline-flex items-center justify-center w-9 h-9 rounded-full border border-gray-300 bg-white/80 hover:bg-white shadow-sm transition"
                @click="isDark = !isDark"
                :aria-label="isDark ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro'"
            >
                <!-- Sol para modo oscuro activo (clic vuelve a claro) -->
                <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="4" />
                    <line x1="12" y1="2" x2="12" y2="4" />
                    <line x1="12" y1="20" x2="12" y2="22" />
                    <line x1="4.93" y1="4.93" x2="6.34" y2="6.34" />
                    <line x1="17.66" y1="17.66" x2="19.07" y2="19.07" />
                    <line x1="2" y1="12" x2="4" y2="12" />
                    <line x1="20" y1="12" x2="22" y2="12" />
                    <line x1="4.93" y1="19.07" x2="6.34" y2="17.66" />
                    <line x1="17.66" y1="6.34" x2="19.07" y2="4.93" />
                </svg>

                <!-- Luna para modo claro activo (clic pasa a oscuro) -->
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12.79A9 9 0 0 1 11.21 3 7 7 0 1 0 21 12.79z" />
                </svg>
            </button>
        </div>
        <!-- Efecto de transparencia con círculos animados -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gray-500 rounded-full mix-blend-overlay filter blur-xl opacity-20 animate-blob"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-500 rounded-full mix-blend-overlay filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-indigo-500 rounded-full mix-blend-overlay filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative z-10">
            <slot name="logo" />
        </div>

        <div class="relative z-10 w-full sm:max-w-md mt-6 px-6 py-4 bg-white/95 backdrop-blur-md shadow-2xl overflow-hidden sm:rounded-lg border border-purple-500/30">
            <slot />
        </div>
    </div>
</template>

<style scoped>
@keyframes blob {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
