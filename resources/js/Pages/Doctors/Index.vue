<template>
  <AppLayout title="Dashboard">
    <div class="max-w-7xl mx-auto py-12">
    <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <template v-for="doctor in doctors.data">
        <li class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow">
          <div class="flex w-full items-center justify-between space-x-6 p-6">
            <div class="flex-1 truncate">
              <div class="flex items-center space-x-3">
                <h3 class="truncate text-sm font-medium text-gray-900">{{ doctor.name }}</h3>
              </div>
              <p class="mt-1 truncate text-sm text-gray-500">{{ doctor.specialization }}</p>
            </div>
            <img class="h-10 w-10 flex-shrink-0 rounded-full bg-gray-300"
                 :src="doctor.profile_photo_url"
                 :alt="`Profile picture of ${doctor.name}`">
          </div>
          <div>
            <div class="-mt-px flex divide-x divide-gray-200">
              <div class="flex w-0 flex-1">
                <a :href="`mailto:${doctor.email}`"
                   class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center rounded-bl-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-orange-500">
                  <!-- Heroicon name: mini/envelope -->
                  <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                       fill="currentColor" aria-hidden="true">
                    <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z"/>
                    <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z"/>
                  </svg>
                  <span class="ml-3">Email</span>
                </a>
              </div>
              <div class="-ml-px flex w-0 flex-1">
                <InertiaLink :href="`/documents/share/${doctor.id}`"
                             class="relative inline-flex w-0 flex-1 items-center justify-center rounded-br-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-orange-500">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                       stroke="currentColor" class="h-5 w-5 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/>
                  </svg>

                  <span class="ml-3">Dateien teilen</span>
                </InertiaLink>
              </div>
            </div>
          </div>
        </li>
      </template>
    </ul>

    <Pagination :links="doctors.links"/>
    </div>
  </AppLayout>
</template>

<script setup>
import Pagination from "@/Components/Pagination.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import {InertiaLink} from "@inertiajs/inertia-vue3";

defineProps({
  doctors: {
    type: Object,
    required: true,
  }
});
</script>

<style scoped>

</style>
