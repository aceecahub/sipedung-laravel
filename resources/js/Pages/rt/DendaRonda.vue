<script setup>
import NavigationLayout from "@/Layouts/NavigationLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import { 
    BanknotesIcon, 
    CreditCardIcon, 
    CheckCircleIcon, 
    XCircleIcon,
    ArrowPathIcon,
    InformationCircleIcon
} from "@heroicons/vue/24/outline";

const props = defineProps({
    dendas: Array,
    summary: Object,
});

const formatRupiah = (number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number);
};

const updateStatus = (id, status) => {
    router.patch(route('denda-ronda.update', id), {
        status_pembayaran: status
    }, {
        preserveScroll: true
    });
};

const checkFines = () => {
    router.post(route('denda-ronda.generate'), {}, {
        preserveScroll: true
    });
};

</script>

<template>
    <Head title="Denda Ronda" />
    <NavigationLayout>
        <div class="px-4 sm:px-6 lg:px-8 py-8 mt-5">
            <div class="sm:flex sm:items-center mb-8">
                <div class="sm:flex-auto" data-aos="fade-up">
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        Manajemen Denda Ronda
                    </h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Kelola data denda untuk warga yang tidak mengikuti kegiatan ronda atau izin.
                    </p>
                </div>
                <div 
                    v-if="$page.props.auth.user.role !== 'kk'"
                    class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none flex gap-3"
                >
                    <button
                        @click="checkFines"
                        class="inline-flex items-center justify-center rounded-xl bg-blue-50 px-4 py-2.5 text-sm font-bold text-blue-700 border border-blue-100 hover:bg-blue-100 transition-all duration-300"
                    >
                        <ArrowPathIcon class="h-5 w-5 mr-2" />
                        Periksa Absen Kemarin
                    </button>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8" data-aos="fade-up" data-aos-delay="50">
                <div class="bg-gradient-to-br from-red-500 to-red-700 rounded-3xl p-8 text-white shadow-lg shadow-red-100 relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="flex items-center gap-4">
                        <div class="h-14 w-14 rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-md">
                            <CreditCardIcon class="h-8 w-8 text-white" />
                        </div>
                        <div>
                            <p class="text-xs font-bold text-red-100 uppercase tracking-widest leading-none mb-1">Total Belum Bayar</p>
                            <h3 class="text-3xl font-black">{{ formatRupiah(summary.total_belum_bayar) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-3xl p-8 text-white shadow-lg shadow-green-100 relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="flex items-center gap-4">
                        <div class="h-14 w-14 rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-md">
                            <CheckCircleIcon class="h-8 w-8 text-white" />
                        </div>
                        <div>
                            <p class="text-xs font-bold text-green-100 uppercase tracking-widest leading-none mb-1">Total Lunas</p>
                            <h3 class="text-3xl font-black">{{ formatRupiah(summary.total_lunas) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                    <h3 class="text-xl font-bold text-gray-900 tracking-tight">Daftar Denda Warga</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Warga</th>
                                <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th 
                                    v-if="$page.props.auth.user.role !== 'kk'"
                                    class="px-8 py-5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider"
                                >
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 bg-white">
                            <tr v-for="denda in dendas" :key="denda.id_denda" class="hover:bg-gray-50 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-600 shadow-sm border border-slate-200 uppercase">
                                            {{ denda.kepala_keluarga?.nama.substring(0, 2) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900">{{ denda.kepala_keluarga?.nama }}</div>
                                            <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">KK: {{ denda.kepala_keluarga?.kk }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-sm text-gray-700 font-medium">{{ denda.deskripsi }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-sm font-black text-gray-900">{{ formatRupiah(denda.jumlah) }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-sm text-gray-500 font-medium">{{ new Date(denda.tanggal).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <span 
                                        :class="[
                                            denda.status_pembayaran === 'Lunas' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700',
                                            'px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest'
                                        ]"
                                    >
                                        {{ denda.status_pembayaran }}
                                    </span>
                                </td>
                                <td 
                                    v-if="$page.props.auth.user.role !== 'kk'"
                                    class="px-8 py-6 text-right"
                                >
                                    <div class="flex justify-end gap-2">
                                        <button 
                                            v-if="denda.status_pembayaran === 'Belum Bayar'"
                                            @click="updateStatus(denda.id_denda, 'Lunas')"
                                            class="p-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-500 hover:text-white transition-all duration-300 shadow-sm border border-green-100"
                                            title="Tandai Lunas"
                                        >
                                            <CheckCircleIcon class="h-5 w-5" />
                                        </button>
                                        <button 
                                            v-else
                                            @click="updateStatus(denda.id_denda, 'Belum Bayar')"
                                            class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-500 hover:text-white transition-all duration-300 shadow-sm border border-red-100"
                                            title="Tandai Belum Lunas"
                                        >
                                            <XCircleIcon class="h-5 w-5" />
                                        </button>
                                    </div>
                                </td>
                                <td v-else class="px-8 py-6 text-right text-sm text-gray-400 font-medium">
                                    -
                                </td>
                            </tr>
                            <tr v-if="dendas.length === 0">
                                <td colspan="6" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="h-20 w-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100 border-dashed">
                                            <InformationCircleIcon class="h-10 w-10 text-gray-300" />
                                        </div>
                                        <p class="text-gray-500 font-bold">Belum ada data denda ronda.</p>
                                        <p class="text-gray-400 text-sm mt-1">Denda akan muncul jika ada warga yang izin atau tidak hadir.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </NavigationLayout>
</template>
