<script setup>
import NavigationLayout from "@/Layouts/NavigationLayout.vue";
import { Head } from "@inertiajs/vue3";
import { onMounted, computed, onUnmounted } from "vue";
import { Chart, registerables } from "chart.js";
import {
    UserIcon,
    UserGroupIcon,
    DocumentArrowDownIcon,
    MagnifyingGlassIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    kk: {
        type: Number,
        default: 0,
    },
    warga: {
        type: [Array, Number],
        default: 0,
    },
    pemudaCount: {
        type: Number,
        default: 0,
    },
    pemuda: {
        type: [Array, Number],
        default: () => [],
    },
    lansia: {
        type: Number,
        default: 0,
    },
    gender: {
        type: Array,
        default: () => [],
    },
    status: {
        type: Array,
        default: () => [],
    },
});

// Register Chart.js components
Chart.register(...registerables);

// Helpers to get count
const getCount = (val) => {
    if (Array.isArray(val)) return val.length;
    if (typeof val === "number") return val;
    return 0;
};

// Sample data (ganti dengan data asli dari backend)
const stats = computed(() => [
    {
        name: "Total Kepala Keluarga",
        value: props.kk || 0,
        icon: UserGroupIcon,
        change: "+12%",
        changeType: "increase",
    },
    {
        name: "Total Warga",
        value: getCount(props.warga),
        icon: UserIcon,
        change: "+8%",
        changeType: "decrease",
    },
    {
        name: "Pemuda/Pemudi",
        value: props.pemudaCount || 0,
        icon: UserIcon,
        change: "+5%",
        changeType: "increase",
    },
    {
        name: "Lansia",
        value: props.lansia || 0,
        icon: UserIcon,
        change: "-2%",
        changeType: "decrease",
    },
]);

const activities = [
    {
        id: 1,
        user: "Budi Santoso",
        action: "Menambahkan data warga baru",
        time: "10 menit yang lalu",
    },
    {
        id: 2,
        user: "Siti Rahayu",
        action: "Memperbarui data KK",
        time: "1 jam yang lalu",
    },
    {
        id: 3,
        user: "Ahmad Fauzi",
        action: "Menghapus data warga",
        time: "2 jam yang lalu",
    },
    {
        id: 4,
        user: "Dewi Lestari",
        action: "Menambahkan data pemuda/pemudi",
        time: "3 jam yang lalu",
    },
];

// Inisialisasi chart
let genderChart = null;
let statusChart = null;

// Format data untuk chart
const genderData = computed(() => {
    const colorGender = {
        "Laki-laki": "#3B82F6", // Blue
        Perempuan: "#EC4899", // Pink
    };

    const data = {
        labels: [],
        datasets: [
            {
                data: [],
                backgroundColor: [],
                borderWidth: 0,
            },
        ],
    };

    if (props.gender && props.gender.length > 0) {
        const totalCount = props.gender.reduce(
            (sum, item) => sum + item.count,
            0,
        );

        props.gender.forEach((item) => {
            const label =
                item.jenis_kelamin === "Laki-Laki" ? "Laki-laki" : "Perempuan";
            const percentage = ((item.count / totalCount) * 100).toFixed(1);

            data.labels.push(label);
            data.datasets[0].data.push(parseFloat(percentage));
            data.datasets[0].backgroundColor.push(
                colorGender[label] || "#9CA3AF",
            );
        });
    } else {
        // Default jika tidak ada data
        data.labels = ["Laki-laki", "Perempuan"];
        data.datasets[0].data = [50, 50];
        data.datasets[0].backgroundColor = [
            colorGender["Laki-laki"],
            colorGender["Perempuan"],
        ];
    }

    return data;
});

// Format data untuk chart status (jumlah bukan persentase)
const statusData = computed(() => {
    const colorMap = {
        Hidup: "#10B981",
        Meninggal: "#EF4444",
        Pindah: "#F59E0B",
    };

    const data = {
        labels: [],
        datasets: [
            {
                data: [],
                backgroundColor: [],
                borderWidth: 0,
            },
        ],
    };

    if (props.status && props.status.length > 0) {
        props.status.forEach((item) => {
            data.labels.push(item.status);
            data.datasets[0].data.push(item.count);
            data.datasets[0].backgroundColor.push(
                colorMap[item.status] || "#9CA3AF",
            );
        });
    } else {
        // Default jika tidak ada data
        data.labels = ["Hidup", "Meninggal", "Pindah"];
        data.datasets[0].data = [0, 0, 0];
        data.datasets[0].backgroundColor = [
            colorMap["Hidup"],
            colorMap["Meninggal"],
            colorMap["Pindah"],
        ];
    }

    return data;
});

