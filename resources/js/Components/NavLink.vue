<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
    dark: {
        type: Boolean,
        default: false,
    },
});

const classes = computed(() => {
    const base = 'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out';

    if (props.active) {
        const activeLight = 'border-indigo-400 text-gray-900 focus:border-indigo-700';
        const activeDark = 'border-indigo-400 text-white focus:border-indigo-300';
        return `${base} ${props.dark ? activeDark : activeLight}`;
    }

    const inactiveLight = 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300';
    const inactiveDark = 'border-transparent text-gray-200 hover:text-white hover:border-gray-500 focus:text-white focus:border-gray-500';
    return `${base} ${props.dark ? inactiveDark : inactiveLight}`;
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
