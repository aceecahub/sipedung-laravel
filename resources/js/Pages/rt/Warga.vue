<script setup>
    import {
        router,
        Head
    } from '@inertiajs/vue3';
    import Swal from 'sweetalert2';
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
        },
        kk: {
            type: Array,
            default: () => []
        },
        user: {
            type: Array,
            default: () => []
        }
    });

    // State modal
    const showModal = ref(false);
    const editId = ref(null); // null = create, angka = update

    // Form reactive (create & update)
    const form = ref({
        id_user: '',
        id_kk: '',
        nik: '',
        nama: '',
        tempat_lahir: '',
        tanggal_lahir: '',
        alamat: '',
        nohp: '',
        jenis_kelamin: '',
        status_perkawinan: '',
        pekerjaan: '',
        goldar: '',
        status: 'Hidup'
    });

    // Pilihan untuk select
    const kkOptions = props.kk.map(kk => ({
        id: kk.id_kk,
        nama: kk.nama
    }));
    const userOptions = props.user.map(user => ({
        value: user.id_user,
        email: user.email
    }));

    const jenisKelaminOptions = ['Laki-Laki', 'Perempuan'];
    const statusPerkawinanOptions = ['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati'];
    const goldarOptions = ['A', 'B', 'AB', 'O'];
    const statusOptions = ['Hidup', 'Meninggal', 'Pindah'];

    // Reset form & tutup modal
    const resetForm = () => {
        form.value = {
            id_user: '',
            id_kk: '',
            nik: '',
            nama: '',
            tempat_lahir: '',
            tanggal_lahir: '',
            alamat: '',
            nohp: '',
            jenis_kelamin: '',
            status_perkawinan: '',
            pekerjaan: '',
            goldar: '',
            status: 'Hidup',
        };
        editId.value = null;
        showModal.value = false;
    };

    // Buka modal untuk tambah data
    const openCreateModal = () => {
        resetForm();
        showModal.value = true;
    };

    // Buka modal untuk edit data
    const openEditModal = (item) => {
        editId.value = item.id_warga;
        form.value = {
            ...item
        }; // ambil dari props.kk
        showModal.value = true;
    };

    // Submit form (create atau update)
    const submitForm = () => {
        const isUpdate = editId.value !== null;
        Swal.fire({
            title: 'Mohon Tunggu...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        if (!isUpdate) {
            // --- LOGIC CREATE ---
            router.post(route('warga.store'), form.value, {
                preserveScroll: true,
                onSuccess: () => {
                    resetForm();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Disimpan!',
                        text: 'Data warga baru telah ditambahkan ke sistem.',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                },
                onError: (errors) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan',
                        text: 'Periksa kembali inputan Anda.',
                    });
                }
            });
        } else {
            // --- LOGIC UPDATE ---
            router.post(route('warga.update', editId.value), {
                ...form.value,
                _method: 'put',
            }, {
                preserveScroll: true,
                onSuccess: () => {
                    resetForm();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Diperbarui!',
                        text: 'Data warga telah berhasil diupdate.',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                },
                onError: (errors) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memperbarui',
                        text: 'Terjadi kesalahan saat mengupdate data.',
                    });
                }
            });
        }
    };
    // Hapus data
    const deleteWarga = (id) => {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                router.delete(route('warga.destroy', id), {
                    preserveScroll: true,
                    onSuccess: () => {
                        Swal.fire({
                            title: 'Terhapus!',
                            text: 'Data warga berhasil dihapus.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    },
                    onError: () => {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat menghapus data.',
                            'error'
                        );
                    }
                });
            }
        });
    };
</script>

