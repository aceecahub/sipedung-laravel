<script setup>
    import {
        Head,
        router
    } from '@inertiajs/vue3';
    import {
        DocumentArrowDownIcon,
        MagnifyingGlassIcon,
        TrashIcon,
        PencilSquareIcon,
    } from '@heroicons/vue/24/outline';
    import NavigationLayout from '@/Layouts/NavigationLayout.vue';
    import Modal from '@/Components/Modal.vue';

    import {
        ref
    } from 'vue';

    // get api dari controller
    const props = defineProps({
        kk: Array,
    });

    // modal
    const showModal = ref(false);

    // form
    const form = ref({
        kk: '',
        nik: '',
        nama: '',
        tempat_lahir: '',
        tanggal_lahir: '',
        nohp: '',
        pekerjaan: '',
        agama: ''
    });

    const agamaOptions = ref({
        Islam: 'Islam',
        Keristen: 'Kristen',
        Khatolik: 'Khatolik',
        Hindu: 'Hindu',
        Budha: 'Budha'
    })

    const openModal = () => {
        showModal.value = true;
    };

    const submitForm = () => {
        // Handle form submission logic here
        console.log('Form data:', form.value);
        showModal.value = false;
    };

    // validasi delete data dari function destroy
    const deleteKk = (id) => {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {

            router.delete(route('kepala-keluarga.destroy', id), {
                preserveScroll: true,
                onSuccess: () => {
                    alert('Data berhasil dihapus');
                },
            });
        }
    };
</script>

<template>

    <Head title="Kepala Keluarga" />
    <NavigationLayout>
        <div class="px-4 sm:px-6 lg:px-8 py-8 mt-5">
            <!-- Header -->
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-bold text-gray-900">Kepala Keluarga</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Ringkasan data dan statistik Kepala Keluarga Kampung Anda
                    </p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-green-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-600 transition-colors duration-200 sm:w-auto">
                        <DocumentArrowDownIcon class="h-5 w-5" />
                        Download Laporan
                    </button>
                </div>
            </div>

            <!-- Table Section -->
            <div class="flex justify-between mt-10">
                <div class="flex gap-3">
                    <input type="text" class="rounded-xl h-9 border-gray-300" placeholder="Cari Kepala Keluarga">
                    <button
                        class="bg-blue-500 rounded-md py-1 px-2 text-white hover:bg-blue-600 transition-colors duration-200">
                        <MagnifyingGlassIcon class="h-5" />
                    </button>
                </div>
                <button @click="openModal"
                    class="bg-blue-500 rounded-md py-1 px-2 text-white hover:bg-blue-600 transition-colors duration-200">
                    + Kepala Keluarga</button>
            </div>
            <div class="mt-4 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                            No</th>
                                        <th scope="col"
                                            class=" py-3.5 text-left text-sm font-semibold text-gray-900">No. Kartu
                                            Keluarga</th>
                                        <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900">
                                            No. NIK</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Nama
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tempat
                                            Lahir</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tanggal
                                            Lahir</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">No HP</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Pekerjaan
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <!-- Dummy data – ganti dengan v-for saat integrasi data -->
                                    <tr class="hover:bg-slate-50 transition-colors duration-150"
                                        v-for="(items, index) in kk" :key="items.id_kk">
                                        <td
                                            class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            {{ index + 1 }}</td>
                                        <td class="whitespace-nowrap py-4 text-sm text-gray-700">
                                            {{ items . kk }}</td>
                                        <td class="whitespace-nowrap py-4 text-sm text-gray-700">
                                            {{ items . nik }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                            {{ items . nama }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                            {{ items . tempat_lahir }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                            {{ items . tanggal_lahir }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                            {{ items . nohp }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                            {{ items . pekerjaan }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                            <button
                                                class="text-blue-600 hover:text-blue-900 mr-3 p-1 rounded hover:bg-blue-50">
                                                <PencilSquareIcon class="h-5 w-5 inline" />
                                            </button>
                                            <button class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50"
                                                @click="deleteKk(items.id_kk)">
                                                <TrashIcon class="h-5 w-5 inline" />
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <Modal :show="showModal" @close="showModal = false">
                <template #default>
                    <div class="p-4">
                        <h2 class="text-lg font-bold mb-4">Tambah Data</h2>

                        <form @submit.prevent="submitForm" class="space-y-4 mt-4">
                            <div class="flex gap-3 w-full">
                                <div class="w-full">
                                    <label for="kk" class="block text-sm font-medium text-gray-700">No. Kartu
                                        Keluarga</label>
                                    <input type="text" inputmode="numeric" id="kk" v-model="form.kk" required placeholder="Masukan No. Kartu Keluarga"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring-blue-400 sm:text-sm" />
                                </div>
                                <div class="w-full">
                                    <label for="nik" class="block text-sm font-medium text-gray-700">No.
                                        NIK</label>
                                    <input type="text" inputmode="numeric" id="nik" v-model="form.nik" required placeholder="Masukan No. NIK"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring-blue-400 sm:text-sm" />
                                </div>
                            </div>
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                                <input type="text" id="nama" v-model="form.nama" required placeholder="Masukan Nama Lengkap"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring-blue-400 sm:text-sm" />
                            </div>
                            <div>
                                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat
                                    Lahir</label>
                                <input type="text" id="tempat_lahir" v-model="form.tempat_lahir" required placeholder="Masukan Tempat Lahir"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring-blue-400 sm:text-sm" />
                            </div>
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal
                                    Lahir</label>
                                <input type="date" id="tanggal_lahir" v-model="form.tanggal_lahir" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring-blue-400 sm:text-sm" />
                            </div>
                            <div class="flex gap-3 w-full">
                                <div class="w-full">
                                    <label for="nohp" class="block text-sm font-medium text-gray-700">No
                                        HP</label>
                                    <input type="text" id="nohp" v-model="form.nohp" required placeholder="Masukan No. Handphone"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring-blue-400 sm:text-sm" />
                                </div>
                                <div class="w-full">
                                    <label for="pekerjaan"
                                        class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                                    <input type="text" id="pekerjaan" v-model="form.pekerjaan" required placeholder="Masukan Pekerjaan"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring-blue-400 sm:text-sm" />
                                </div>
                            </div>
                            <div>
                                <label for="agama" class="block text-sm font-medium text-gray-700">Agama</label>
                                <select id="agama" v-model="form.agama" required
                                    class="mt-1 block w-1/2 rounded-md border border-gray-300 bg-white shadow-sm focus:border-blue-400 focus:ring-blue-400 sm:text-sm">
                                    <option value="" disabled>Pilih Agama</option>
                                    <option v-for="item in agamaOptions" :key="item" :value="item">
                                        {{ item }}</option>
                                </select>
                            </div>
                            <div class="pt-4">
                                <button type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                                    Simpan
                                </button>
                                <button @click="showModal = false"
                                    class="bg-slate-200 w-9 p-1 rounded-lg text-lg font-bold ml-auto block hover:bg-slate-300 hover:text-red-500 transition-colors duration-150">X</button>
                            </div>
                        </form>
                    </div>
                </template>
            </Modal>
        </div>
    </NavigationLayout>
</template>
