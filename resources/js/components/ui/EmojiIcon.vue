<template>
  <span
    class="inline-flex"
    aria-hidden="true"
    v-html="html"
  />
</template>

<script setup>
import { computed } from 'vue'
import * as nodeEmoji from 'node-emoji'
import twemoji from 'twemoji'

const props = defineProps({
  name: { type: String, required: true },
  class: { type: String, default: '' },
})

const unicode = computed(() => {
  const normalized = props.name.replaceAll(':', '')
  const value = nodeEmoji.get(normalized)
  return value === `:${normalized}:` ? '' : value
})

const html = computed(() => {
  if (!unicode.value) return ''

  const parsed = twemoji.parse(unicode.value, {
    folder: 'svg',
    ext: '.svg',
    className: props.class || undefined,
  })

  return parsed
})
</script>
