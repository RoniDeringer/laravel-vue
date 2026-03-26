<template>
  <div
    class="rounded-2xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2)] px-4 py-3 shadow-sm backdrop-blur"
  >
    <div class="flex items-center justify-between gap-3">
      <img
        :alt="alt"
        :src="iconSrc"
        class="h-6 w-6"
        loading="lazy"
        decoding="async"
      />
      <div class="text-lg font-semibold text-[color:var(--ms-text)]">{{ value }}</div>
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
