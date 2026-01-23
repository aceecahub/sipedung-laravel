<script setup>
    import NavigationLayout from '@/Layouts/NavigationLayout.vue';
    import {
        Head,
    } from '@inertiajs/vue3';
    import {
        onMounted
    } from 'vue';
    import {
        Chart,
        registerables
    } from 'chart.js';
    import {
        UserIcon,
        UserGroupIcon,
        DocumentArrowDownIcon
    } from '@heroicons/vue/24/outline';

    // Register Chart.js components
    Chart.register(...registerables);

    // Sample data (ganti dengan data asli dari backend)
    const stats = [{
            name: 'Total Kepala Keluarga',
            value: '19',
            icon: UserGroupIcon,
            change: '+12%',
            changeType: 'increase'
        },
        {
            name: 'Total Warga',
            value: '200',
            icon: UserIcon,
            change: '+8%',
            changeType: 'increase'
        },
        {
            name: 'Pemuda/Pemudi',
            value: '29',
            icon: UserIcon,
            change: '+5%',
            changeType: 'increase'
        },
        {
            name: 'Lansia',
            value: '20',
            icon: UserIcon,
            change: '-2%',
            changeType: 'decrease'
        },
    ];

    const activities = [{
            id: 1,
            user: 'Budi Santoso',
            action: 'Menambahkan data warga baru',
            time: '10 menit yang lalu'
        },
        {
            id: 2,
            user: 'Siti Rahayu',
            action: 'Memperbarui data KK',
            time: '1 jam yang lalu'
        },
        {
            id: 3,
            user: 'Ahmad Fauzi',
            action: 'Menghapus data warga',
            time: '2 jam yang lalu'
        },
        {
            id: 4,
            user: 'Dewi Lestari',
            action: 'Menambahkan data pemuda/pemudi',
            time: '3 jam yang lalu'
        },
    ];

    // Inisialisasi chart
    let genderChart = null;

    onMounted(() => {
        const ctx = document.getElementById('genderChart');
        if (ctx) {
            genderChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Laki-laki', 'Perempuan'],
                    datasets: [{
                        data: [52, 48],
                        backgroundColor: ['#3B82F6', '#EC4899'],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.label}: ${context.raw}%`;
                                }
                            }
                        }
                    },
                    cutout: '70%',
                }
            });
        }
    });
</script>

<template>

    <Head title="Dashboard RT" />
    <NavigationLayout>
        <div class="px-4 sm:px-6 lg:px-8 py-8 mt-5">
            <!-- Header -->
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard RT</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Ringkasan data dan statistik warga Kampung Anda
                    </p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-green-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-600 transition-colors duration-200 sm:w-auto">
                        <DocumentArrowDownIcon class="h-5 w-5 mr-2" />
                        Download Laporan
                    </button>
                </div>
            </div>

            <!-- Stats -->
            <div class="mt-4">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <div v-for="(stat, statIdx) in stats" :key="stat.name"
                        :class="['bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow duration-200', statIdx === 0 ? 'sm:rounded-l-lg' : '',
                            statIdx === stats.length - 1 ? 'sm:rounded-r-lg' : ''
                        ]">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="font-semibold text-gray-500">{{ stat . name }}</dt>
                            <div class="flex">
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ stat . value }}</dd>
                                <component :is="stat.icon" class="h-10 w-10 ml-20 flex-shrink-0 text-gray-500 hover:text-blue-500 transition-colors duration-200" />
                            </div>
                            <div class="mt-2">
                                <span
                                    :class="[
                                        stat.changeType === 'increase' ? 'bg-green-100 text-green-800' :
                                        'bg-red-100 text-red-800',
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium'
                                    ]">
                                    {{ stat . change }}
                                </span>
                                <span class="text-sm text-gray-500 ml-1">dari bulan lalu</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="mt-8 grid grid-cols-1 gap-5 lg:grid-cols-2">
                <!-- Gender Chart -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Persentase Gender</h3>
                        <div class="mt-6 h-80">
                            <canvas id="genderChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Aktivitas Terkini</h3>
                    </div>
                    <div class="border-t border-gray-200">
                        <ul role="list" class="divide-y divide-gray-200">
                            <li v-for="activity in activities" :key="activity.id" class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span
                                                class="text-indigo-600 font-medium">{{ activity . user . charAt(0) }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ activity . user }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate">
                                            {{ activity . action }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">
                                            {{ activity . time }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </NavigationLayout>
</template>

<style scoped>
    /* Custom styles if needed */
</style>
