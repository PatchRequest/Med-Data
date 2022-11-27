<script setup>
import {ref, watch} from 'vue';
import {Inertia} from '@inertiajs/inertia';
import {Head, InertiaLink, usePage} from '@inertiajs/inertia-vue3';
import Banner from '@/Components/Banner.vue';

defineProps({
  title: String,
});

let showMobile = ref(false)
let profileDropdown = ref(false)

let searchTerm = ref('')
let debounce = ref(null)

let showSearch = ref(false)
let doctors = ref([])
let selectedDoctor = ref()

let searchInput = ref(null)

watch(searchTerm, (value) => {
  doctors.value = [];

  axios.post(usePage().props.value.meilisearch_url + '/indexes/doctors/search', {
    q: value,
    limit: 10,
  }).then((response) => {
    doctors.value = response.data.hits
    if (doctors.value.length > 0) {
      selectedDoctor.value = doctors.value[0]
    }
  }).catch((error) => {
    console.error(error)
  })

})

const debounceSearch = (event) => {
  searchTerm.value = null
  clearTimeout(debounce.value)
  debounce.value = setTimeout(() => {
    searchTerm.value = event.target.value
  }, 250)
}

const openSearch = () => {

  showSearch.value = true;
  document.activeElement.blur();
  setTimeout(() => {
    searchInput.value.focus()
  }, 600)


}

const logout = () => {
  Inertia.post(route('logout'));
};
</script>

