<template>
  <div class="mx-auto max-w-5xl">
    <div class="rounded-3xl border border-slate-200/70 bg-white/70 p-8 shadow-sm backdrop-blur">
      <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
        <div class="min-w-0">
          <h1 class="text-2xl font-semibold text-slate-900 md:text-3xl">Boas-vindas 👋</h1>
          <p class="mt-3 max-w-2xl text-base leading-relaxed text-slate-700">
            Este projeto é um laboratório de estudos para experimentar novas ferramentas, padrões e
            conceitos. A ideia é construir as telas e componentes de forma <b>manual</b>, praticando
            Tailwind CSS “na mão” (sem biblioteca de UI pronta) e evoluindo a organização do código
            com o tempo.
          </p>
        </div>

        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 md:grid-cols-2">
          <Badge alt="Laravel" :icon-src="icons.laravel" value="12" />
          <Badge alt="Vue" :icon-src="icons.vue" value="3" />
          <Badge alt="Tailwind CSS" :icon-src="icons.tailwind" value="4" />
          <Badge alt="Vite" :icon-src="icons.vite" value="6" />
        </div>
      </div>

      <div class="mt-8 grid gap-4 md:grid-cols-3">
        <InfoCard title="Foco">
          Aprender de verdade: utilitários, design system, layout, acessibilidade e componentes
          reutilizáveis.
        </InfoCard>
        <InfoCard title="Prática">
          Telas simples primeiro, depois evolução para tabelas, formulários, validações e estados de
          carregamento.
        </InfoCard>
        <InfoCard title="Organização">
          Separar layout, views e componentes. Manter o projeto legível e consistente conforme cresce.
        </InfoCard>
      </div>
    </div>
  </div>
</template>

<script setup>
import Badge from '../components/ui/BadgePill.vue'
import InfoCard from '../components/ui/InfoCard.vue'

const icons = {
  laravel: 'https://skillicons.dev/icons?i=laravel&theme=light',
  vue: 'https://skillicons.dev/icons?i=vue&theme=light',
  tailwind: 'https://skillicons.dev/icons?i=tailwind&theme=light',
  vite: 'https://skillicons.dev/icons?i=vite&theme=light',
}
</script>
