<script setup>
import { Link, useForm } from '@inertiajs/vue3';

// --- Form logic (from Laravel default)
const props = defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

// --- UI styling (from your custom design)
const bgStyle = {
    backgroundImage: `url('/src/img/login/kendung.jpg')`,
    backgroundSize: 'cover',
    backgroundPosition: 'center',
    backgroundRepeat: 'no-repeat',
    backgroundColor: 'rgba(0, 0, 0, 0.6)',
    backgroundBlendMode: 'multiply',
    borderRadius: '0px 0px 10px 10px',
};

const styleSection = 'min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100 p-4';
const styleBtn = 'cursor-pointer w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-0 focus:ring-blue-400 transition duration-300 transform hover:scale-101';
</script>

<template>

    <!-- Background Section with Image -->
    <section :class="styleSection" :style="bgStyle">
      <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-md transform transition-all duration-300 hover:shadow-2xl">
        <!-- Header -->
        <div class="text-center mb-8">
          <div class="flex justify-center mb-2">
            <div class="w-20 h-20 rounded-full flex items-center justify-center text-white">
              <img src="/src/img/login/tasik.png" alt="Logo" class="w-16 h-16 object-contain" />
            </div>
          </div>
          <h1 class="text-3xl font-bold text-blue-600 mb-2">Kampung Kendung</h1>
          <p class="text-gray-600">Masuk ke akun Anda</p>
        </div>

        <!-- Status Message -->
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600 text-center">
          {{ status }}
        </div>

        <!-- Login Form -->
        <form @submit.prevent="submit" class="space-y-6">
          <!-- Email Field -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </div>
              <input
                id="email"
                v-model="form.email"
                type="email"
                required
                autofocus
                autocomplete="username"
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Masukkan email"
              />
            </div>
            <div v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</div>
          </div>

          <!-- Password Field -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
              </div>
              <input
                id="password"
                v-model="form.password"
                type="password"
                required
                autocomplete="current-password"
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Masukkan password"
              />
            </div>
            <div v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</div>
          </div>

          <!-- Remember Me & Forgot Password -->
          <div class="flex items-center justify-between">
            <label class="flex items-center">
              <input
                type="checkbox"
                v-model="form.remember"
                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
              />
              <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
            </label>

            <Link
              v-if="canResetPassword"
              :href="route('password.request')"
              class="text-sm text-blue-600 hover:underline"
            >
              Lupa password?
            </Link>
          </div>

          <!-- Submit Button -->
          <div>
            <button
              type="submit"
              :class="styleBtn"
              :disabled="form.processing"
            >
              Masuk
            </button>
          </div>
        </form>
      </div>
    </section>
</template>

<style scoped>
/* .animate-bounce { animation: bounce 1.5s infinite; }
@keyframes bounce {
  0%, 100% { transform: translateY(-25%); animation-timing-function: cubic-bezier(0.8,0,1,1); }
  50% { transform: translateY(0); animation-timing-function: cubic-bezier(0,0,0.2,1); }
} */
</style>