<template>

    <Head title="Warga" />
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
                                <div v-if="kk.length > 0"
                                    class="p-2 flex items-center justify-between border-t border-gray-200 pt-4">
                                    <div class="text-sm text-gray-700">
                                        Menampilkan <span class="font-bold">1</span> hingga <span
                                            class="font-bold">10</span> dari
                                        <span class="font-bold">{{ totalData }}</span> hasil
                                    </div>
                                    <div class="flex space-x-2">
                                        <!-- Previous Button -->
                                        <button
                                            class="relative inline-flex items-center px-3 py-2 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-100"
                                            :disabled="currentPage === 1" v-if="currentPage > 1">
                                            Sebelumnya
                                        </button>

                                        <!-- Page Numbers -->
                                        <button v-for="page in [1, 2, 3]" :key="page"
                                            class="relative inline-flex items-center px-3 py-2 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-100"
                                            :class="{ 'bg-blue-50 text-blue-700 border-blue-500': page === 1 }">
                                            {{ page }}
                                        </button>

                                        <!-- Next Button -->
                                        <button
                                            class="relative inline-flex items-center px-3 py-2 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-100">
                                            Selanjutnya
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal untuk Create & Update -->
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
                                {{ editId ? 'Update Data Warga' : 'Tambah Data Warga' }}
                            </h2>
                            <p class="text-sm text-gray-500 mt-1">
                                Lengkapi informasi di bawah ini dengan data yang valid.
                            </p>
                        </div>

                        <!-- Form -->
                        <form @submit.prevent="submitForm" class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="id_kk" class="block text-sm font-medium text-gray-700 mb-1">Kepala
                                        Keluarga</label>
                                    <select id="id_kk" v-model="form.id_kk" required
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 appearance-none">
                                        <option value="" disabled>Pilih Kepala Keluarga</option>
                                        <option v-for="kk in kkOptions" :key="kk.id" :value="kk.id">
                                            {{ kk . nama }}
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label for="nik"
                                        class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                                    <input type="text" inputmode="numeric" id="nik" v-model="form.nik"
                                        required placeholder="Masukkan NIK"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                        Lengkap</label>
                                    <input type="text" id="nama" v-model="form.nama" required
                                        placeholder="Masukkan nama lengkap"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200" />
                                </div>
                                <div>
                                    <label for="id_user" class="block text-sm font-medium text-gray-700 mb-1">Email
                                        Pengguna</label>
                                    <select id="id_user" v-model="form.id_user" required
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 appearance-none">
                                        <option value="" disabled>Pilih Email Pengguna</option>
                                        <option v-for="user in userOptions" :key="user.id_user"
                                            :value="user.value">
                                            {{ user . email }}
                                        </option>
                                    </select>
                                </div>
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
                                    <label for="jenis_kelamin"
                                        class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                    <select id="jenis_kelamin" v-model="form.jenis_kelamin" required
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 appearance-none">
                                        <option value="" disabled>Pilih Jenis Kelamin</option>
                                        <option v-for="jk in jenisKelaminOptions" :key="jk"
                                            :value="jk">{{ jk }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="status_perkawinan"
                                        class="block text-sm font-medium text-gray-700 mb-1">Status Perkawinan</label>
                                    <select id="status_perkawinan" v-model="form.status_perkawinan" required
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 appearance-none">
                                        <option value="" disabled>Pilih Status Perkawinan</option>
                                        <option v-for="status in statusPerkawinanOptions" :key="status"
                                            :value="status">{{ status }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="pekerjaan"
                                        class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
                                    <input type="text" id="pekerjaan" v-model="form.pekerjaan"
                                        placeholder="Contoh: Wiraswasta"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200" />
                                </div>
                                <div>
                                    <label for="goldar"
                                        class="block text-sm font-medium text-gray-700 mb-1">Golongan Darah</label>
                                    <select id="goldar" v-model="form.goldar"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 appearance-none">
                                        <option value="" disabled>Pilih Golongan Darah</option>
                                        <option v-for="goldar in goldarOptions" :key="goldar"
                                            :value="goldar">{{ goldar }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="nohp" class="block text-sm font-medium text-gray-700 mb-1">No.
                                        HP</label>
                                    <input type="tel" id="nohp" v-model="form.nohp" required
                                        placeholder="Contoh: 081234567890"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200" />
                                </div>
                                <div>
                                    <label for="status"
                                        class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select id="status" v-model="form.status" required
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 appearance-none">
                                        <option v-for="status in statusOptions" :key="status"
                                            :value="status">{{ status }}</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="alamat"
                                    class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                                <textarea id="alamat" v-model="form.alamat" required rows="3" placeholder="Masukkan alamat lengkap"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end space-x-3 pt-4">
                                <button type="button" @click="resetForm"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    {{ editId ? 'Update' : 'Simpan' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </template>
            </Modal>

        </div>
    </NavigationLayout>
</template>
