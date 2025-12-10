<script setup>
import { Link } from '@inertiajs/vue3';

const handleClick = (e) => {
    e.preventDefault();
    alert('¡Bienvenido, inicia sesion !');
};
</script>

<template>
    <a href="#" @click="handleClick">
        <svg
            class="w-16 h-16"
            viewBox="0 0 64 64"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <!-- Círculo base con gradiente -->
            <circle cx="32" cy="32" r="30" fill="url(#gradient1)" />
            
            <!-- Diseño de aplicación con código -->
            <rect x="18" y="20" width="28" height="24" rx="2" fill="white" opacity="0.95"/>
            
            <!-- Líneas de código -->
            <line x1="22" y1="25" x2="32" y2="25" stroke="#4F46E5" stroke-width="1.5" stroke-linecap="round"/>
            <line x1="22" y1="29" x2="38" y2="29" stroke="#4F46E5" stroke-width="1.5" stroke-linecap="round"/>
            <line x1="22" y1="33" x2="35" y2="33" stroke="#4F46E5" stroke-width="1.5" stroke-linecap="round"/>
            <line x1="22" y1="37" x2="30" y2="37" stroke="#4F46E5" stroke-width="1.5" stroke-linecap="round"/>
            
            <!-- Símbolo de aplicación/desarrollo -->
            <path d="M28 40 L32 44 L36 40" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            
            <defs>
                <linearGradient id="gradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:#4F46E5;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#7C3AED;stop-opacity:1" />
                </linearGradient>
            </defs>
        </svg>
    </a>
</template>
