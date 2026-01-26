<script setup>
    import NavigationLayout from '@/Layouts/NavigationLayout.vue';
    import {
        ref
    } from 'vue';
    import {
        DocumentArrowDownIcon,
        MagnifyingGlassIcon,
        TrashIcon,
        PencilSquareIcon,
    } from '@heroicons/vue/24/outline';

    // Dummy data for pagination
    const currentPage = ref(1);
    const totalData = 5; // Update this with actual data length when connected to backend
    const itemsPerPage = 10;
</script>

<template>
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
            <div class="mt-8 flow-root">
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
                                                No. KK
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
                                        <tr v-for="(item, index) in Array(5)" :key="index"
                                            class="hover:bg-slate-50 transition-colors duration-150">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-500 sm:pl-6">
                                                {{ index + 1 }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                                3201234567890001</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                                3201234567890123</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">Ahmad Fauzi
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">Bandung</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">15/08/1990
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">Jl. Kenanga
                                                No. 12 RT 01/RW 05</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">081234567890
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">Laki-laki</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">Menikah</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">Wiraswasta
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">O</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">Hidup</td>
                                            <td
                                                class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <button @click="openEditModal(item)"
                                                    class="text-blue-600 hover:text-blue-900 mr-4">
                                                    <PencilSquareIcon class="h-5 w-5 inline" />
                                                </button>
                                                <button @click="deleteItem(item.id_warga)"
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
                                        <span class="font-bold">{{ totalData }}</span> hasil
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
        </div>
    </NavigationLayout>
</template>
