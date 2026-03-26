<template>
  <label class="grid gap-2">
    <span class="text-sm font-semibold text-[color:var(--ms-text)]">{{ label }}</span>
    <slot />
  </label>
</template>

<script setup>
defineProps({
  label: { type: String, required: true },
})
</script>
