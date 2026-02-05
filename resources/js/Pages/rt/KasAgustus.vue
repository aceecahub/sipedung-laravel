<script setup>
import NavigationLayout from "@/Layouts/NavigationLayout.vue";
import { Head } from "@inertiajs/vue3";
import { computed } from "vue";

// Ikon
import {
    PlusIcon,
    PencilSquareIcon,
    TrashIcon,
    BanknotesIcon,
    ArrowDownTrayIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    kas: {
        type: Array,
        required: true,
    },
});

// Computed
const totalKas = computed(() => {
    return props.kas.reduce((sum, item) => sum + Number(item.jumlah), 0);
});

// Helpers
const formatRupiah = (value) => {
    return new Intl.NumberFormat("id-ID").format(value);
};

const formatDate = (dateString) => {
    if (!dateString) return "-";
    const date = new Date(dateString);
    return date.toLocaleDateString("id-ID", {
        day: "2-digit",
        month: "short",
        year: "numeric",
    });
};

// Actions
const openAddModal = () => {
    alert("Fitur tambah belum diimplementasi");
};

const openEditModal = (item) => {
    console.log("Edit item:", item);
};

const confirmDelete = (id) => {
    if (confirm("Hapus pembayaran ini?")) {
        console.log("Hapus ID:", id);
        // TODO: Implement delete logic with Inertia
    }
};
</script>

<template>
    <NavigationLayout>
        <Head title="Kas Agustus" />
        <div class="px-4 sm:px-6 lg:px-8 py-8 mt-5">
            <!-- Header -->
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-bold text-gray-900">
                        Kas 17 Agustus dan Perelek
                    </h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Ringkasan data dan statistik Kepala Keluarga Kampung
                        Anda
                    </p>
                </div>
            </div>
            <div
                class="p-6 mt-4 bg-white rounded-xl shadow-md ring-1 ring-gray-200"
            >
                <div
                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6"
                >
                    <h2 class="text-2xl font-bold text-gray-800">
                        Daftar Kas Agustus
                    </h2>
                    <div class="mt-4 sm:mt-0">
                        <button
                            @click="openAddModal"
                            class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200"
                        >
                            <PlusIcon class="h-4 w-4 mr-1.5" />
                            Tambah Pembayaran
                        </button>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div
                            class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8"
                        >
                            <div
                                class="overflow-hidden border border-gray-200 rounded-xl shadow"
                            >
                                <table
                                    class="min-w-full divide-y divide-gray-200"
                                >
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                scope="col"
                                                class="py-3.5 pl-6 pr-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider sm:pl-6"
                                            >
                                                No
                                            </th>
                                            <th
                                                scope="col"
                                                class="py-3.5 px-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                            >
                                                Nama Warga
                                            </th>
                                            <th
                                                scope="col"
                                                class="py-3.5 px-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                            >
                                                Jumlah (Rp)
                                            </th>
                                            <th
                                                scope="col"
                                                class="py-3.5 px-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                            >
                                                Tanggal
                                            </th>
                                            <th
                                                scope="col"
                                                class="py-3.5 px-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                            >
                                                Status Perelek
                                            </th>
                                            <th
                                                scope="col"
                                                class="py-3.5 px-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                            >
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="divide-y divide-gray-200 bg-white"
                                    >
                                        <template v-if="kas.length > 0">
                                            <tr
                                                v-for="(item, index) in kas"
                                                :key="item.id"
                                                class="hover:bg-gray-50/70 transition-colors duration-150"
                                            >
                                                <td
                                                    class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                                >
                                                    {{ index + 1 }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-700"
                                                >
                                                    {{ item.warga?.nama || "–" }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm font-medium text-emerald-700"
                                                >
                                                    {{
                                                        formatRupiah(
                                                            item.jumlah,
                                                        )
                                                    }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-600"
                                                >
                                                    {{
                                                        formatDate(item.tanggal)
                                                    }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4"
                                                >
                                                    <span
                                                        :class="{
                                                            'bg-emerald-100 text-emerald-800':
                                                                item.status_perelek ===
                                                                'Ada',
                                                            'bg-amber-100 text-amber-800':
                                                                item.status_perelek ===
                                                                'Tidak Ada',
                                                        }"
                                                        class="px-2.5 py-0.5 inline-flex text-xs font-medium rounded-full"
                                                    >
                                                        {{
                                                            item.status_perelek
                                                        }}
                                                    </span>
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                >
                                                    <div
                                                        class="flex space-x-1.5"
                                                    >
                                                        <button
                                                            @click="
                                                                openEditModal(
                                                                    item,
                                                                )
                                                            "
                                                            class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50 hover:text-blue-800 transition-colors duration-150"
                                                            aria-label="Edit"
                                                        >
                                                            <PencilSquareIcon
                                                                class="h-5"
                                                            />
                                                        </button>
                                                        <button
                                                            @click="
                                                                confirmDelete(
                                                                    item.id,
                                                                )
                                                            "
                                                            class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 hover:text-rose-800 transition-colors duration-150"
                                                            aria-label="Hapus"
                                                        >
                                                            <TrashIcon
                                                                class="h-5"
                                                            />
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>

                                        <!-- Empty State -->
                                        <tr v-else>
                                            <td
                                                :colspan="6"
                                                class="py-12 text-center"
                                            >
                                                <div
                                                    class="inline-flex flex-col items-center"
                                                >
                                                    <div
                                                        class="bg-gray-100 border-2 border-dashed rounded-xl w-16 h-16 flex items-center justify-center mb-3"
                                                    >
                                                        <BanknotesIcon
                                                            class="h-7 w-7 text-gray-400"
                                                        />
                                                    </div>
                                                    <p
                                                        class="text-sm font-medium text-gray-600"
                                                    >
                                                        Belum ada data kas
                                                        Agustus
                                                    </p>
                                                    <p
                                                        class="text-xs text-gray-500 mt-1"
                                                    >
                                                        Klik tombol "Tambah
                                                        Pembayaran" untuk
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

                <!-- Total Summary Card -->
                <div
                    class="mt-6 bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-xl p-4 border border-emerald-200/70"
                >
                    <div
                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between"
                    >
                        <div>
                            <p class="text-sm font-medium text-emerald-800">
                                Total Kas Terkumpul Bulan Ini
                            </p>
                            <p class="text-2xl font-bold text-emerald-900 mt-1">
                                Rp {{ formatRupiah(totalKas) }}
                            </p>
                        </div>
                        <div class="mt-3 sm:mt-0 flex-shrink-0">
                            <button
                                class="inline-flex items-center px-3.5 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200"
                            >
                                <ArrowDownTrayIcon class="h-4 w-4 mr-1.5" />
                                Export Laporan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </NavigationLayout>
</template>
