<script setup>
    import {
        Head
    } from '@inertiajs/vue3'

    import {
        DocumentArrowDownIcon,
        MagnifyingGlassIcon
    } from '@heroicons/vue/24/outline';
    import NavigationLayout from '@/Layouts/NavigationLayout.vue';
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
                    </button>
                </div>
            </div>

            <!-- Table Section -->
            <div class="flex justify-between mt-10">
                <div class="flex gap-3">
                    <input type="text" class="rounded-xl h-9 border-gray-300" placeholder="Cari Kepala Keluarga">
                    <button class="bg-blue-500 rounded-md py-1 px-2 text-white hover:bg-blue-600 transition-colors duration-200">
                        <MagnifyingGlassIcon class="h-5"/></button>
                </div>
                <button class="bg-blue-500 rounded-md py-1 px-2 text-white hover:bg-blue-600 transition-colors duration-200">
                    + Kepala Keluarga</button>
            </div>
            <div class="mt-4 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                            No</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Nama</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">NIK</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Alamat
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">RT/RW</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <!-- Dummy data – ganti dengan v-for saat integrasi data -->
                                    <tr class="hover:bg-slate-50 transition-colors duration-150" v-for="(item, index) in Array(5)" :key="index">
                                        <td
                                            class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            {{ index + 1 }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">Ahmad Fauzi</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">3201234567890123
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">Jl. Kenanga No. 12
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">03/02</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                            <button class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                                            <button class="text-red-600 hover:text-red-900">Hapus</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </NavigationLayout>
</template>
