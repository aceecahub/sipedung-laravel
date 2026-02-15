<script setup>
import NavigationLayout from "@/Layouts/NavigationLayout.vue";
import Modal from "@/Components/Modal.vue";
import Swal from "sweetalert2";
import { Head, router } from "@inertiajs/vue3";
import {
    PlusIcon,
    PencilSquareIcon,
    TrashIcon,
    BanknotesIcon,
    ArrowDownTrayIcon,
} from "@heroicons/vue/24/outline";
import { ref, computed } from "vue";

// Props
const props = defineProps({
    kas: {
        type: Array,
        required: true,
    },
    data_kk: {
        type: Array,
        default: () => [],
    },
    data_warga: {
        type: Array,
        default: () => [],
    },
});

// State modal
const showModal = ref(false);
const editId = ref(null); // null = create, angka = update

// Form reactive (create & update)
const form = ref({
    id_kk: "",
    id_warga: "",
    jumlah: "",
    tanggal: "",
    status_perelek: "",
    keterangan: "",
});

// Computed
const totalKas = computed(() => {
    return props.kas.reduce((sum, item) => sum + Number(item.jumlah), 0);
});

// Filter warga berdasarkan kepala keluarga yang dipilih
const filteredWarga = computed(() => {
    if (!form.value.id_kk) return [];
    return props.data_warga.filter((w) => w.id_kk == form.value.id_kk);
});

// Options untuk dropdown
const statusPerelekOptions = ["Ada", "Tidak Ada"];

// Helpers
const formatRupiah = (value) => {
    return new Intl.NumberFormat("id-ID").format(value);
};

const formatDate = (dateString) => {
    if (!dateString) return "-";
    const date = new Date(dateString);
    return date.toLocaleDateString("id-ID", {
        day: "2-digit",
        month: "long",
        year: "numeric",
    });
};

// Reset form & tutup modal
const resetForm = () => {
    form.value = {
        id_kk: "",
        id_warga: "",
        jumlah: "",
        tanggal: "",
        status_perelek: "",
        keterangan: "",
    };
    editId.value = null;
    showModal.value = false;
};

// Buka modal untuk tambah data
const openCreateModal = () => {
    resetForm(); // pastikan form kosong
    showModal.value = true;
};

// Buka modal untuk edit data
const openEditModal = (item) => {
    editId.value = item.id;
    form.value = {
        id_kk: item.id_kk,
        id_warga: item.id_warga,
        jumlah: item.jumlah,
        tanggal: item.tanggal,
        status_perelek: item.status_perelek,
        keterangan: item.keterangan || "",
    };
    showModal.value = true;
};

// Submit form (create atau update)
const submitForm = () => {
    const isUpdate = editId.value !== null;
    Swal.fire({
        title: "Mohon Tunggu...",
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });

    if (!isUpdate) {
        // --- LOGIC CREATE ---
        router.post(route("kas-agustus.store"), form.value, {
            preserveScroll: true,
            onSuccess: () => {
                resetForm();
                Swal.fire({
                    icon: "success",
                    title: "Berhasil Disimpan!",
                    text: "Data Kas Agustus baru telah ditambahkan ke sistem.",
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });
            },
            onError: (errors) => {
                Swal.fire({
                    icon: "error",
                    title: "Gagal Menyimpan",
                    text: "Periksa kembali inputan Anda.",
                });
            },
        });
    } else {
        // --- LOGIC UPDATE ---
        router.post(
            route("kas-agustus.update", editId.value),
            {
                ...form.value,
                _method: "put",
            },
            {
                preserveScroll: true,
                onSuccess: () => {
                    resetForm();
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil Diperbarui!",
                        text: "Data Kas Agustus telah berhasil diupdate.",
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                    });
                },
                onError: (errors) => {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal Memperbarui",
                        text: "Terjadi kesalahan saat mengupdate data.",
                    });
                },
            },
        );
    }
};

