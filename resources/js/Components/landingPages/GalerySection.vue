<script setup>
import { ref } from 'vue'

const styleBtn = ref(
  'cursor-pointer bg-blue-500 text-white px-4 rounded-xl py-4 text-xl font-bold shadow-xl hover:bg-blue-600 transition-colors duration-300',
)
</script>

<template>
  <section class="py-4">
    <div class="container mx-auto">
      <div class="flex flex-col items-center">
        <h2 class="text-3xl font-bold text-center text-gray-900">Galeri Kampung Kendung</h2>
        <hr class="w-20 h-1 mt-1 border-0 rounded-full mr-72 bg-blue-400" />
        <p class="text-xl mt-5 text-gray-600 text-center">
          Keindahan setiap sudut kampung yang menenangkan hati
        </p>
      </div>

      <!-- Image Galery -->
      <div class="grid grid-cols-4 gap-8 mt-5">
        <div class="h-64 rounded-xl overflow-hidden shadow-lg">
          <img src="src/img/galery/pemuda.png" alt="pemuda" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" />
        </div>
        <div class="h-64 rounded-xl overflow-hidden shadow-lg">
          <img src="src/img/galery/ibuibu.png" alt="ibuibu" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" />
        </div>
        <div class="h-64 rounded-xl overflow-hidden shadow-lg">
          <img src="src/img/galery/bapabapa.png" alt="bapabapa" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"/>
        </div>
        <div class="h-64 rounded-xl overflow-hidden shadow-lg">
          <img src="src/img/galery/ibuibu2.png" alt="ibuibu2" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" />
        </div>
        <div class="h-64 rounded-xl overflow-hidden shadow-lg">
          <img src="src/img/galery/lomba.png" alt="lomba" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" />
        </div>
        <div class="h-64 rounded-xl overflow-hidden shadow-lg">
          <img src="src/img/galery/juara.png" alt="juara" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" />
        </div>
        <div class="h-64 rounded-xl overflow-hidden shadow-lg">
          <img src="src/img/galery/anaksd.png" alt="anak" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" />
        </div>
        <div class="h-64 rounded-xl overflow-hidden shadow-lg">
          <img src="src/img/galery/anaksd.png" alt="anak" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" />
        </div>
      </div>

      <div class="flex justify-center mt-10">
        <button :class="styleBtn">Lihat Semua Galeri</button>
      </div>
    </div>
  </section>
</template>
