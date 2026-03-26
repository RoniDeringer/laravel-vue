<template>
  <RouterLink
    :to="to"
    class="group relative flex items-center gap-3 rounded-2xl px-3 py-2.5 text-sm font-medium transition"
    :class="
      isActive
        ? 'bg-violet-600/10 text-[color:var(--ms-text)] ring-1 ring-inset ring-violet-600/15 after:absolute after:inset-y-2 after:left-2 after:w-1 after:rounded-full after:bg-gradient-to-b after:from-violet-500 after:to-fuchsia-500'
        : 'text-[color:var(--ms-muted)] hover:bg-violet-600/10 hover:text-[color:var(--ms-text)]'
    "
  >
    <span
      class="grid h-9 w-9 place-items-center rounded-lg transition"
      :class="
        isActive
          ? 'bg-violet-600/10 text-violet-700 ring-1 ring-violet-600/15'
          : 'bg-[color:var(--ms-surface-2)] text-[color:var(--ms-muted)] ring-1 ring-[color:var(--ms-border)] group-hover:bg-violet-600/10 group-hover:text-[color:var(--ms-text)]'
      "
    >
      <slot name="icon" />
    </span>
    <span class="truncate">{{ label }}</span>
  </RouterLink>
</template>

<script setup>
import { computed } from 'vue'
import { RouterLink, useRoute } from 'vue-router'

const props = defineProps({
  to: { type: String, required: true },
  label: { type: String, required: true },
})

const route = useRoute()
const isActive = computed(() => route.path === props.to)
</script>