// Hapus data
const deleteKas = (id) => {
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route("kas-agustus.destroy", id), {
                preserveScroll: true,
                onSuccess: () => {
                    Swal.fire({
                        title: "Terhapus!",
                        text: "Data kas Agustus berhasil dihapus.",
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false,
                    });
                },
                onError: () => {
                    Swal.fire(
                        "Gagal!",
                        "Terjadi kesalahan saat menghapus data.",
                        "error",
                    );
                },
            });
        }
    });
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
                        Ringkasan data dan statistik Kas Agustus Kampung Anda
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
                            @click="openCreateModal"
                            class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200"
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
                                                Nama Kepala Keluarga
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
                                                    {{ item.kk?.nama || "–" }}
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
                                                                deleteKas(
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
                                                :colspan="7"
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
                    class="mt-6 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200/70"
                >
                    <div
                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between"
                    >
                        <div>
                            <p class="text-sm font-medium text-blue-800">
                                Total Kas Terkumpul Bulan Ini
                            </p>
                            <p class="text-2xl font-bold text-blue-900 mt-1">
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

            <!-- Modal untuk Create & Update -->
            <Modal :show="showModal" @close="resetForm">
                <template #default>
                    <div
                        class="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-xl bg-white shadow-xl p-6 md:p-8"
                    >
                        <!-- Close Button (X) -->
                        <button
                            type="button"
                            @click="resetForm"
                            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition-colors duration-150"
                            aria-label="Close"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>

                        <!-- Judul Modal -->
                        <div class="mb-6 pb-3 border-b border-gray-200">
                            <h2 class="text-xl font-bold text-gray-800">
                                {{
                                    editId
                                        ? "Update Data Kas Agustus"
                                        : "Tambah Data Kas Agustus"
                                }}
                            </h2>
                            <p class="text-sm text-gray-500 mt-1">
                                Lengkapi informasi di bawah ini dengan data yang
                                valid.
                            </p>
                        </div>

                        <!-- Form -->
                        <form @submit.prevent="submitForm" class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        for="id_kk"
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                        >Kepala Keluarga</label
                                    >
                                    <select
                                        id="id_kk"
                                        v-model="form.id_kk"
                                        required
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all duration-200 appearance-none"
                                    >
                                        <option value="" disabled selected>
                                            Pilih Kepala Keluarga
                                        </option>
                                        <option
                                            v-for="kk in data_kk"
                                            :key="kk.id_kk"
                                            :value="kk.id_kk"
                                        >
                                            {{ kk.nama }} ({{ kk.kk }})
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        for="id_warga"
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                        >Warga</label
                                    >
                                    <select
                                        id="id_warga"
                                        v-model="form.id_warga"
                                        required
                                        :disabled="!form.id_kk"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all duration-200 appearance-none disabled:bg-gray-100 disabled:cursor-not-allowed"
                                    >
                                        <option value="" disabled selected>
                                            Pilih Warga
                                        </option>
                                        <option
                                            v-for="warga in filteredWarga"
                                            :key="warga.id_warga"
                                            :value="warga.id_warga"
                                        >
                                            {{ warga.nama }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        for="jumlah"
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                        >Jumlah (Rp)</label
                                    >
                                    <input
                                        type="number"
                                        id="jumlah"
                                        v-model="form.jumlah"
                                        required
                                        min="0"
                                        placeholder="Contoh: 50000"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all duration-200"
                                    />
                                </div>
                                <div>
                                    <label
                                        for="tanggal"
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                        >Tanggal</label
                                    >
                                    <input
                                        type="date"
                                        id="tanggal"
                                        v-model="form.tanggal"
                                        required
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all duration-200"
                                    />
                                </div>
                            </div>

                            <div>
                                <label
                                    for="status_perelek"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Status Perelek</label
                                >
                                <select
                                    id="status_perelek"
                                    v-model="form.status_perelek"
                                    required
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all duration-200 appearance-none"
                                >
                                    <option value="" disabled>
                                        Pilih Status Perelek
                                    </option>
                                    <option
                                        v-for="status in statusPerelekOptions"
                                        :key="status"
                                        :value="status"
                                    >
                                        {{ status }}
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label
                                    for="keterangan"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Keterangan (Opsional)</label
                                >
                                <textarea
                                    id="keterangan"
                                    v-model="form.keterangan"
                                    rows="3"
                                    placeholder="Masukkan keterangan tambahan (opsional)"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all duration-200 resize-none"
                                ></textarea>
                            </div>

                            <!-- Tombol Simpan -->
                            <div class="flex justify-end space-x-3 pt-4">
                                <button
                                    type="button"
                                    @click="resetForm"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    class="px-6 py-2.5 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 focus:ring-2 focus:ring-emerald-500 focus:outline-none shadow-md hover:shadow-sm transition-all duration-200"
                                >
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </template>
            </Modal>
        </div>
    </NavigationLayout>
</template>
