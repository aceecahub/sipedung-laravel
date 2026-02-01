<script setup>
    import {
        ref,
        onMounted,
        onUnmounted
    } from 'vue';
    import {
        Link,
        usePage
    } from '@inertiajs/vue3';
    import {
        HomeIcon,
        CircleStackIcon,
        WalletIcon,
        FingerPrintIcon,
        Cog6ToothIcon,
        ArrowLeftOnRectangleIcon,
        UserIcon,
        UserGroupIcon,
        BanknotesIcon,
        CreditCardIcon,
    } from '@heroicons/vue/24/outline';

    const navigation = [{
            name: 'Dashboard',
            icon: HomeIcon,
            href: '/dashboard'
        },
        {
            name: 'Data Master',
            icon: CircleStackIcon,
            children: [{
                    name: 'Kepala Keluarga',
                    href: '/kepala-keluarga',
                    icon: UserIcon
                },
                {
                    name: 'Data Warga',
                    href: '/warga',
                    icon: UserGroupIcon
                }
            ]
        },
        {
            name: 'Kauangan', // Catatan: typo, seharusnya "Keuangan"
            icon: WalletIcon,
            children: [{
                    name: '17 agustus',
                    href: '/kas-agustus',
                    icon:  BanknotesIcon
                },
                {
                    name: 'Denda Ronda',
                    href: '/denda-ronda',
                    icon: CreditCardIcon
                }
            ]
        },
        {
            name: 'Presensi',
            icon: FingerPrintIcon,
            children: [{
                    name: 'Ronda',
                    href: '/ronda',
                    icon: UserIcon
                },
                {
                    name: 'Pengajian',
                    href: '/pengajian',
                    icon: UserIcon
                }
            ]
        },
        {
            name: 'Pengaturan',
            icon: Cog6ToothIcon,
            href: '/pengaturan' // Diperbaiki dari '/kepala-keluarga'
        },
    ];

    // Dropdown untuk Data Master
    const openSubMenu = ref('');

    const toggleSubMenu = (menuName) => {
        openSubMenu.value = openSubMenu.value === menuName ? '' : menuName;
    };

    // Fungsi cek route aktif
    const isActive = (path) => {
        const currentUrl = usePage().url;
        return currentUrl === path || currentUrl === path + '/';
    };

    // --- Bagian lain tetap sama ---
    const isCollapsed = ref(false);
    const isProfileMenuOpen = ref(false);
    const profileMenuRef = ref(null);

    const toggleSidebar = () => {
        isCollapsed.value = !isCollapsed.value;
    };

    const toggleProfileMenu = () => {
        isProfileMenuOpen.value = !isProfileMenuOpen.value;
    };

    const handleClickOutside = (event) => {
        if (profileMenuRef.value && !profileMenuRef.value.contains(event.target)) {
            isProfileMenuOpen.value = false;
        }
    };

    onMounted(() => {
        document.addEventListener('click', handleClickOutside);
    });

    onUnmounted(() => {
        document.removeEventListener('click', handleClickOutside);
    });

    const page = usePage();
</script>

