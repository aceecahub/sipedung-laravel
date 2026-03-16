<script setup>
import NavigationLayout from "@/Layouts/NavigationLayout.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import {
    UserIcon,
    CalendarIcon,
    UserGroupIcon,
    CheckBadgeIcon,
    ClockIcon,
    ExclamationTriangleIcon,
    ChevronRightIcon,
    InformationCircleIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    isKK: Boolean,
    kkData: Object,
    todayAttendance: Array,
    schedule: Object,
    allHistory: Array,
});

const page = usePage();
const activeTab = ref('schedule');

const tabs = [
    { id: 'schedule', name: 'Jadwal Ronda', icon: CalendarIcon },
    { id: 'today', name: 'Presensi Hari Ini', icon: CheckBadgeIcon },
    { id: 'history', name: 'Riwayat', icon: ClockIcon },
];

if (props.isKK) {
    tabs.push({ id: 'absen', name: 'Isi Absen', icon: UserGroupIcon });
}

// Form for attendance
const form = useForm({
    id_kk: props.kkData?.id_kk || '',
    status: 'Hadir',
    keterangan: '',
});

const submitAbsen = () => {
    form.post(route('ronda.store'), {
        onSuccess: () => {
            form.reset('keterangan');
            activeTab.value = 'today';
        },
    });
};

const getStatusColor = (status) => {
    switch (status) {
        case 'Hadir': return 'bg-green-100 text-green-800';
        case 'Izin': return 'bg-blue-100 text-blue-800';
        case 'Sakit': return 'bg-yellow-100 text-yellow-800';
        case 'Tanpa Keterangan': return 'bg-red-100 text-red-800';
        default: return 'bg-gray-100 text-gray-800';
    }
};

const dayNames = {
    '1': 'Senin',
    '2': 'Selasa',
    '3': 'Rabu',
    '4': 'Kamis',
    '5': 'Jumat',
    '6': 'Sabtu',
    '7': 'Minggu',
};

// Get current day of week (1-7, 1 is Monday)
const todayDayNum = new Date().getDay() === 0 ? 7 : new Date().getDay();
const todayGroup = props.schedule[todayDayNum] || [];

const isMyScheduleDay = computed(() => {
    if (!props.kkData) return false;
    return props.kkData.kelompok_ronda == todayDayNum;
});

const alreadyAbsented = computed(() => {
    if (!props.kkData) return false;
    return props.todayAttendance.some(a => a.id_kk === props.kkData.id_kk);
});

</script>

