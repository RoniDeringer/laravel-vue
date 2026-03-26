<template>
  <div class="rounded-3xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface)] p-6 shadow-sm backdrop-blur">
    <div class="text-sm font-semibold text-[color:var(--ms-muted)]">{{ title }}</div>
    <div class="mt-3 text-xl font-semibold text-[color:var(--ms-text)]">{{ value }}</div>
  </div>
</template>

<script setup>
defineProps({
  title: { type: String, required: true },
  value: { type: String, required: true },
})
</script>
