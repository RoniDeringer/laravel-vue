<template>
  <teleport to="body">
    <div
      v-if="open"
      class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 p-4"
      role="dialog"
      aria-modal="true"
      @click.self="close"
    >
      <div
        class="w-full max-w-2xl max-h-[88vh] overflow-hidden rounded-3xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-solid)] p-7 shadow-2xl"
      >
        <div class="flex items-start gap-3">
          <div
            class="mt-0.5 inline-flex h-10 w-10 flex-none items-center justify-center rounded-2xl border"
            :class="iconClass"
          >
            <component :is="iconComponent" class="h-5 w-5" :class="iconColorClass" />
          </div>

          <div class="min-w-0 flex-1 overflow-hidden">
            <h2 class="text-lg font-semibold text-[color:var(--ms-text)]">
              {{ title }}
            </h2>
            <p v-if="text" class="mt-1 text-sm text-[color:var(--ms-muted)]">
              {{ text }}
            </p>

            <div v-if="details" class="mt-4">
              <pre
                class="max-h-[60vh] overflow-auto rounded-2xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2-solid)] p-4 text-xs text-[color:var(--ms-text)]"
              ><code>{{ details }}</code></pre>
            </div>
          </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
          <button
            type="button"
            class="inline-flex cursor-pointer items-center justify-center rounded-xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2-solid)] px-5 py-2.5 text-sm font-semibold text-[color:var(--ms-text)] transition hover:bg-[color:var(--ms-surface-2)]"
            @click="close"
          >
            OK
          </button>
        </div>
      </div>
    </div>
  </teleport>
</template>

<script setup>
import { computed } from 'vue'
import IconCheckCircle from '../../icons/IconCheckCircle.vue'
import IconInfoCircle from '../../icons/IconInfoCircle.vue'
import IconXCircle from '../../icons/IconXCircle.vue'

const props = defineProps({
  open: { type: Boolean, default: false },
  type: { type: String, default: 'info' }, // info | success | error
  title: { type: String, default: '' },
  text: { type: String, default: '' },
  details: { type: String, default: '' },
})

const emit = defineEmits(['close'])

function close() {
  emit('close')
}

const iconComponent = computed(() => {
  if (props.type === 'success') return IconCheckCircle
  if (props.type === 'error') return IconXCircle
  return IconInfoCircle
})

const iconColorClass = computed(() => {
  if (props.type === 'success') return 'text-emerald-700 dark:text-emerald-200'
  if (props.type === 'error') return 'text-rose-700 dark:text-rose-200'
  return 'text-sky-700 dark:text-sky-200'
})

const iconClass = computed(() => {
  if (props.type === 'success') return 'border-emerald-400/30 bg-emerald-500/10'
  if (props.type === 'error') return 'border-rose-400/30 bg-rose-500/10'
  return 'border-sky-400/30 bg-sky-500/10'
})
</script>
