<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()
const isAuthenticated = computed(() => page.props.auth.user !== null)

const isScrolled = ref(false)

const handleScroll = () => {
  isScrolled.value = window.scrollY > 50
}

const scrollToSection = (e, sectionId) => {
  e.preventDefault()
  const element = document.getElementById(sectionId)
  if (element) {
    const headerOffset = 80 // Adjust this value based on your header height
    const elementPosition = element.getBoundingClientRect().top
    const offsetPosition = elementPosition + window.pageYOffset - headerOffset

    window.scrollTo({
      top: offsetPosition,
      behavior: 'smooth'
    })
  }
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)

  // Add smooth scrolling for anchor links
  const links = document.querySelectorAll('a[href^="#"]')
  links.forEach(link => {
    link.addEventListener('click', (e) => {
      const href = link.getAttribute('href')
      if (href !== '#') {
        e.preventDefault()
        const sectionId = href.substring(1)
        scrollToSection(e, sectionId)
      }
    })
  })
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})

const styleLogin = ref('cursor-pointer nav-link font-medium transition-colors duration-300 px-2 py-2 rounded-md bg-blue-500 text-white hover:bg-blue-600')
const styleNav = ref('cursor-pointer hover:text-blue-500 font-medium transition-colors duration-300 px-2 py-1 rounded-md hover:bg-opacity-10')
</script>

<template>
  <nav
  class="fixed w-full z-50 transition-all duration-300 h-15"
  :class="isScrolled ? 'bg-white shadow-md text-gray-800 rounded-b-full' : 'text-white'"
>
    <div class="container mx-auto px-4 py-3 flex justify-between items-center h-full">
      <div class="flex items-center">
        <img src="src/img/login/tasik.png" alt="Tasik" class="h-10 w-10">
        <span class="text-2xl font-bold ml-2 whitespace-nowrap" :class="{ 'text-blue-500': isScrolled, 'text-white': !isScrolled }">Kampung Kendung</span>
      </div>
      <div class="hidden md:flex items-center h-full">
        <ul class="flex space-x-8 h-full items-center">
          <li>
            <a
              href="#beranda"
              @click="(e) => scrollToSection(e, 'beranda')"
              :class="styleNav"

              >Beranda</a
            >
          </li>
          <li>
            <a
              href="#tentang"
              @click="(e) => scrollToSection(e, 'tentang')"
              :class="styleNav"
              >Tentang</a
            >
          </li>
          <li>
            <a
              href="#lembaga"
              @click="(e) => scrollToSection(e, 'lembaga')"
              :class="styleNav"
              >Lembaga</a
            >
          </li>
          <li>
            <a
              href="#galeri"
              @click="(e) => scrollToSection(e, 'galeri')"
              :class="styleNav"
              >Galeri</a
            >
          </li>
          <li>
            <a
              href="#kontak"
              @click="(e) => scrollToSection(e, 'kontak')"
              :class="styleNav"
              >Kontak</a
            >
          </li>
          <li>
            <Link
              :href="isAuthenticated ? route('dashboard') : route('login')"
              :class="styleLogin"
            >
              {{ isAuthenticated ? 'Dashboard' : 'Login' }}
            </Link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
