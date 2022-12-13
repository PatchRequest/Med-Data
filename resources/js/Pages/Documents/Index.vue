<template>
  <AppLayout title="Geteilte Dokumente">

    <div class="max-w-7xl mx-auto py-12">
      <div class="bg-white shadow-lg p-12">

        <div class="text-lg">
          <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
              <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Geteilte Dokumente</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all the users in your account including their name,
                  title, search and role.</p>
              </div>
            </div>
            <div class="mt-8 flex flex-col">
              <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                  <div class="relative overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <div v-if="selectedDocuments.length > 0"
                         class="absolute top-0 left-12 flex h-12 items-center space-x-3 bg-gray-50 sm:left-16">
                      <button type="button" @click="removeSelected"
                              class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-30">
                        Ausgewähle löschen
                      </button>
                    </div>
                    <table class="min-w-full table-fixed divide-y divide-gray-300">
                      <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="relative w-12 px-6 sm:w-16 sm:px-8">
                          <input type="checkbox"
                                 class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-orange-600 focus:ring-orange-500 sm:left-6"
                                 :checked="indeterminate || selectedDocuments.length === documents.data.length"
                                 :indeterminate="indeterminate"
                                 @change="selectedDocuments = $event.target.checked ? documents.data.map((p) => p.id) : []"/>
                        </th>
                        <th scope="col" class="min-w-[12rem] py-3.5 pr-3 text-left text-sm font-semibold text-gray-900">
                          Dateiname
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Geteilt mit</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">

                            <div>
                              <label for="search" class="sr-only">Suchen</label>
                              <div class="relative mt-1 rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                  </svg>

                                </div>
                                <input v-model="search" type="text" name="search" id="search" class="block w-full rounded-md border-gray-300 pl-10 focus:border-orange-500 focus:ring-orange-500 sm:text-sm" placeholder="Suchen ..." />
                              </div>
                            </div>


                          <span class="sr-only">Edit</span>
                        </th>
                      </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 bg-white">
                      <tr v-for="document in (search.length ? filteredDocuments : documents.data)" :key="document.id"
                          :class="[selectedDocuments.includes(document.id) && 'bg-gray-50']">
                        <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                          <div v-if="selectedDocuments.includes(document.id)"
                               class="absolute inset-y-0 left-0 w-0.5 bg-orange-600"></div>
                          <input type="checkbox"
                                 class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-orange-600 focus:ring-orange-500 sm:left-6"
                                 :value="document.id" v-model="selectedDocuments"/>
                        </td>
                        <td :class="['whitespace-nowrap py-4 pr-3 text-sm font-medium', selectedDocuments.includes(document.id) ? 'text-orange-600' : 'text-gray-900']">
                          <a :href="route('documents.show', document.id)" target="_blank" class="inline-flex items-center hover:text-orange-400">
                            {{ filename(document.path) }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75v6.75m0 0l-3-3m3 3l3-3m-8.25 6a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                            </svg>

                          </a>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          {{ document.share.recipient.name }}
                        </td>
                        <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                          <button @click="remove(document.id)" class="text-orange-600 hover:text-orange-900"
                          >Löschen<span class="sr-only">, </span></button
                          >
                        </td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <Pagination :links="meta.links"/>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from "@/Components/Pagination.vue";
import {computed, ref} from 'vue'
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
  documents: {
    type: Object,
    required: true
  },
  meta: {
    type: Object,
    required: true
  }
})

const filename = (path) => {
  let parts = path.split('/');
  return parts[parts.length - 1]
}

let search = ref('')

const filteredDocuments = computed(() => {
  return props.documents.data.filter(document => {
    return filename(document.path).includes(search.value) || document.share.recipient.name.includes(search.value)
  })
})

const remove = (documentId) => {
  Inertia.delete(route('documents.destroy', documentId), {
    onSuccess: (data) => {
      console.log(data)
    }
  })
}

const removeSelected = () => {
  for(let documentId of selectedDocuments.value){
    console.log(documentId)
    remove(documentId)
  }
}

const selectedDocuments = ref([])
const indeterminate = computed(() => selectedDocuments.value.length > 0 && selectedDocuments.value.length < props.documents.data.length)

</script>

<style scoped>

</style>
