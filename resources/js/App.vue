<template>
  <div
    class="min-h-screen bg-[color:var(--ms-bg)] text-[color:var(--ms-text)]"
  >
    <div
      class="pointer-events-none fixed inset-0 -z-10 bg-[radial-gradient(circle_at_18%_0%,rgba(124,58,237,0.20),transparent_45%),radial-gradient(circle_at_88%_15%,rgba(217,70,239,0.14),transparent_48%),radial-gradient(circle_at_52%_96%,rgba(167,139,250,0.10),transparent_55%)] opacity-85 dark:bg-[radial-gradient(circle_at_20%_0%,rgba(167,139,250,0.24),transparent_42%),radial-gradient(circle_at_84%_12%,rgba(240,171,252,0.16),transparent_48%),radial-gradient(circle_at_50%_92%,rgba(124,58,237,0.14),transparent_55%)] dark:opacity-70"
    />
    <div class="flex min-h-screen">
      <aside
        class="sticky top-0 relative h-dvh w-72 shrink-0 overflow-hidden border-r border-[color:var(--ms-border)] bg-[color:var(--ms-surface)] backdrop-blur"
      >
        <SidebarNav />
      </aside>

      <div class="flex min-w-0 flex-1 flex-col">
        <main class="flex-1 p-6 md:p-10">
          <RouterView />
        </main>

        <AppFooter class="border-t border-[color:var(--ms-border)] bg-[color:var(--ms-surface)]" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { RouterView } from 'vue-router'
import AppFooter from './components/AppFooter.vue'
import SidebarNav from './components/SidebarNav.vue'
</script>
