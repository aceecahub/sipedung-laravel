<script setup>
import NavbarList from "../Components/landingPages/NavbarList.vue";
import WelcomeSection from "../Components/landingPages/WelcomeSection.vue";
import AboutSection from "../Components/landingPages/AboutSection.vue";
import LembagaSection from "../Components/landingPages/LembagaSection.vue";
import GalerySection from "../Components/landingPages/GalerySection.vue";
import ContactSection from "../Components/landingPages/ContactSection.vue";
import FooterSection from "../Components/landingPages/FooterSection.vue";

// Opsional: Tambahkan Head untuk SEO/meta
import { Head } from '@inertiajs/vue3';
</script>

<template>
  <Head title="Selamat Datang di Kampung Kendung" />

  <div style="font-family: 'Playfair Display', serif">
    <NavbarList />
    <WelcomeSection id="beranda" />
    <AboutSection id="tentang" />
    <LembagaSection id="lembaga" />
    <GalerySection id="galeri" />
    <ContactSection id="kontak"/>
    <FooterSection />
  </div>
</template>

<style scoped>
/* Pastikan Playfair Display tersedia */
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap');
</style>
