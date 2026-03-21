<template>
  <div class="mx-auto max-w-6xl">
    <header class="flex flex-col gap-2">
      <h1 class="text-2xl font-semibold text-slate-900">Dashboard</h1>
      <p class="text-slate-600">
        Um lugar para concentrar cards, métricas e atalhos conforme o projeto evoluir.
      </p>
    </header>

    <div class="mt-6 grid gap-4 md:grid-cols-3">
      <StatCard title="Aprendizados" value="Em construção" />
      <StatCard title="Componentes" value="Em construção" />
      <StatCard title="Telas" value="Em construção" />
    </div>
  </div>
</template>

<script setup>
import StatCard from '../components/ui/StatCard.vue'
</script>
