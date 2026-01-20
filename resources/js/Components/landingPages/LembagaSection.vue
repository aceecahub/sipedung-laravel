<script setup>
  import { ref } from 'vue'

  const styleCard = ref('flex flex-col bg-blue-50 p-6 rounded-xl shadow-md w-full h-full hover:scale-102 transition-transform duration-300')
</script>

<template>
  <section id="lembaga" class="py-12 bg-gray-50">
    <div class="container mx-auto">
      <div class="text-center mb-10">
        <h2 class="text-3xl font-bold mb-2">Lembaga Kami</h2>
        <hr
          class="w-20 h-1 mt-1 border-0 rounded-full mx-auto bg-blue-400"
        />
      </div>

      <!-- Card -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl mx-auto px-4">
        <!-- ponpes -->
        <div :class="styleCard">
          <div class="flex items-start gap-4 h-full">
            <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center shadow-sm">
              <span class="text-blue-500 text-2xl">🏫</span>
            </div>
            <div class="flex-1 min-w-0">
              <h3 class="text-xl font-semibold text-gray-800 mb-2">Pondok Pesantren Nurul Qulub</h3>
              <p class="text-gray-600">Deskripsi Ponpes</p>
            </div>
          </div>
        </div>

        <!-- Sekolah -->
        <div :class="styleCard">
          <div class="flex items-start gap-4 h-full">
            <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center shadow-sm">
              <span class="text-blue-500 text-2xl">📚</span>
            </div>
            <div class="flex-1 min-w-0">
              <h3 class="text-xl font-semibold text-gray-800 mb-2">SDN Mekarrahayu</h3>
              <p class="text-gray-600">Sekolah Dasar Negeri Mekarrahayu</p>
            </div>
          </div>
        </div>

        <!-- Pemuda & Pemudi -->
        <div :class="styleCard">
          <div class="flex items-start gap-4 h-full">
            <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center shadow-sm">
              <span class="text-blue-500 text-2xl">👥</span>
            </div>
            <div class="flex-1 min-w-0">
              <h3 class="text-xl font-semibold text-gray-800 mb-2">Pemuda & Pemudi Kendung</h3>
              <p class="text-gray-600">Deskripsi lembaga pemuda dan pemudi</p>
            </div>
          </div>
        </div>

        <!-- Sauyunan -->
        <div :class="styleCard">
          <div class="flex items-start gap-4 h-full">
            <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center shadow-sm">
              <span class="text-blue-500 text-2xl">🤝</span>
            </div>
            <div class="flex-1 min-w-0">
              <h3 class="text-xl font-semibold text-gray-800 mb-2">Sauyunan Kampung Kendung</h3>
              <p class="text-gray-600">Deskripsi sauyunan kampung kendung</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
