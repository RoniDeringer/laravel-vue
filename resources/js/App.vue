<template>
  <div
    class="min-h-screen bg-gradient-to-br from-slate-50 via-indigo-50/40 to-slate-100 text-slate-800"
  >
    <div class="flex min-h-screen">
      <aside
        class="relative w-72 shrink-0 overflow-hidden border-r border-white/10 bg-gradient-to-b from-slate-950 via-indigo-950/40 to-slate-900 shadow-[0_0_0_1px_rgba(255,255,255,0.04)]"
      >
        <SidebarNav />
      </aside>

      <div class="flex min-w-0 flex-1 flex-col">
        <main class="flex-1 p-6 md:p-10">
          <RouterView />
        </main>

        <AppFooter class="border-t border-slate-200/70 bg-white/60" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { RouterView } from 'vue-router'
import AppFooter from './components/AppFooter.vue'
import SidebarNav from './components/SidebarNav.vue'
</script>