<template>
    <header class="fixed top-0 left-0 right-0 h-16 bg-white shadow-md z-30 flex items-center justify-between px-6">
        <div class="md:hidden">
            <button @click="toggleSidebar" class="text-gray-600 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>
        <div></div>
        <div class="flex items-center space-x-4">
            <div class="relative" ref="profileMenuRef">
                <button @click="toggleProfileMenu" class="flex items-center space-x-2">
                    <div
                        class="w-9 h-9 rounded-full bg-blue-500 flex items-center justify-center text-white font-medium text-sm">
                        {{ page . props . auth . user . name . substring(0, 2) . toUpperCase() }}
                    </div>
                    <span
                        class="hidden md:inline text-sm font-medium text-gray-700">{{ page . props . auth . user . name }}</span>
                    <svg :class="['h-4 w-4 text-gray-400 transform transition-transform duration-200', isProfileMenuOpen ?
                        'rotate-180' : ''
                    ]"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <transition enter-active-class="transition ease-out duration-100"
                    enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                    <div v-show="isProfileMenuOpen"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <Link href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil
                        Saya</Link>
                        <Link href="/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Pengaturan</Link>
                        <div class="border-t border-gray-100"></div>
                        <Link href="/logout" method="post" as="button"
                            class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        Keluar
                        </Link>
                    </div>
                </transition>
            </div>
        </div>
    </header>
    <div class="flex h-screen bg-gray-50">
        <div
            :class="[
                'fixed inset-y-0 left-0 transform transition-all duration-300 ease-in-out z-50',
                isCollapsed ? '-translate-x-full' : 'translate-x-0',
                'bg-white w-64',
                'flex flex-col px-4 py-6 shadow-2xl',
                'md:relative md:translate-x-0'
            ]">
            <div class="flex items-center justify-between mb-10">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-500 flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-lg">KK</span>
                    </div>
                    <h1 class="text-black text-lg font-semibold tracking-tight">Kampung Kendung</h1>
                </div>
                <button @click="toggleSidebar" class="md:hidden text-slate-300 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1">
                <ul class="space-y-1">
                    <li v-for="item in navigation" :key="item.name">
                        <!-- Item dengan children (dropdown) -->
                        <div v-if="item.children" class="relative">
                            <button type="button" @click="toggleSubMenu(item.name)"
                                class="flex items-center justify-between w-full px-4 py-3 rounded-xl transition-all duration-200 text-slate-800 hover:bg-slate-100"
                                :class="[
                                    openSubMenu === item.name || item.children.some(c => isActive(c.href)) ?
                                    'bg-slate-200 text-slate-700' :
                                    ''
                                ]">
                                <div class="flex items-center">
                                    <component :is="item.icon"
                                        class="h-5 w-5 mr-3 flex-shrink-0 text-slate-800" />
                                    <span class="font-medium">{{ item . name }}</span>
                                </div>
                                <svg :class="[
                                    'h-4 w-4 transition-transform duration-200',
                                    openSubMenu === item.name ? 'rotate-90 text-slate-700' : 'text-black'
                                ]"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>

                            <!-- Dropdown anak -->
                            <ul v-show="openSubMenu === item.name || item.children.some(c => isActive(c.href))"
                                class="mt-1 ml-4 space-y-1">
                                <li v-for="child in item.children" :key="child.href">
                                    <Link :href="child.href"
                                        :class="[
                                            'flex items-center w-full px-4 py-2 rounded-lg transition-all duration-200 text-sm font-medium',
                                            isActive(child.href) ?
                                            'bg-blue-600 text-white' :
                                            'text-slate-800 hover:bg-slate-100'
                                        ]">
                                        <div class="flex gap-2">
                                    <component :is="child.icon" class="h-5"  />
                                    {{ child . name }}
                                    </div>
                                    </Link>
                                </li>
                            </ul>
                        </div>

                        <!-- Item tanpa children -->
                        <Link v-else-if="item.href" :href="item.href"
                            :class="[
                                'flex items-center w-full px-4 py-3 rounded-xl transition-all duration-200',
                                isActive(item.href) ?
                                'bg-blue-600 text-white shadow-sm' :
                                'text-slate-700 hover:bg-slate-100 hover:text-slate-800'
                            ]">
                        <component :is="item.icon" class="h-5 w-5 mr-3 flex-shrink-0"
                            :class="isActive(item.href) ? 'text-white' : 'text-slate-800'" />
                        <span class="font-medium">{{ item . name }}</span>
                        </Link>
                    </li>
                </ul>
            </nav>

            <div class="mt-auto"></div>
        </div>

        <div v-if="!isCollapsed" @click="toggleSidebar" class="fixed inset-0 bg-black/40 z-40 md:hidden"></div>

        <div class="flex-1 flex flex-col overflow-hidden pt-16 md:pt-0">
            <main class="flex-1 overflow-y-auto md:p-6 bg-gray-50">
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
    * {
        transition: all 0.2s ease-in-out;
    }

    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.3);
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(148, 163, 184, 0.5);
    }
</style>