<template>
    <Head title="Manajemen Ronda" />
    <NavigationLayout>
        <div class="px-4 sm:px-6 lg:px-8 py-8 mt-5">
            <div class="sm:flex sm:items-center mb-8">
                <div class="sm:flex-auto" data-aos="fade-up">
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        Sistem Keamanan & Ronda
                    </h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Manajemen jadwal dan presensi ronda malam warga.
                    </p>
                </div>
            </div>

            <!-- Custom Tabs -->
            <div class="mb-8" data-aos="fade-up" data-aos-delay="50">
                <nav class="flex space-x-4 bg-white p-2 rounded-2xl shadow-sm border border-gray-100" aria-label="Tabs">
                    <button
                        v-for="tab in tabs"
                        :key="tab.id"
                        @click="activeTab = tab.id"
                        :class="[
                            activeTab === tab.id
                                ? 'bg-blue-600 text-white shadow-md'
                                : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50',
                            'px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 flex items-center gap-2'
                        ]"
                    >
                        <component :is="tab.icon" class="h-5 w-5" />
                        {{ tab.name }}
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="min-h-[400px]">
                <!-- Schedule Tab -->
                <div v-if="activeTab === 'schedule'" class="space-y-6" data-aos="fade-up">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div 
                            v-for="day in ['1', '2', '3', '4', '5', '6', '7']" 
                            :key="day"
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1"
                            :class="{ 'ring-2 ring-blue-500 border-transparent': day == todayDayNum }"
                        >
                            <div class="px-5 py-4 border-b border-gray-50 flex justify-between items-center"
                                :class="day == todayDayNum ? 'bg-blue-50' : 'bg-gray-50/50'">
                                <h3 class="font-bold text-gray-900 flex items-center gap-2">
                                    <span v-if="day == todayDayNum" class="flex h-2 w-2 rounded-full bg-blue-600 animate-pulse"></span>
                                    {{ dayNames[day] }}
                                </h3>
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Grup {{ day }}</span>
                            </div>
                            <div class="px-5 py-4">
                                <ul v-if="schedule[day] && schedule[day].length > 0" class="space-y-3">
                                    <li v-for="person in schedule[day]" :key="person.id_kk" class="flex items-center gap-3 text-sm text-gray-700">
                                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs uppercase">
                                            {{ person.nama.substring(0, 2) }}
                                        </div>
                                        <div class="flex-1 truncate">
                                            {{ person.nama }}
                                        </div>
                                    </li>
                                </ul>
                                <div v-else class="py-4 text-center">
                                    <p class="text-xs text-gray-400 italic">Belum ada anggota</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Today Attendance Tab -->
                <div v-if="activeTab === 'today'" data-aos="fade-up">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-8 border-b border-gray-50 flex flex-col md:flex-row justify-between items-center gap-4 bg-gradient-to-r from-blue-50 to-transparent">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 tracking-tight">Laporan Presensi Malam Ini</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ dayNames[todayDayNum] }}, {{ new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}</p>
                            </div>
                            <div class="flex gap-4">
                                <div class="bg-green-100 border border-green-200 px-6 py-3 rounded-2xl text-center shadow-sm">
                                    <div class="text-2xl font-black text-green-700 leading-tight">{{ todayAttendance.length }}</div>
                                    <div class="text-[10px] font-bold text-green-600 uppercase tracking-widest">Hadir/Izin</div>
                                </div>
                                <div class="bg-blue-100 border border-blue-200 px-6 py-3 rounded-2xl text-center shadow-sm">
                                    <div class="text-2xl font-black text-blue-700 leading-tight">{{ Math.max(0, todayGroup.length - todayAttendance.length) }}</div>
                                    <div class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Belum Absen</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama KK</th>
                                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Keterangan</th>
                                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu Absen</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 bg-white">
                                    <tr v-for="att in todayAttendance" :key="att.id_ronda" class="hover:bg-blue-50/30 transition-colors group">
                                        <td class="px-8 py-6">
                                            <div class="flex items-center gap-3">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white flex items-center justify-center font-bold shadow-sm">
                                                    {{ att.kepala_keluarga?.nama.substring(0, 2).toUpperCase() }}
                                                </div>
                                                <span class="font-bold text-gray-900 group-hover:text-blue-700 transition-colors">{{ att.kepala_keluarga?.nama }}</span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <span :class="[getStatusColor(att.status), 'px-3 py-1.5 rounded-full text-xs font-black uppercase tracking-wide']">
                                                {{ att.status }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-6 text-sm text-gray-600">
                                            {{ att.keterangan || '-' }}
                                        </td>
                                        <td class="px-8 py-6 text-sm text-gray-500 font-medium">
                                            {{ new Date(att.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) }}
                                        </td>
                                    </tr>
                                    <tr v-if="todayAttendance.length === 0">
                                        <td colspan="4" class="px-8 py-20 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="h-20 w-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                                    <CalendarIcon class="h-10 w-10 text-gray-300" />
                                                </div>
                                                <p class="text-gray-500 font-bold">Belum ada warga yang melapor malam ini.</p>
                                                <p class="text-gray-400 text-sm mt-1">Status akan muncul otomatis di sini.</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- History Tab -->
                <div v-if="activeTab === 'history'" data-aos="fade-up">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                            <h3 class="text-xl font-bold text-gray-900 tracking-tight">Riwayat Ronda</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama KK</th>
                                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 bg-white">
                                    <tr v-for="hist in allHistory" :key="hist.id_ronda" class="hover:bg-gray-50 transition-colors">
                                        <td class="px-8 py-6 text-sm font-bold text-gray-900">
                                            {{ new Date(hist.tanggal).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                                        </td>
                                        <td class="px-8 py-6">
                                            <span class="font-medium text-gray-700">{{ hist.kepala_keluarga?.nama }}</span>
                                        </td>
                                        <td class="px-8 py-6">
                                            <span :class="[getStatusColor(hist.status), 'px-3 py-1.5 rounded-full text-xs font-black uppercase tracking-wide']">
                                                {{ hist.status }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-6 text-sm text-gray-600">
                                            {{ hist.keterangan || '-' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Absen Tab (KK Only) -->
                <div v-if="activeTab === 'absen' && isKK" data-aos="zoom-in" class="max-w-2xl mx-auto">
                    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-10 text-white relative overflow-hidden">
                            <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                            <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-black/10 rounded-full blur-2xl"></div>
                            
                            <h3 class="text-2xl font-black tracking-tight leading-tight">Lapor Ronda Malam</h3>
                            <p class="text-blue-100 mt-2 text-sm font-medium opacity-90">Laporkan kehadiran atau alasan jika berhalangan.</p>
                            
                            <div class="mt-8 flex items-center gap-4 bg-white/10 p-4 rounded-2xl backdrop-blur-sm border border-white/10">
                                <div class="h-12 w-12 rounded-xl bg-white flex items-center justify-center text-blue-600 shadow-lg">
                                    <UserIcon class="h-7 w-7" />
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold text-blue-200 uppercase tracking-widest leading-none">Kepala Keluarga</div>
                                    <div class="font-bold text-lg leading-tight">{{ kkData?.nama }}</div>
                                </div>
                            </div>
                        </div>

                        <div v-if="alreadyAbsented" class="p-10 text-center">
                            <div class="h-24 w-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <CheckBadgeIcon class="h-12 w-12 text-green-600" />
                            </div>
                            <h4 class="text-2xl font-black text-gray-900">Laporan Diterima!</h4>
                            <p class="text-gray-600 mt-2">Terima kasih telah berpartisipasi dalam menjaga keamanan lingkungan hari ini.</p>
                            <button @click="activeTab = 'today'" class="mt-8 text-blue-600 font-bold hover:underline">Lihat laporan presensi</button>
                        </div>

                        <div v-else-if="!isMyScheduleDay" class="p-10 text-center">
                            <div class="h-24 w-24 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <ExclamationTriangleIcon class="h-12 w-12 text-amber-600" />
                            </div>
                            <h4 class="text-2xl font-black text-gray-900">Bukan Jadwal Anda</h4>
                            <p class="text-gray-600 mt-2">Anda hanya dapat mengisi laporan presensi pada hari {{ dayNames[kkData?.kelompok_ronda] }}.</p>
                        </div>

                        <form v-else @submit.prevent="submitAbsen" class="p-10 space-y-8">
                            <div v-if="form.status === 'Izin'" class="bg-amber-50 border border-amber-100 p-4 rounded-2xl flex items-start gap-4">
                                <InformationCircleIcon class="h-6 w-6 text-amber-600 flex-shrink-0" />
                                <div class="text-sm text-amber-800 font-medium">
                                    Catatan: Perizinan akan dikenakan denda ronda otomatis sebesar <span class="font-black">Rp 20.000</span> sesuai kesepakatan RT.
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3 ml-1 uppercase tracking-widest text-[10px]">Pilih Status</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <button 
                                        v-for="s in ['Hadir', 'Izin', 'Sakit']" 
                                        :key="s"
                                        type="button"
                                        @click="form.status = s"
                                        :class="[
                                            form.status === s 
                                                ? 'bg-blue-600 text-white shadow-lg ring-2 ring-blue-500 ring-offset-2 scale-[1.02]' 
                                                : 'bg-gray-50 text-gray-500 hover:bg-gray-100 border border-gray-100',
                                            'px-6 py-4 rounded-2xl text-sm font-bold transition-all duration-300 transform'
                                        ]"
                                    >
                                        {{ s }}
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3 ml-1 uppercase tracking-widest text-[10px]">Keterangan (Opsional)</label>
                                <textarea
                                    v-model="form.keterangan"
                                    rows="4"
                                    class="block w-full rounded-2xl border-gray-100 bg-gray-50 shadow-sm focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all duration-300 p-5 text-gray-700"
                                    placeholder="Contoh: Sedang ada dinas luar kota, atau lainnya..."
                                ></textarea>
                            </div>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 text-white px-8 py-5 rounded-2xl font-black text-lg shadow-xl shadow-blue-200 hover:shadow-2xl hover:scale-[1.01] active:scale-[0.99] transition-all duration-300 disabled:opacity-50 flex items-center justify-center gap-3"
                            >
                                <CheckBadgeIcon class="h-7 w-7" v-if="!form.processing" />
                                <ClockIcon class="h-7 w-7 animate-spin" v-else />
                                {{ form.processing ? 'Mengirim...' : 'Kirim Laporan' }}
                            </button>
                            
                            <div v-if="form.errors.id_kk" class="text-red-500 text-sm font-bold text-center mt-4">
                                {{ form.errors.id_kk }}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </NavigationLayout>
</template>

<style scoped>
.glass {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}
</style>