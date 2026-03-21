<template>
  <div class="rounded-3xl border border-slate-200/70 bg-white/60 p-5">
    <div class="text-sm font-semibold text-slate-900">{{ title }}</div>
    <div class="mt-2 text-sm leading-relaxed text-slate-700">
      <slot />
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: { type: String, required: true },
})
</script>
