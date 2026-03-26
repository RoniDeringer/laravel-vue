<template>
  <div class="rounded-3xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2)] p-5 backdrop-blur">
    <div class="text-sm font-semibold text-[color:var(--ms-text)]">{{ title }}</div>
    <div class="mt-2 text-sm leading-relaxed text-[color:var(--ms-muted)]">
      <slot />
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: { type: String, required: true },
})
</script>
