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
                  <InertiaLink :href="route('profile.show')" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1"
                     id="user-menu-item-0">Mein Profil</InertiaLink>



                  <button @click="logout" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1"
                     id="user-menu-item-2">Abmelden</button>
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
              <InertiaLink :href="route('profile.show')"
                 class="block rounded-md py-2 px-3 text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900">Mein
                Profil</InertiaLink>


              <button @click="logout"
                 class="block rounded-md py-2 px-3 text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900">Abmelden</button>
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



  </div>
</template>
