<template>
  <section class="mt-6 overflow-hidden rounded-3xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface)] shadow-sm backdrop-blur">
    <div
      class="flex items-center justify-between gap-3 border-b border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2)] px-4 py-3"
    >
      <a
        :href="href"
        target="_blank"
        rel="noreferrer"
        class="inline-flex min-w-0 items-center gap-2 rounded-lg px-2 py-1 text-sm font-semibold text-slate-800 transition hover:bg-slate-900/5"
        :title="href"
      >
        <span class="grid h-5 w-5 place-items-center rounded-md bg-violet-600/10 text-violet-700 ring-1 ring-violet-600/15">
          <span class="text-[10px] font-bold leading-none">PHP</span>
        </span>
        <span class="truncate">{{ filename }}</span>
      </a>

      <div class="flex items-center gap-2">
        <span class="h-2.5 w-2.5 rounded-full bg-rose-400/80" />
        <span class="h-2.5 w-2.5 rounded-full bg-amber-300/90" />
        <span class="h-2.5 w-2.5 rounded-full bg-emerald-400/80" />
      </div>
    </div>

    <div class="bg-[#1e1e1e] text-[#d4d4d4]">
      <div class="overflow-x-auto">
        <div class="grid min-w-[720px] grid-cols-[auto_1fr] font-mono text-[12.5px] leading-6">
          <div class="select-none border-r border-white/10 bg-[#1b1b1b] px-3 py-4 text-right text-[#858585]">
            <div v-for="n in lines.length" :key="n">{{ n }}</div>
          </div>
          <pre class="m-0 px-4 py-4"><code v-html="highlighted" /></pre>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  filename: { type: String, required: true },
  href: { type: String, required: true },
  code: { type: String, required: true },
})

const lines = computed(() => props.code.replace(/\r\n/g, '\n').split('\n'))

function escapeHtml(text) {
  return text
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;')
}

function highlightPhp(code) {
  let out = escapeHtml(code)

  // Comments
  out = out.replaceAll(/(\/\/.*)$/gm, '<span style="color:#6A9955">$1</span>')
  out = out.replaceAll(/(\/\*[\s\S]*?\*\/)/g, '<span style="color:#6A9955">$1</span>')

  // Strings
  out = out.replaceAll(/(&quot;.*?&quot;|&#039;.*?&#039;)/g, '<span style="color:#CE9178">$1</span>')

  // Keywords (simple)
  out = out.replaceAll(
    /\b(namespace|use|class|public|protected|private|function|return|new|extends|implements|final|static|if|else|try|catch|throw)\b/g,
    '<span style="color:#C586C0">$1</span>',
  )

  // Types
  out = out.replaceAll(/\b(bool|int|float|string|array|void|mixed)\b/g, '<span style="color:#4EC9B0">$1</span>')

  // Variables
  out = out.replaceAll(/(\$[A-Za-z_][A-Za-z0-9_]*)/g, '<span style="color:#9CDCFE">$1</span>')

  // PHP open tag
  out = out.replaceAll(/(&lt;\?php)/g, '<span style="color:#569CD6">$1</span>')

  return out
}

const highlighted = computed(() => highlightPhp(props.code).replace(/\r\n/g, '\n'))
</script>
