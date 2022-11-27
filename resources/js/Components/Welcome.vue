<script setup>
import {InertiaLink} from "@inertiajs/inertia-vue3";
</script>

<template>
  <div>
    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
      <h1 class="text-3xl">Med-Database</h1>

      <div class="mt-8 text-2xl">
        Willkommen in der Med-Database
      </div>

      <div class="mt-6 text-gray-500">
        Tausche sicher deine medizinischen Daten mit deinen Ärzten aus. <br>
        Verwalte deine Dokumente in einer sicheren Cloud.
      </div>
    </div>

    <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
      <div class="p-6">
        <div class="flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
               stroke="currentColor" class="w-8 h-8 text-gray-400">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/>
          </svg>

          <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
            <a href="https://laravel.com/docs">Ärzteverzeichnis</a>
          </div>
        </div>

        <div class="ml-12">
          <div class="mt-2 text-sm text-gray-500">
            Finde Ärzte in deiner Nähe und tausche deine medizinischen Daten mit Ihnen aus.
          </div>

          <InertiaLink href="/doctors">
            <div class="mt-3 flex items-center text-sm font-semibold text-orange-700">
              <div>Zum Verzeichnis</div>

              <div class="ml-1 text-orange-500">
                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                  <path fill-rule="evenodd"
                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                        clip-rule="evenodd"/>
                </svg>
              </div>
            </div>
          </InertiaLink>
        </div>
      </div>

      <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
        <div class="flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
               stroke="currentColor" class="w-8 h-8 text-gray-400">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
          </svg>

          <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
            <a href="https://laracasts.com">Meine Dokumente</a>
          </div>
        </div>

        <div class="ml-12">
          <div class="mt-2 text-sm text-gray-500">
            Deine bisher hochgeladenen Dokumente einsehen und bearbeiten.
          </div>

          <a href="https://laracasts.com">
            <div class="mt-3 flex items-center text-sm font-semibold text-orange-700">
              <div>Zu meinen Dokumenten</div>

              <div class="ml-1 text-orange-500">
                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                  <path fill-rule="evenodd"
                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                        clip-rule="evenodd"/>
                </svg>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>