onMounted(() => {
    const ctx = document.getElementById("genderChart");
    if (ctx) {
        genderChart = new Chart(ctx, {
            type: "doughnut",
            data: genderData.value,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: "bottom",
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return `${context.label}: ${context.raw}%`;
                            },
                        },
                    },
                },
                cutout: "70%",
            },
        });
    }

    // Status Chart
    const statusCtx = document.getElementById("statusChart");
    if (statusCtx) {
        statusChart = new Chart(statusCtx, {
            type: "bar",
            data: statusData.value,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return `Jumlah: ${context.raw}`;
                            },
                        },
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                        },
                    },
                },
            },
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

// Unified props handle everything above
</script>

<template>
    <Head title="Dashboard RT" />
    <NavigationLayout>
        <div class="px-4 sm:px-6 lg:px-8 py-8 mt-5">
            <!-- Header -->
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1
                        class="text-2xl font-bold text-gray-900"
                        data-aos="fade-up"
                    >
                        Dashboard RT
                    </h1>
                    <p
                        class="mt-2 text-sm text-gray-700"
                        data-aos="fade-up"
                        data-aos-delay="50"
                    >
                        Ringkasan data dan statistik warga Kampung Anda
                    </p>
                </div>
                <div
                    class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none"
                    data-aos="fade-up"
                >
                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-green-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-600 transition-colors duration-200 sm:w-auto"
                    >
                        <DocumentArrowDownIcon class="h-5 w-5 mr-2" />
                        Download Laporan
                    </button>
                </div>
            </div>

            <!-- Stats -->
            <div class="mt-8" data-aos="fade-up" data-aos-delay="100">
                <div
                    class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4"
                >
                    <div
                        v-for="(stat, statIdx) in stats"
                        :key="stat.name"
                        class="relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 group"
                    >
                        <!-- Gradient backgrounds untuk setiap kartu -->
                        <div
                            :class="[
                                'absolute inset-0',
                                statIdx === 0
                                    ? 'bg-gradient-to-br from-blue-400 to-blue-600'
                                    : statIdx === 1
                                      ? 'bg-gradient-to-br from-green-400 to-green-600'
                                      : statIdx === 2
                                        ? 'bg-gradient-to-br from-purple-400 to-purple-600'
                                        : 'bg-gradient-to-br from-orange-400 to-orange-600',
                            ]"
                        ></div>

                        <!-- Decorative element -->
                        <div
                            class="absolute -top-8 -right-8 w-32 h-32 rounded-full opacity-20 bg-slate-200"
                        ></div>

                        <div class="relative px-6 py-8 sm:p-8">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <dt
                                        class="text-xl font-bold text-white text-opacity-90"
                                    >
                                        {{ stat.name }}
                                    </dt>
                                    <dd
                                        class="mt-3 text-4xl font-bold text-white"
                                    >
                                        {{ stat.value }}
                                    </dd>
                                    <div class="mt-4">
                                        <span
                                            :class="[
                                                stat.changeType === 'increase'
                                                    ? 'bg-green-500 text-white'
                                                    : 'bg-red-500 text-white',
                                                'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold',
                                            ]"
                                        >
                                            {{ stat.change }}
                                        </span>
                                        <span
                                            class="text-xs text-white text-opacity-80 ml-2"
                                            >dari bulan lalu</span
                                        >
                                    </div>
                                </div>
                                <div class="flex-shrink-0 ml-8">
                                    <div
                                        class="flex items-center justify-center h-14 w-14 rounded-lg bg-white bg-opacity-20 group-hover:bg-opacity-30 transition-all duration-200"
                                    >
                                        <component
                                            :is="stat.icon"
                                            class="h-8 w-8 text-white"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2"
                data-aos="fade-up"
                data-aos-delay="120"
            >
                <!-- Gender Chart -->
                <div
                    class="bg-white overflow-hidden shadow-lg rounded-xl hover:shadow-xl transition-shadow duration-300"
                >
                    <div class="px-6 py-8">
                        <div class="flex items-center">
                            <div class="w-full">
                                <h3 class="text-lg font-bold text-gray-900">
                                    Persentase Gender Warga
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    Distribusi jenis kelamin warga
                                </p>
                            </div>
                        </div>
                        <div class="mt-8 h-80">
                            <canvas id="genderChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Status Chart -->
                <div
                    class="bg-white overflow-hidden shadow-lg rounded-xl hover:shadow-xl transition-shadow duration-300"
                >
                    <div class="px-6 py-8">
                        <div class="flex items-center">
                            <div class="w-full">
                                <h3 class="text-lg font-bold text-gray-900">
                                    Jumlah Status Warga
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    Status hidup, meninggal, dan pindah
                                </p>
                            </div>
                        </div>
                        <div class="mt-8 h-80">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Table Pemuda -->
                <div
                    class="p-6 mt-4 bg-white rounded-xl shadow-md ring-1 ring-gray-200 lg:col-span-2"
                >
                    <!-- Header Section -->
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-900">
                            Tabel Pemuda
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Daftar pemuda/pemudi organisasi
                        </p>
                    </div>

                    <!-- Search & Add Button -->
                    <div class="flex justify-between mt-2">
                        <div class="flex gap-3">
                            <input
                                type="text"
                                class="rounded-xl h-9 border border-gray-300 px-3"
                                placeholder="Cari Pemuda"
                            />
                            <button
                                class="bg-blue-500 rounded-md py-1 px-2 text-white hover:bg-blue-600 transition-colors duration-200"
                            >
                                <MagnifyingGlassIcon class="h-5 w-5" />
                            </button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="mt-4 flow-root">
                        <div
                            class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8"
                        >
                            <div
                                class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8"
                            >
                                <div
                                    class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg"
                                >
                                    <table
                                        class="min-w-full divide-y divide-gray-300"
                                    >
                                        <thead class="bg-gray-200">
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                                >
                                                    No
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Nama Pemuda/I
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Jabatan
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Status
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="divide-y divide-gray-200 bg-white"
                                        >
                                            <template
                                                v-if="
                                                    Array.isArray(pemuda) &&
                                                    pemuda.length > 0
                                                "
                                            >
                                                <tr
                                                    v-for="(
                                                        item, index
                                                    ) in pemuda"
                                                    :key="item.id_pemuda"
                                                    class="hover:bg-slate-50 transition-colors duration-150"
                                                >
                                                    <td
                                                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                                    >
                                                        {{ index + 1 }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap py-4 text-sm text-gray-700"
                                                    >
                                                        {{
                                                            item.warga?.nama ||
                                                            "-"
                                                        }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-700"
                                                    >
                                                        {{ item.jabatan }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap px-3 py-4 text-sm"
                                                    >
                                                        <span
                                                            :class="[
                                                                item.status ===
                                                                'Aktif'
                                                                    ? 'bg-green-100 text-green-800'
                                                                    : 'bg-red-100 text-red-800',
                                                                'inline-flex rounded-full px-2 text-xs font-semibold leading-5',
                                                            ]"
                                                        >
                                                            {{ item.status }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </template>

                                            <!-- empty data -->
                                            <tr v-else>
                                                <td
                                                    :colspan="9"
                                                    class="py-12 text-center"
                                                >
                                                    <div
                                                        class="inline-flex flex-col items-center"
                                                    >
                                                        <div
                                                            class="bg-gray-100 border-2 border-dashed rounded-xl w-16 h-16 flex items-center justify-center mb-3"
                                                        >
                                                            <UserIcon
                                                                class="h-7 w-7 text-gray-400"
                                                            />
                                                        </div>
                                                        <p
                                                            class="text-sm font-medium text-gray-600"
                                                        >
                                                            Belum ada data
                                                            pemuda
                                                        </p>
                                                        <p
                                                            class="text-xs text-gray-500 mt-1"
                                                        >
                                                            Klik tombol "Tambah
                                                            Pemuda" untuk
                                                            memulai
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Recent Activity -->
                <div
                    class="bg-white shadow-lg overflow-hidden rounded-xl hover:shadow-xl transition-shadow duration-300 lg:col-span-2"
                >
                    <div class="px-6 py-8 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900">
                            Aktivitas Terkini
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Riwayat perubahan data terbaru
                        </p>
                    </div>
                    <div>
                        <ul role="list" class="divide-y divide-gray-100">
                            <li
                                v-for="activity in activities"
                                :key="activity.id"
                                class="px-6 py-5 hover:bg-gray-50 transition-colors duration-200"
                            >
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center shadow-md"
                                        >
                                            <span
                                                class="text-white font-bold text-sm"
                                                >{{
                                                    activity.user.charAt(0)
                                                }}</span
                                            >
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p
                                            class="text-sm font-semibold text-gray-900"
                                        >
                                            {{ activity.user }}
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ activity.action }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p
                                            class="text-sm font-medium text-gray-500"
                                        >
                                            {{ activity.time }}
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
/* Smooth transitions for cards */
:deep(.group) {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Enhanced hover effects */
@media (hover: hover) {
    :deep(.group:hover) {
        transform: translateY(-4px);
    }
}

/* Add subtle animation on page load */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Improved text rendering */
h1,
h3 {
    letter-spacing: -0.01em;
}
</style>
