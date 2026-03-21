<template>
  <footer class="px-6 py-4 md:px-10">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <div class="text-sm text-slate-600">
        Desenvolvido por <span class="font-semibold text-slate-800">Roni Deringer</span>. ©
        {{ year }}
      </div>

      <div class="flex items-center gap-3">
        <a
          class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-900/5 hover:text-slate-900"
          href="https://github.com/RoniDeringer/laravel-vue"
          target="_blank"
          rel="noreferrer"
        >
          <IconGitHub class="h-5 w-5 text-slate-700" />
          <span class="hidden sm:inline">GitHub</span>
        </a>
        <a
          class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-900/5 hover:text-slate-900"
          href="https://www.linkedin.com/in/ronideringer/"
          target="_blank"
          rel="noreferrer"
        >
          <IconLinkedIn class="h-5 w-5 text-slate-700" />
          <span class="hidden sm:inline">LinkedIn</span>
        </a>
      </div>
    </div>
  </footer>
</template>

<script setup>
import IconGitHub from '../icons/IconGitHub.vue'
import IconLinkedIn from '../icons/IconLinkedIn.vue'

const year = new Date().getFullYear()
</script>
