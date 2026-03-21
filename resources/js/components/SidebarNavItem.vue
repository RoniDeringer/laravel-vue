<template>
  <RouterLink
    :to="to"
    class="group relative flex items-center gap-3 rounded-2xl px-3 py-2.5 text-sm font-medium transition"
    :class="
      isActive
        ? 'bg-gradient-to-r from-indigo-500/25 via-fuchsia-500/15 to-sky-500/10 text-white ring-1 ring-inset ring-white/12 shadow-[0_0_18px_rgba(99,102,241,0.10)] after:absolute after:inset-y-2 after:left-2 after:w-1 after:rounded-full after:bg-gradient-to-b after:from-indigo-300 after:to-fuchsia-300'
        : 'text-slate-200 hover:bg-white/10 hover:text-white'
    "
  >
    <span
      class="grid h-9 w-9 place-items-center rounded-lg transition"
      :class="
        isActive
          ? 'bg-white/10 text-white'
          : 'bg-white/5 text-slate-100 ring-1 ring-white/10 group-hover:bg-white/10'
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
