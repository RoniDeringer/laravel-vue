<template>
  <div class="rounded-3xl border border-slate-200/70 bg-white/70 p-6 shadow-sm">
    <div class="text-sm font-semibold text-slate-700">{{ title }}</div>
    <div class="mt-3 text-xl font-semibold text-slate-900">{{ value }}</div>
  </div>
</template>

<script setup>
defineProps({
  title: { type: String, required: true },
  value: { type: String, required: true },
})
</script>
