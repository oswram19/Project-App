<script setup>
import { ref, onMounted, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);
const isDark = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};

onMounted(() => {
    const stored = localStorage.getItem('theme');
    if (stored === 'dark') {
        isDark.value = true;
        document.documentElement.classList.add('dark');
    }
});

watch(isDark, (value) => {
    localStorage.setItem('theme', value ? 'dark' : 'light');
    if (value) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
});
</script>

<template>
    <div>

        <Head :title="title" />

        <Banner />

        <div :class="['min-h-screen', isDark ? 'bg-gradient-to-br from-gray-900 via-gray-800 to-blue-900' : 'bg-gray-100']">
            <nav :class="isDark ? 'bg-gray-900/80 border-b border-gray-700 text-white' : 'bg-white border-b border-gray-100'">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                <ApplicationMark class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')" :dark="isDark">
                                    Dashboard
                                </NavLink>


                                <!-- acceso de admin -->
                                <a v-if="$page.props.can['admin.home']" :href="route('admin.home')"
                                    class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none border-transparent hover:border-gray-300 focus:border-gray-300"
                                    :class="isDark ? 'text-gray-200 hover:text-white focus:text-white' : 'text-gray-500 hover:text-gray-800 focus:text-gray-700'">
                                    Panel Administrador
                                </a>
                              

                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <!-- Botón modo claro/oscuro (luna/sol) -->
                            <button
                                type="button"
                                :class="['me-4 inline-flex items-center justify-center w-9 h-9 rounded-full shadow-sm transition',
                                         isDark ? 'border-gray-600 bg-gray-800 hover:bg-gray-700' : 'border-gray-300 bg-white/80 hover:bg-white']"
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
                            <div class="ms-3 relative">
                                <!-- Teams Dropdown: Solo visible para administradores con permiso admin.home -->
                                <Dropdown v-if="$page.props.jetstream.hasTeamFeatures && $page.props.can?.['admin.home'] && $page.props.auth.user.current_team" align="right" width="60">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.current_team?.name || 'Sin equipo' }}

                                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div class="w-60">
                                            <!-- Team Management -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                Gestionar grupo
                                            </div>

                                            <!-- Team Settings -->
                                            <DropdownLink v-if="$page.props.auth.user.current_team"
                                                :href="route('teams.show', $page.props.auth.user.current_team)">
                                                Opciones de grupo
                                            </DropdownLink>

                                            <DropdownLink v-if="$page.props.jetstream.canCreateTeams"
                                                :href="route('teams.create')">
                                                Crear nuevo grupo
                                            </DropdownLink>

                                            <!-- Team Switcher -->
                                            <template v-if="$page.props.auth.user.all_teams.length > 1">
                                                <div class="border-t border-gray-200" />

                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    Cambiar grupo
                                                </div>

                                                <template v-for="team in $page.props.auth.user.all_teams"
                                                    :key="team.id">
                                                    <form @submit.prevent="switchToTeam(team)">
                                                        <DropdownLink as="button">
                                                            <div class="flex items-center">
                                                                <svg v-if="team.id === $page.props.auth.user.current_team_id"
                                                                    class="me-2 h-5 w-5 text-green-400"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>

                                                                <div>{{ team.name }}</div>
                                                            </div>
                                                        </DropdownLink>
                                                    </form>
                                                </template>
                                            </template>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>

                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos"
                                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="h-8 w-8 rounded-full object-cover"
                                                :src="$page.props.auth.user.profile_photo_url"
                                                :alt="$page.props.auth.user.name">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Gestionar cuenta
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            Perfiles
                                        </DropdownLink>

                                        <!-- Gestionar grupo: Solo visible para administradores -->
                                        <DropdownLink v-if="$page.props.can?.['admin.home'] && $page.props.auth.user.current_team" 
                                            :href="route('teams.show', $page.props.auth.user.current_team)">
                                            Gestionar grupo
                                        </DropdownLink>

                                        <!-- Crear nuevo grupo: Restringido a administradores con capacidad de crear teams -->
                                        <DropdownLink v-if="$page.props.jetstream.canCreateTeams && $page.props.can?.['admin.home']"
                                            :href="route('teams.create')">
                                            Crear nuevo grupo
                                        </DropdownLink>

                                        <!-- link panel administrador  -->
                                        <a v-if="$page.props.can?.['admin.home']" :href="route('admin.home')"
                                            class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                            Panel Administrador
                                        </a>

                                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures"
                                            :href="route('api-tokens.index')">
                                            API Tokens
                                        </DropdownLink>

                                        <div class="border-t border-gray-200" />

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Salir
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Controles móviles: botón tema + hamburguesa -->
                        <div class="-me-2 flex items-center sm:hidden space-x-2">
                            <!-- Botón modo claro/oscuro (móvil) -->
                            <button
                                type="button"
                                :class="['inline-flex items-center justify-center w-8 h-8 rounded-full shadow-sm transition',
                                         isDark ? 'border-gray-600 bg-gray-800 hover:bg-gray-700' : 'border-gray-300 bg-white/80 hover:bg-white']"
                                @click="isDark = !isDark"
                                :aria-label="isDark ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro'"
                            >
                                <!-- Sol para modo oscuro activo (clic vuelve a claro) -->
                                <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
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
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 12.79A9 9 0 0 1 11.21 3 7 7 0 1 0 21 12.79z" />
                                </svg>
                            </button>

                            <!-- Botón menú hamburguesa -->
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                                @click="showingNavigationDropdown = !showingNavigationDropdown">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{ 'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path
                                        :class="{ 'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
                    class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')" :dark="isDark">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 me-3">
                                <img class="h-10 w-10 rounded-full object-cover"
                                    :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                            </div>

                            <div>
                                <div
                                    class="font-medium text-base"
                                    :class="isDark ? 'text-white' : 'text-gray-800'"
                                >
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div
                                    class="font-medium text-sm"
                                    :class="isDark ? 'text-gray-300' : 'text-gray-500'"
                                >
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')" :dark="isDark">
                                Perfil
                            </ResponsiveNavLink>

                            <a v-if="$page.props.can?.['admin.home']" :href="route('admin.home')"
                                class="block w-full px-4 py-2 text-left text-sm leading-5 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                :class="isDark ? 'text-gray-100' : 'text-gray-700'">
                                Panel Administrador
                            </a>

                            <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures"
                                :href="route('api-tokens.index')" :active="route().current('api-tokens.index')" :dark="isDark">
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button" :dark="isDark">
                                    Salir
                                </ResponsiveNavLink>
                            </form>

                            <!-- Team Management: Sección completa restringida solo a administradores -->
                            <template v-if="$page.props.jetstream.hasTeamFeatures && $page.props.can?.['admin.home']">
                                <div class="border-t border-gray-200" />

                                <!-- Título de sección (no tiene acción por eso aparece en gris) -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Gestionar grupo
                                </div>

                                <!-- Team Settings -->
                                <ResponsiveNavLink v-if="$page.props.auth.user.current_team"
                                    :href="route('teams.show', $page.props.auth.user.current_team)"
                                    :active="route().current('teams.show')"
                                    :dark="isDark">
                                    Opciones de grupo
                                </ResponsiveNavLink>

                                <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams"
                                    :href="route('teams.create')" :active="route().current('teams.create')"
                                    :dark="isDark">
                                    Crear nuevo grupo
                                </ResponsiveNavLink>

                                <!-- Team Switcher -->
                                <template v-if="$page.props.auth.user.all_teams.length > 1">
                                    <div class="border-t border-gray-200" />

                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Cambiar grupo
                                    </div>

                                    <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                        <form @submit.prevent="switchToTeam(team)">
                                            <ResponsiveNavLink as="button" :dark="isDark">
                                                <div class="flex items-center">
                                                    <svg v-if="team.id === $page.props.auth.user.current_team_id"
                                                        class="me-2 h-5 w-5 text-green-400"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </ResponsiveNavLink>
                                        </form>
                                    </template>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" :class="isDark ? 'bg-gray-900/80 shadow' : 'bg-white shadow'">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" :class="isDark ? 'text-white' : 'text-gray-800'">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
