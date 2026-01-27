<script setup>
    import { router, Head } from '@inertiajs/vue3';
    import NavigationLayout from '@/Layouts/NavigationLayout.vue';
    import Modal from '@/Components/Modal.vue';
    import {
        ref
    } from 'vue';
    import {
        DocumentArrowDownIcon,
        MagnifyingGlassIcon,
        TrashIcon,
        PencilSquareIcon,
    } from '@heroicons/vue/24/outline';

    // Ambil data dari controller dengan props
    const props = defineProps({
        warga: {
            type: Array,
            default: () => []
        }
    })

    // Modal
    // ShowModal
    const ShowModal = ref(false)


    // Hapus data
    const deleteWarga = (id) => {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            router.delete(route('warga.destroy', id), {
                preserveScroll: true,
                onSuccess: () => {
                    alert('Data berhasil dihapus');
                },
            });
        }
    };

    // Dummy data for pagination
    const currentPage = ref(1);
    const totalData = 5; // Update this with actual data length when connected to backend
    const itemsPerPage = 10;
</script>

<template>
    <Head title="Warga"/>
    <NavigationLayout>
        <div class="px-4 sm:px-6 lg:px-8 py-8 mt-5">
            <!-- Header -->
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-bold text-gray-900">Warga</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Ringkasan data dan statistik Warga Kampung Anda
                    </p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-green-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-600 transition-colors duration-200">
                        <DocumentArrowDownIcon class="h-5 w-5 mr-1" />
                        Download Laporan
                    </button>
                </div>
            </div>

            <!-- Search & Add Button -->
            <div class="flex justify-between mt-10">
                <div class="flex gap-3">
                    <input type="text" class="rounded-xl h-9 border border-gray-300 px-3" placeholder="Cari Warga" />
                    <button
                        class="bg-blue-500 rounded-md py-1 px-2 text-white hover:bg-blue-600 transition-colors duration-200">
                        <MagnifyingGlassIcon class="h-5 w-5" />
                    </button>
                </div>
                <button @click="openCreateModal"
                    class="bg-blue-500 rounded-md py-1 px-2 text-white hover:bg-blue-600 transition-colors duration-200">
                    + Warga
                </button>
            </div>

            <!-- Table Section -->
            <div class="mt-4 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-200">
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 whitespace-nowrap">
                                                No
                                            </th>
                                            <th scope="col"
                                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900 whitespace-nowrap">
                                                NIK
                                            </th>
                                            <th scope="col"
                                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900 whitespace-nowrap">
                                                Nama
                                            </th>
                                            <th scope="col"
                                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900 whitespace-nowrap">
                                                Tempat Lahir
                                            </th>
                                            <th scope="col"
                                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900 whitespace-nowrap">
                                                Tgl. Lahir
                                            </th>
                                            <th scope="col"
                                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900 whitespace-nowrap">
                                                Alamat
                                            </th>
                                            <th scope="col"
                                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900 whitespace-nowrap">
                                                No. HP
                                            </th>
                                            <th scope="col"
                                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900 whitespace-nowrap">
                                                Jenis Kelamin
                                            </th>
                                            <th scope="col"
                                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900 whitespace-nowrap">
                                                Status Kawin
                                            </th>
                                            <th scope="col"
                                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900 whitespace-nowrap">
                                                Pekerjaan
                                            </th>
                                            <th scope="col"
                                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900 whitespace-nowrap">
                                                Gol. Darah
                                            </th>
                                            <th scope="col"
                                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900 whitespace-nowrap">
                                                Status
                                            </th>
                                            <th scope="col"
                                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900 whitespace-nowrap">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        <tr v-for="(item, index) in warga" :key="item.id_warga"
                                            class="hover:bg-slate-50 transition-colors duration-150">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-500 sm:pl-6">
                                                {{ index + 1 }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                                {{ item . nik }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                                {{ item . nama }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                                {{ item . tempat_lahir }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                                {{ item . tanggal_lahir }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                                {{ item . alamat }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                                {{ item . nohp }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                                {{ item . jenis_kelamin }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                                {{ item . status_perkawinan }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                                {{ item . pekerjaan }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                                {{ item . goldar }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                                {{ item . status }}</td>
                                            <td
                                                class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <button @click="openEditModal(item)"
                                                    class="text-blue-600 hover:text-blue-900 mr-4">
                                                    <PencilSquareIcon class="h-5 w-5 inline" />
                                                </button>
                                                <button @click="deleteWarga(item.id_warga)"
                                                    class="text-red-600 hover:text-red-900">
                                                    <TrashIcon class="h-5 w-5 inline" />
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                <div v-if="totalData > 0"
                                    class="p-2 flex items-center justify-between border-t border-gray-200 pt-4">
                                    <div class="text-sm text-gray-700">
                                        Menampilkan <span class="font-bold">1</span> hingga <span
                                            class="font-bold">{{ Math . min(itemsPerPage, totalData) }}</span> dari
                                        <span class="font-bold">{{ totalData }}</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <!-- Previous Button -->
                                        <button
                                            class="relative inline-flex items-center px-3 py-2 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-100"
                                            :disabled="currentPage === 1" @click="currentPage--"
                                            :class="{ 'opacity-50 cursor-not-allowed': currentPage === 1 }"
                                            v-if="currentPage > 1">
                                            Sebelumnya
                                        </button>

                                        <!-- Page Numbers -->
                                        <button v-for="page in [1, 2, 3]" :key="page"
                                            class="relative inline-flex items-center px-3 py-2 rounded-md border text-sm font-medium"
                                            :class="{
                                                'bg-blue-50 text-blue-700 border-blue-500': page === currentPage,
                                                'border-gray-300 bg-white text-gray-700 hover:bg-gray-100': page !==
                                                    currentPage
                                            }"
                                            @click="currentPage = page">
                                            {{ page }}
                                        </button>

                                        <!-- Next Button -->
                                        <button
                                            class="relative inline-flex items-center px-3 py-2 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-100"
                                            @click="currentPage++">
                                            Selanjutnya
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <Modal :show="showModal" @close="resetForm">
                <template #default>
                    <div
                        class="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-xl bg-white shadow-xl p-6 md:p-8">
                        <!-- Close Button (X) -->
                        <button type="button" @click="resetForm"
                            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition-colors duration-150"
                            aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <!-- Judul Modal -->
                        <div class="mb-6 pb-3 border-b border-gray-200">
                            <h2 class="text-xl font-bold text-gray-800">
                                {{ editId ? 'Update Data Kepala Keluarga' : 'Tambah Data Kepala Keluarga' }}
                            </h2>
                            <p class="text-sm text-gray-500 mt-1">
                                Lengkapi informasi di bawah ini dengan data yang valid.
                            </p>
                        </div>

                        <!-- Form -->
                        <form @submit.prevent="submitForm" class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="kk" class="block text-sm font-medium text-gray-700 mb-1">No.
                                        Kartu
                                        Keluarga</label>
                                    <input type="text" inputmode="numeric" id="kk" v-model="form.kk"
                                        required placeholder="Contoh: 3201021234567890"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200" />
                                </div>
                                <div>
                                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">No.
                                        NIK</label>
                                    <input type="text" inputmode="numeric" id="nik" v-model="form.nik"
                                        required placeholder="Contoh: 3201029876543210"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200" />
                                </div>
                            </div>

                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                    Lengkap</label>
                                <input type="text" id="nama" v-model="form.nama" required
                                    placeholder="Masukkan nama lengkap"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="tempat_lahir"
                                        class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                                    <input type="text" id="tempat_lahir" v-model="form.tempat_lahir" required
                                        placeholder="Contoh: Bandung"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200" />
                                </div>
                                <div>
                                    <label for="tanggal_lahir"
                                        class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                                    <input type="date" id="tanggal_lahir" v-model="form.tanggal_lahir" required
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="nohp" class="block text-sm font-medium text-gray-700 mb-1">No.
                                        HP</label>
                                    <input type="text" id="nohp" v-model="form.nohp" required
                                        placeholder="Contoh: 081234567890"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200" />
                                </div>
                                <div>
                                    <label for="pekerjaan"
                                        class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
                                    <input type="text" id="pekerjaan" v-model="form.pekerjaan" required
                                        placeholder="Contoh: Wiraswasta"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200" />
                                </div>
                            </div>

                            <div>
                                <label for="agama"
                                    class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                                <select id="agama" v-model="form.agama" required
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 appearance-none">
                                    <option value="" disabled>Pilih Agama</option>
                                    <option v-for="agama in agamaOptions" :key="agama"
                                        :value="agama">
                                        {{ agama }}
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat
                                    Lengkap</label>
                                <input type="text" id="alamat" v-model="form.alamat" required
                                    placeholder="Masukkan alamat lengkap"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200" />
                            </div>

                            <!-- Tombol Simpan -->
                            <div class="flex justify-end pt-2">
                                <button type="submit"
                                    class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-md hover:shadow-sm transition-all duration-200">
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
