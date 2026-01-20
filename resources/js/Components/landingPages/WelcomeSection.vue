<script setup>
import { ref } from 'vue'
import './NavbarList.vue'

const bgStyle = {
  backgroundImage: 'url(src/img/welcome/gapura.png)',
  backgroundSize: 'cover',
  backgroundPosition: 'center',
  backgroundRepeat: 'no-repeat',
  backgroundColor: 'rgba(10, 30, 80, 0.4)',
  backgroundBlendMode: 'multiply',
  borderRadius: '0px 0px 10px 10px',
}

const styleBtn1 = ref(
  'cursor-pointer bg-blue-500 transition-colors duration-300 hover:bg-blue-600 h-16 text-white font-semibold py-2 px-4 rounded-xl mt-7 shadow-lg',
)
const styleBtn2 = ref(
  'cursor-pointer bg-white/50 text-blue-600 border border-white transition-colors duration-300 hover:bg-white/70 h-16 font-semibold py-2 px-4 rounded-xl mt-7 shadow-lg',
)
const styleSection = ref('h-screen w-full')
</script>

<template>
  <section :class="styleSection" :style="bgStyle" style="font-family: playfair-display">
    <div class="container flex items-center justify-center mx-auto h-full">
      <div class="mt-25 text-center">
        <h1 class="text-7xl font-bold text-white">
          Selamat Datang di <br class="m-1" />
          <span class="text-blue-500">Kampung Kendung</span>
        </h1>
        <p class="text-2xl mt-10 text-gray-50" >
          Kampung Kendung adalah tempat yang ideal untuk <br />menikmati suasana alam yang indah dan
          sehat.
        </p>
        <div class="flex gap-5 justify-center">
          <a href="#kontak">
            <button :class="styleBtn1">Hubungi Kami</button>
          </a>
          <button :class="styleBtn2">Jelajahi Kampung</button>
        </div>
      </div>
    </div>
  </section>
</template>
