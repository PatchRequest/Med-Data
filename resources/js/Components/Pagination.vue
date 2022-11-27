<template>
  <div class="mt-4" v-if="links.length > 3">
    <div class="flex flex-wrap -mb-1 justify-center">
      <template v-for="link in links">
        <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 bg-white text-sm leading-4 text-gray-400 border rounded" v-html="link.label" />
        <inertia-link v-else class="mr-1 mb-1 px-4 py-3  text-sm leading-4 border rounded focus:border-orange-500 focus:text-orange-500" :class="{ 'bg-orange-300 hover:bg-orange-600': link.active, 'bg-white': !link.active }" :href="link.url" v-html="link.label" />
      </template>
    </div>
  </div>
</template>

<script setup>
import {InertiaLink} from "@inertiajs/inertia-vue3";

defineProps({
  links: {
    type: Array,
    required: true,
  },
});
</script>