<template>
  <div>
    <Head :title="title"/>

    <Banner/>

    <div class="min-h-screen bg-gray-100">
      <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-2 sm:px-4 lg:divide-y lg:divide-gray-200 lg:px-8">
          <div class="relative flex h-16 justify-between">
            <div class="relative z-10 flex px-2 lg:px-0">
              <div class="flex flex-shrink-0 items-center">
                <InertiaLink :href="route('dashboard')">
                  <img class="block h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=orange&shade=600"
                       alt="Your Company">
                </InertiaLink>
              </div>
            </div>
            <div class="relative z-0 flex flex-1 items-center justify-center px-2 sm:absolute sm:inset-0">
              <div
                  @click="openSearch"
                  class="w-full sm:max-w-xs">
                <label for="search" class="sr-only">Suche</label>
                <div class="relative">
                  <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <!-- Heroicon name: mini/magnifying-glass -->
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                         fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd"
                            d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                            clip-rule="evenodd"/>
                    </svg>
                  </div>
                  <input
                      @input.prevent
                      id="search" name="search"
                      class="block w-full rounded-md border border-gray-300 bg-white py-2 pl-10 pr-3 text-sm placeholder-gray-500 focus:border-orange-500 focus:text-gray-900 focus:placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-orange-500 sm:text-sm"
                      placeholder="Suchen ..." type="search">
                </div>
              </div>
            </div>
            <div class="relative z-10 flex items-center lg:hidden">
              <!-- Mobile menu button -->
              <button
                  @click="showMobile = !showMobile"
                  type="button"
                  class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-orange-500"
                  aria-controls="mobile-menu" aria-expanded="false">
                <span class="sr-only">Open menu</span>

                <svg
                    v-show="!showMobile"
                    class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>

                <svg
                    v-show="showMobile"
                    class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
              </button>
            </div>
            <div class="hidden lg:relative lg:z-10 lg:ml-4 lg:flex lg:items-center">
              <div class="relative ml-4 flex-shrink-0">
                <div>
                  <button
                      @click="profileDropdown = !profileDropdown"
                      type="button"
                      class="flex rounded-full bg-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2"
                      id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                    <span class="sr-only">Open user menu</span>
                    <img class="h-8 w-8 rounded-full"
                         src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                         alt="">
                  </button>
                </div>

                <div
                    v-show="profileDropdown"
                    class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                    role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                  <!-- Active: "bg-gray-100", Not Active: "" -->
                  <a href="#" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1"
                     id="user-menu-item-0">Mein Profil</a>

                  <a href="#" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1"
                     id="user-menu-item-1">Einstellungen</a>

                  <a href="#" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1"
                     id="user-menu-item-2">Abmelden</a>
                </div>
              </div>
            </div>
          </div>
          <nav class="hidden lg:flex lg:space-x-8 lg:py-2" aria-label="Global">
            <!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-900 hover:bg-gray-50 hover:text-gray-900" -->
            <InertiaLink :href="route('dashboard')"
                         class="bg-gray-100 text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium"
                         aria-current="page">Dashboard
            </InertiaLink>

            <InertiaLink :href="route('doctors.index')"
                         class="text-gray-900 hover:bg-gray-50 hover:text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium">
              Ärzte
            </InertiaLink>

            <InertiaLink :href="route('documents.index')"
                         class="text-gray-900 hover:bg-gray-50 hover:text-gray-900 rounded-md py-2 px-3 inline-flex items-center text-sm font-medium">
              Meine Dokumente
            </InertiaLink>
          </nav>
        </div>

        <nav
            v-if="showMobile"
            class="lg:hidden" aria-label="Global" id="mobile-menu">
          <div class="space-y-1 px-2 pt-2 pb-3">
            <!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-900 hover:bg-gray-50 hover:text-gray-900" -->
            <InertiaLink :href="route('dashboard')"
                         class="bg-gray-100 text-gray-900 block rounded-md py-2 px-3 text-base font-medium"
                         aria-current="page">Dashboard
            </InertiaLink>

            <InertiaLink :href="route('doctors.index')"
                         class="text-gray-900 hover:bg-gray-50 hover:text-gray-900 block rounded-md py-2 px-3 text-base font-medium">
              Ärzte
            </InertiaLink>

            <InertiaLink :href="route('documents.index')"
                         class="text-gray-900 hover:bg-gray-50 hover:text-gray-900 block rounded-md py-2 px-3 text-base font-medium">
              Meine Dokumente
            </InertiaLink>
          </div>
          <div class="border-t border-gray-200 pt-4 pb-3">
            <div class="flex items-center px-4">
              <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full"
                     :src="$page.user.profile_photo_url"
                     alt="">
              </div>
              <div class="ml-3">
                <div class="text-base font-medium text-gray-800">{{ $page.user.name }}</div>
                <div class="text-sm font-medium text-gray-500">{{ $page.user.email }}</div>
              </div>
            </div>
            <div class="mt-3 space-y-1 px-2">
              <a href="#"
                 class="block rounded-md py-2 px-3 text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900">Mein
                Profil</a>

              <a href="#"
                 class="block rounded-md py-2 px-3 text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900">Einstellungen</a>

              <a href="#"
                 class="block rounded-md py-2 px-3 text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900">Abmelden</a>
            </div>
          </div>
        </nav>
      </header>

      <!-- Page Heading -->
      <header v-if="$slots.header" class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header"/>
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <slot/>
      </main>
    </div>

    <div
        @keydown.esc="showSearch = false"
        class="relative z-10" role="dialog" aria-modal="true">
      <div
          v-if="showSearch"
          class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity"></div>

      <div
          v-if="showSearch"
          class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">
        <div
            class="mx-auto max-w-3xl transform divide-y divide-gray-100 overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">
          <div class="relative">
            <svg class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-400"
                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd"
                    d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                    clip-rule="evenodd"/>
            </svg>
            <input
                @input="debounceSearch"
                ref="searchInput"
                type="text"
                class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm"
                placeholder="Search..." role="combobox" aria-expanded="false" aria-controls="options">
          </div>

          <div
              v-if="searchTerm.length > 0 && doctors.length > 0"
              class="flex divide-x divide-gray-100">
            <div class="max-h-96 min-w-0 flex-auto scroll-py-4 overflow-y-auto px-6 py-4 sm:h-96">
              <h2 class="mt-2 mb-4 text-xs font-semibold text-gray-500">Gefundene Ärzte</h2>

              <ul class="-mx-2 text-sm text-gray-700" id="options" role="listbox">
                <template v-for="doctor in doctors">
                  <li
                      @click="selectedDoctor = doctor"
                      :class="{'bg-gray-100 text-gray-900': selectedDoctor.id === doctor.id}"
                      class="group flex cursor-default select-none items-center rounded-md p-2 hover:cursor-pointer"
                      id="option-1" role="option" tabindex="-1">
                    <img :src="doctor.profile_photo_url" alt=""
                         class="h-6 w-6 flex-none rounded-full group-hover:border group-hover:border-orange-400 group-hover:border-inset">
                    <span class="ml-3 flex-auto truncate group-hover:text-orange-400">{{ doctor.name }}</span>

                    <svg
                        :class="{'hidden': selectedDoctor.id !== doctor.id}"
                        class="ml-3 h-5 w-5 flex-none text-gray-400 group-hover:text-orange-400"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd"
                            d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                            clip-rule="evenodd"/>
                    </svg>
                  </li>
                </template>
              </ul>
            </div>

            <div class="h-96 w-1/2 flex-none flex-col divide-y divide-gray-100 overflow-y-auto sm:flex">
              <div class="flex-none p-6 text-center">
                <img :src="selectedDoctor.profile_photo_url" alt="" class="mx-auto h-16 w-16 rounded-full">
                <h2 class="mt-3 font-semibold text-gray-900">{{ selectedDoctor.name }}</h2>
                <p class="text-sm leading-6 text-gray-500">{{ selectedDoctor.specialization }}</p>
              </div>
              <div class="flex flex-auto flex-col justify-between p-6">
                <dl class="grid grid-cols-1 gap-x-6 gap-y-3 text-sm text-gray-700">
                  <dt class="col-end-1 font-semibold text-gray-900">Telefon</dt>
                  <dd>{{ selectedDoctor.telephone }}</dd>
                  <dt class="col-end-1 font-semibold text-gray-900">Email</dt>
                  <dd class="truncate"><a href="#" class="text-orange-600 underline">{{ selectedDoctor.email }}</a></dd>
                </dl>
                <button type="button"
                        class="mt-6 w-full rounded-md border border-transparent bg-orange-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                  Dateien bereitstellen
                </button>
              </div>
            </div>
          </div>

          <div
              v-if="searchTerm.length !== 0 && doctors.length === 0">
            <svg class="mx-auto h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
            </svg>
            <p class="mt-4 font-semibold text-gray-900">Keinen Arzt gefunden</p>
            <p class="mt-2 text-gray-500">Wir konnten leider keinen Arzt mit dem Namen "{{ searchTerm }}" finden</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>
