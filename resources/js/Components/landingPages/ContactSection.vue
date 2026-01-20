<script setup>
import { ref } from 'vue'
const styleH2 = ref('text-3xl font-bold text-center text-gray-900')
const styleHr = ref('w-20 h-1 mt-1 border-0 rounded-full mr-32 bg-blue-400')
const styleP = ref('text-xl my-5 text-gray-600 text-center')
</script>

<template>
  <section class="py-10 bg-gray-50">
    <div class="container mx-auto">
      <div class="flex flex-col items-center">
        <h2 :class="styleH2">Hubungi Kami</h2>
        <hr :class="styleHr" />
        <p :class="styleP">Hubungi Kami untuk informasi lebih lanjut</p>
      </div>

      <!-- card Contact -->
      <div class="flex justify-center mt-15">
        <div class="flex shadow-xl rounded-2xl">
          <!-- Card Left -->
          <div class="w-[570px] h-170 bg-blue-100 rounded-l-2xl">
            <div class="flex flex-col pl-10 pt-10 px-10">
              <h1 class="text-2xl font-bold">Mari Berkolaborasi</h1>
              <p class="mt-5 text-gray-600 text-lg">
                Tim kami siap membantu Anda dengan informasi lengkap tentang Kampung Kendung.
                Hubungi kami melalui form di samping atau gunakan kontak langsung.
              </p>

              <div class="flex justify-center mt-10">
                <!-- Address -->
                <div class="space-y-4 mb-8">
                  <div class="flex items-start">
                    <div class="bg-blue-200 p-3 rounded-lg mr-4">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-blue-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                        />
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                      </svg>
                    </div>
                    <div>
                      <p class="font-medium text-gray-900">Alamat</p>
                      <p class="text-gray-600">
                        Kp Kedung RT04 RW03, Desa Cikadongdong <br>
                        Kec. Singaparna, Kab. Tasikmalaya, Jawa Barat
                      </p>
                    </div>
                  </div>

                  <!-- Phone -->
                  <div class="flex items-start">
                    <div class="bg-blue-200 p-3 rounded-lg mr-4">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-blue-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                        />
                      </svg>
                    </div>
                    <div>
                      <p class="font-medium text-gray-900">Telepon</p>
                      <p class="text-gray-600">(021) 8765-4321</p>
                      <p class="text-gray-600">0812-3456-7890</p>
                    </div>
                  </div>

                  <!-- Email -->
                  <div class="flex items-start">
                    <div class="bg-blue-200 p-3 rounded-lg mr-4">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-blue-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                        />
                      </svg>
                    </div>
                    <div>
                      <p class="font-medium text-gray-900">Email</p>
                      <p class="text-gray-600">info@kampungkendung.desa.id</p>
                      <p class="text-gray-600">admin@kampungkendung.desa.id</p>
                    </div>
                  </div>

                  <!-- social media -->
                  <div class="flex space-x-4 mt-15">
                    <a
                      href="#"
                      class="bg-blue-200 text-blue-500 hover:bg-blue-300 w-12 h-12 rounded-full flex items-center justify-center transition duration-300"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"
                        />
                      </svg>
                    </a>
                    <a
                      href="#"
                      class="bg-blue-200 text-blue-500 hover:bg-blue-300 w-12 h-12 rounded-full flex items-center justify-center transition duration-300"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          d="M19.633 7.997c.013.175.013.349.013.523 0 5.325-4.063 11.461-11.46 11.461-2.282 0-4.402-.661-6.186-1.809.324.037.636.05.973.05a8.07 8.07 0 0 0 5.001-1.721 4.036 4.036 0 0 1-3.767-2.793c.249.037.499.062.761.062.361 0 .724-.05 1.061-.137a4.027 4.027 0 0 1-3.23-3.953v-.05c.537.299 1.16.486 1.82.511a4.022 4.022 0 0 1-1.796-3.354c0-.748.199-1.434.548-2.032a11.457 11.457 0 0 0 8.306 4.215c-.062-.3-.1-.611-.1-.923a4.026 4.026 0 0 1 4.028-4.028c1.16 0 2.207.523 2.902 1.347a7.937 7.937 0 0 0 2.558-.973 4.024 4.024 0 0 1-1.771 2.22 8.073 8.073 0 0 0 2.319-.624 8.645 8.645 0 0 1-2.019 2.083z"
                        />
                      </svg>
                    </a>
                    <a
                      href="#"
                      class="bg-blue-200 text-blue-500 hover:bg-blue-300 w-12 h-12 rounded-full flex items-center justify-center transition duration-300"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.207 2h-1.793v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"
                        />
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Card Right -->
          <div class="w-120 h-170 bg-white rounded-r-2xl">
            <div class="p-6 md:p-8">
              <form class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1"
                      >Nama Lengkap</label
                    >
                    <input
                      type="text"
                      id="name"
                      class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                      placeholder="Nama Lengkap Anda"
                    />
                  </div>
                  <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1"
                      >Email</label
                    >
                    <input
                      type="email"
                      id="email"
                      class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                      placeholder="Email Anda"
                    />
                  </div>
                </div>

                <div>
                  <label for="subject" class="block text-sm font-medium text-gray-700 mb-1"
                    >Subjek</label
                  >
                  <input
                    type="text"
                    id="subject"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Subjek pesan Anda"
                  />
                </div>

                <div>
                  <label for="message" class="block text-sm font-medium text-gray-700 mb-1"
                    >Pesan</label
                  >
                  <textarea
                    id="message"
                    rows="4"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Tulis pesan Anda di sini"
                  ></textarea>
                </div>

                <button
                  type="submit"
                  class="w-full cursor-pointer bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-6 rounded-lg transition duration-300 shadow-lg hover:shadow-blue-500/30"
                >
                  Kirim Pesan
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
