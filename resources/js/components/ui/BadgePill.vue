<template>
  <div
    class="rounded-2xl border border-slate-200/70 bg-slate-50/70 px-4 py-3 shadow-sm"
  >
    <div class="flex items-center justify-between gap-3">
      <img
        :alt="alt"
        :src="iconSrc"
        class="h-6 w-6"
        loading="lazy"
        decoding="async"
      />
      <div class="text-lg font-semibold text-slate-900">{{ value }}</div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  value: { type: String, required: true },
  iconSrc: { type: String, required: true },
  alt: { type: String, required: true },
})
</script>
