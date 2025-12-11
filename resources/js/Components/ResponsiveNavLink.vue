<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    active: Boolean,
    href: String,
    as: String,
    dark: {
        type: Boolean,
        default: false,
    },
});

const classes = computed(() => {
    const base = 'block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium focus:outline-none transition duration-150 ease-in-out';

    if (props.active) {
        const activeLight = 'border-indigo-400 text-indigo-700 bg-indigo-50 focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700';
        const activeDark = 'border-indigo-400 text-white bg-indigo-900/40 focus:text-white focus:bg-indigo-900/60 focus:border-indigo-300';
        return `${base} ${props.dark ? activeDark : activeLight}`;
    }

    const inactiveLight = 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300';
    const inactiveDark = 'border-transparent text-gray-200 hover:text-white hover:bg-gray-800/60 hover:border-gray-600 focus:text-white focus:bg-gray-800/60 focus:border-gray-600';
    return `${base} ${props.dark ? inactiveDark : inactiveLight}`;
});
</script>

<template>
    <div>
        <button v-if="as == 'button'" :class="classes" class="w-full text-start">
            <slot />
        </button>

        <Link v-else :href="href" :class="classes">
            <slot />
        </Link>
    </div>
</template>
