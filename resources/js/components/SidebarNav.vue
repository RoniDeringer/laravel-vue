<template>
  <div class="relative flex h-full flex-col px-4 py-5">
    <div
      class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_20%_10%,rgba(99,102,241,0.35),transparent_45%),radial-gradient(circle_at_70%_30%,rgba(168,85,247,0.25),transparent_50%),radial-gradient(circle_at_40%_80%,rgba(56,189,248,0.18),transparent_55%)] opacity-70"
    />

    <RouterLink
      to="/"
      class="group relative z-10 flex items-center gap-3 rounded-2xl px-3 py-2.5 ring-1 ring-white/10 backdrop-blur"
    >
      <div
        class="grid h-11 w-11 place-items-center rounded-2xl bg-gradient-to-br from-indigo-500/25 via-fuchsia-500/20 to-sky-500/15 ring-1 ring-white/10 shadow-[0_0_24px_rgba(99,102,241,0.18)]"
      >
        <IconSalad class="h-6 w-6 text-white" />
      </div>
      <div class="min-w-0">
        <div class="truncate text-sm font-semibold text-white">Project mixed salad</div>
        <div class="truncate text-xs text-slate-300">Laravel • Vue • Tailwind</div>
      </div>
    </RouterLink>

    <div class="relative z-10 mt-6 space-y-1">
      <NavItem to="/dashboard" label="Dashboard">
        <template #icon><IconDashboard /></template>
      </NavItem>
      <NavItem to="/email" label="Envio de email">
        <template #icon><IconMail /></template>
      </NavItem>
      <NavItem to="/clientes" label="Tabela Clientes">
        <template #icon><IconUsers /></template>
      </NavItem>
    </div>
  </div>
</template>

<script setup>
import { RouterLink } from 'vue-router'
import NavItem from './SidebarNavItem.vue'
import IconDashboard from '../icons/IconDashboard.vue'
import IconMail from '../icons/IconMail.vue'
import IconSalad from '../icons/IconSalad.vue'
import IconUsers from '../icons/IconUsers.vue'
</script>
