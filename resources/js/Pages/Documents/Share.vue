<template>
  <AppLayout title="Dashboard">
    <div class="max-w-7xl mx-auto py-12 grid grid-cols-8 gap-4">

      <div class="col-span-4 md:col-span-6 p-6 bg-white flex items-center flex-col shadow-lg">
        <div class="w-full">
        <label for="cover-photo" class="block text-sm font-medium text-gray-700">Teilen Sie Dateien mit {{ doctor.name }}</label>
        <div
            @drop="drop"
            @dragover.prevent="dragging = true"
            @dragleave="dragging = false"
            @dragend="dragging = false"
            :class="{'border-orange-300': dragging, 'border-gray-300': !dragging}"
            class="mt-1 flex flex-col items-center justify-center rounded-md border-2 border-dashed px-6 pt-5 pb-6">
          <div class="space-y-1 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"
                 aria-hidden="true">
              <path
                  d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div class="flex text-sm text-gray-600">
              <label for="file-upload"
                     class="relative cursor-pointer rounded-md bg-white font-medium text-orange-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-orange-500 focus-within:ring-offset-2 hover:text-orange-500">
                <span>Wählen Sie die Dateien aus</span>
                <input @input="input" :disabled="form.processing" id="file-upload" name="file-upload" type="file" class="sr-only" multiple>
              </label>
              <p class="pl-1">oder ziehen Sie sie hier hin</p>
            </div>
            <p class="text-xs text-gray-500">PNG, JPG, PDF bis zu 10MB</p>
          </div>

          <ul role="list"
              class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8 mt-8">
            <template v-for="(file, key) in form.files">
              <li
                  @click="remove(key)"
                  class="relative">
                <div
                    class="group aspect-w-10 aspect-h-7 block w-full overflow-hidden rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-orange-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100">
                  <embed
                      :src="embed(file)"
                      alt="" class="pointer-events-none object-cover group-hover:opacity-75">
                  <button type="button" class="absolute inset-0 focus:outline-none">
                    <span class="sr-only">{{ file.name }}</span>
                  </button>
                </div>
                <p class="pointer-events-none mt-2 block truncate text-sm font-medium text-gray-900">{{ file.name }}</p>
                <p class="pointer-events-none block text-sm font-medium text-gray-500">
                  {{ new Intl.NumberFormat('de-DE').format(file.size) }} KB</p>
              </li>
            </template>
          </ul>
        </div>
        </div>

        <div class="w-full mt-4">
          <label for="message" class="block text-sm font-medium text-gray-700">Ihre Nachricht an {{ doctor.name }}</label>
          <div class="mt-1">
            <textarea v-model="form.message" :disabled="form.processing" id="message" name="message" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Ihre Nachricht..." />
          </div>
        </div>

      <button @click="submit()" :disabled="form.processing" class="py-4 px-2 bg-orange-400 text-white rounded-lg hover:bg-orange-600 w-1/5 mt-8">Absenden</button>

      </div>

      <div class="col-span-4 md:col-span-2 flex flex-col text-center">
        <div class="flex flex-1 flex-col p-8 grow-0 bg-white rounded-lg shadow-lg">
          <p class="text-xl mb-4">Ihr ausgewählter Arzt</p>
          <img class="mx-auto h-32 w-32 flex-shrink-0 rounded-full"
               :src="doctor.profile_photo_url"
               alt="">
          <h3 class="mt-6 text-sm font-medium text-gray-900">{{ doctor.name }}</h3>
          <dl class="mt-1 flex flex-grow flex-col justify-between">
            <dt class="sr-only">Fachrichtung</dt>
            <dd class="text-sm text-gray-500">{{ doctor.specialization }}</dd>
          </dl>

          <hr class="m-2">

          <div class="-mt-px flex">
            <div class="flex w-0 flex-1">
              <a :href="`mailto:${doctor.email}`"
                 class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center rounded-bl-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500">
                <!-- Heroicon name: mini/envelope -->
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                     fill="currentColor" aria-hidden="true">
                  <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z"/>
                  <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z"/>
                </svg>
                <span class="ml-3">Email</span>
              </a>
            </div>
            <div
                v-if="doctor.telephone"
                class="-ml-px flex w-0 flex-1">
              <a :href="`tel:${doctor.telephone}`"
                 class="relative inline-flex w-0 flex-1 items-center justify-center rounded-br-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500">
                <!-- Heroicon name: mini/phone -->
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                     fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd"
                        d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z"
                        clip-rule="evenodd"/>
                </svg>
                <span class="ml-3">Anrufen</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {useForm} from "@inertiajs/inertia-vue3";
import {ref} from "vue";

const props = defineProps({
  doctor: {
    required: true,
    type: Object,
  }
})

let dragging = ref(false)

let form = useForm({
  message: '',
  files: null,
});

const submit = () => {
  form.post(route('documents.store', props.doctor.id), {
    onSuccess: (data) => {
      console.log(data)
    }
  })
}

let input = (value) => {
  form.files = value.target.files
  console.log(value.target.files[0])
}

let remove = (key) => {
  console.log(form.files)
  form.files.splice(key, 1)
}

let embed = (file) => {
  return URL.createObjectURL(file)
}

let drop = (value) => {
  form.files = [... value.dataTransfer.files]
  dragging.value = false
  value.stopPropagation()
  value.preventDefault()
}
</script>

<style scoped>

</style>
