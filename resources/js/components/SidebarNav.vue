<template>
  <div class="relative flex h-full flex-col px-4 py-5">
    <div
      class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_25%_10%,rgba(99,102,241,0.18),transparent_55%),radial-gradient(circle_at_75%_30%,rgba(168,85,247,0.12),transparent_58%),radial-gradient(circle_at_35%_85%,rgba(56,189,248,0.10),transparent_60%)] opacity-80 dark:opacity-60"
    />

    <RouterLink
      to="/"
      class="group relative z-10 flex items-center gap-3 rounded-2xl px-3 py-2.5 ring-1 ring-[color:var(--ms-border)] backdrop-blur transition hover:bg-violet-600/10"
    >
      <div
        class="grid h-11 w-11 place-items-center rounded-2xl bg-gradient-to-br from-violet-600/15 via-fuchsia-600/10 to-sky-500/10 ring-1 ring-[color:var(--ms-border)] shadow-[0_0_22px_rgba(124,58,237,0.14)]"
      >
        <IconSalad class="h-6 w-6 text-[color:var(--ms-text)]" />
      </div>
      <div class="min-w-0">
        <div class="truncate text-sm font-semibold text-[color:var(--ms-text)]">
          Project mixed salad
        </div>
        <div class="truncate text-xs text-[color:var(--ms-muted)]">Laravel • Vue • Tailwind</div>
      </div>
    </RouterLink>

    <div class="relative z-10 mt-6 flex min-h-0 flex-1 flex-col">
      <div class="space-y-1 overflow-y-auto pr-1">
        <NavItem to="/dashboard" label="Dashboard">
          <template #icon><IconDashboard /></template>
        </NavItem>
        <NavItem to="/email" label="Envio de email">
          <template #icon><IconMail /></template>
        </NavItem>
        <NavItem to="/jobs" label="Execuções jobs">
          <template #icon><IconSpark /></template>
        </NavItem>
        <NavItem to="/cidades" label="Listagem cidades">
          <template #icon><IconUsers /></template>
        </NavItem>
      </div>
    </div>

    <div class="relative z-10 mt-auto pt-6">
      <button
        type="button"
        class="group flex w-full cursor-pointer items-center justify-between rounded-2xl px-3 py-2.5 ring-1 ring-[color:var(--ms-border)] transition hover:bg-violet-600/10 focus:outline-none focus:ring-4 focus:ring-violet-600/15"
        :aria-label="theme === 'dark' ? 'Ativar tema claro' : 'Ativar tema escuro'"
        @click="onToggleTheme"
      >
        <span class="flex items-center gap-2">
          <IconMoon v-if="theme !== 'dark'" class="h-5 w-5 text-[color:var(--ms-muted)]" />
          <IconSun v-else class="h-5 w-5 text-[color:var(--ms-muted)]" />
        </span>

        <span
          class="relative inline-flex h-7 w-12 items-center rounded-full bg-[color:var(--ms-surface-2)] ring-1 ring-inset ring-[color:var(--ms-border)] transition"
        >
          <span
            class="absolute left-1 h-5 w-5 rounded-full bg-white shadow-sm ring-1 ring-[color:var(--ms-border)] transition-transform dark:bg-gradient-to-br dark:from-violet-200 dark:via-fuchsia-200 dark:to-sky-200"
            :class="theme === 'dark' ? 'translate-x-5' : 'translate-x-0'"
          />
        </span>
      </button>
    </div>
  </div>
</template>

<script setup>
import { RouterLink } from 'vue-router'
import NavItem from './SidebarNavItem.vue'
import IconDashboard from '../icons/IconDashboard.vue'
import IconMail from '../icons/IconMail.vue'
import IconMoon from '../icons/IconMoon.vue'
import IconSalad from '../icons/IconSalad.vue'
import IconSpark from '../icons/IconSpark.vue'
import IconSun from '../icons/IconSun.vue'
import IconUsers from '../icons/IconUsers.vue'
import { useTheme } from '../composables/useTheme'

const { theme, toggleTheme } = useTheme()

async function onToggleTheme() {
  await toggleTheme()
}
</script>
