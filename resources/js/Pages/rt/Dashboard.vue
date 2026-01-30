<script setup>
    import NavigationLayout from '@/Layouts/NavigationLayout.vue';
    import {
        Head,
    } from '@inertiajs/vue3';
    import {
        onMounted,
        computed,
        onUnmounted
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

    // data count dari controller
    const props = defineProps({
        kk: {
            type: Number,
            default: 0
        },
        warga: {
            type: Number,
            default: 0
        },
        pemuda: {
            type: Number,
            default: 0
        },
        lansia: {
            type: Number,
            default: 0
        },
        gender: {
            type: Array,
            default: () => []
        },
        status: {
            type: Array,
            default: () => []
        }
    });

    // Register Chart.js components
    Chart.register(...registerables);

    // Sample data (ganti dengan data asli dari backend)
    const stats = computed(() => [{
            name: 'Total Kepala Keluarga',
            value: props.kk || 0,
            icon: UserGroupIcon,
            change: '+12%',
            changeType: 'increase'
        },
        {
            name: 'Total Warga',
            value: props.warga || 0,
            icon: UserIcon,
            change: '+8%',
            changeType: 'increase'
        },
        {
            name: 'Pemuda/Pemudi',
            value: props.pemuda || 0,
            icon: UserIcon,
            change: '+5%',
            changeType: 'increase'
        },
        {
            name: 'Lansia',
            value: props.lansia || 0,
            icon: UserIcon,
            change: '-2%',
            changeType: 'decrease'
        },
    ]);

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
    let statusChart = null;

    // Format data untuk chart
    const genderData = computed(() => {
        const data = {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: ['#EC4899', '#3B82F6'],
                borderWidth: 0,
            }]
        };

        if (props.gender && props.gender.length > 0) {
            const totalCount = props.gender.reduce((sum, item) => sum + item.count, 0);

            props.gender.forEach(item => {
                const label = item.jenis_kelamin === 'Laki-Laki' ? 'Laki-laki' : 'Perempuan';
                const percentage = ((item.count / totalCount) * 100).toFixed(1);

                data.labels.push(label);
                data.datasets[0].data.push(parseFloat(percentage));
            });
        } else {
            // Default jika tidak ada data
            data.labels = ['Laki-laki', 'Perempuan'];
            data.datasets[0].data = [50, 50];
        }

        return data;
    });

    // Format data untuk chart status (jumlah bukan persentase)
    const statusData = computed(() => {
        const data = {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: ['#10B981', '#EF4444', '#F59E0B'],
                borderWidth: 0,
            }]
        };

        if (props.status && props.status.length > 0) {
            props.status.forEach(item => {
                data.labels.push(item.status);
                data.datasets[0].data.push(item.count);
            });
        } else {
            // Default jika tidak ada data
            data.labels = ['Hidup', 'Meninggal', 'Pindah'];
            data.datasets[0].data = [0, 0, 0];
        }

        return data;
    });

    onMounted(() => {
        const ctx = document.getElementById('genderChart');
        if (ctx) {
            genderChart = new Chart(ctx, {
                type: 'doughnut',
                data: genderData.value,
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

        // Status Chart
        const statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            statusChart = new Chart(statusCtx, {
                type: 'bar',
                data: statusData.value,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Jumlah: ${context.raw}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }
    });

    onUnmounted(() => {
        if (genderChart) {
            genderChart.destroy();
        }
        if (statusChart) {
            statusChart.destroy();
        }
    });

    // chart status
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
                        :class="['bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow duration-200',
                            statIdx === 0 ? 'sm:rounded-l-lg' : '',
                            statIdx === stats.length - 1 ? 'sm:rounded-r-lg' : ''
                        ]">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="font-semibold text-gray-500">{{ stat . name }}</dt>
                            <div class="flex">
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ stat . value }}</dd>
                                <component :is="stat.icon"
                                    class="h-10 w-10 ml-20 flex-shrink-0 text-gray-500 hover:text-blue-500 transition-colors duration-200" />
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

            <div class="mt-8 grid grid-cols-1 gap-5 lg:grid-cols-2">
                <!-- Gender Chart -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Persentase Gender Warga</h3>
                        <div class="mt-6 h-80">
                            <canvas id="genderChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Jumlah Status Warga</h3>
                        <div class="mt-6 h-80">
                            <canvas id="statusChart"></canvas>
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
