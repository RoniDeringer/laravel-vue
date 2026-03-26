<template>
  <div class="mx-auto max-w-6xl">
    <header class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
      <div class="flex flex-col gap-2">
        <h1 class="text-2xl font-semibold">Execuções de Jobs</h1>
        <p class="text-[color:var(--ms-muted)]">
          Histórico local de execução (processing / processed / failed) com log e detalhes do job.
        </p>
      </div>

      <RouterLink
        to="/email"
        class="group inline-flex cursor-pointer items-center justify-center rounded-xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2-solid)] px-4 py-2.5 text-sm font-semibold text-[color:var(--ms-text)] transition hover:bg-white/70 focus:outline-none focus:ring-4 focus:ring-violet-500/20 dark:hover:bg-white/10"
      >
        <IconArrowLeft class="mr-2 h-5 w-5 text-[color:var(--ms-muted)] transition group-hover:text-[color:var(--ms-accent)]" />
        Voltar para Email
      </RouterLink>
    </header>

    <section
      class="mt-6 overflow-hidden rounded-3xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface)] shadow-sm backdrop-blur"
    >
      <div class="flex flex-col gap-4 p-5 md:flex-row md:items-end md:justify-between">
        <div class="grid w-full gap-3 md:max-w-3xl md:grid-cols-3">
          <Field label="Pesquisar">
            <input
              v-model="searchInput"
              list="job-suggestions"
              class="w-full cursor-text rounded-xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2)] px-4 py-2.5 text-sm text-[color:var(--ms-text)] outline-none ring-violet-500/20 transition focus:ring-4 placeholder:text-slate-500/80 dark:placeholder:text-slate-400/70"
              placeholder="Job ID, classe ou erro..."
              type="search"
              autocomplete="off"
            />
            <datalist id="job-suggestions">
              <option v-for="row in rows.slice(0, 30)" :key="row.id" :value="row.job_id">
                {{ row.job_name }}
              </option>
            </datalist>
          </Field>

          <Field label="Status">
            <select
              v-model="selectedStatus"
              class="w-full cursor-pointer rounded-xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2)] px-4 py-2.5 text-sm text-[color:var(--ms-text)] outline-none ring-violet-500/20 transition focus:ring-4"
            >
              <option value="">Todos</option>
              <option value="processing">processing</option>
              <option value="processed">processed</option>
              <option value="failed">failed</option>
            </select>
          </Field>

          <Field label="Queue">
            <select
              v-model="selectedQueue"
              class="w-full cursor-pointer rounded-xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2)] px-4 py-2.5 text-sm text-[color:var(--ms-text)] outline-none ring-violet-500/20 transition focus:ring-4"
            >
              <option value="">Todas</option>
              <option v-for="q in queues" :key="q" :value="q">{{ q }}</option>
            </select>
          </Field>
        </div>

        <div class="flex items-center justify-between gap-3 md:justify-end">
          <div class="text-sm text-[color:var(--ms-muted)]">
            <span class="font-semibold text-[color:var(--ms-text)]">{{ filteredCount }}</span>
            resultados
          </div>

          <button
            type="button"
            class="group inline-flex cursor-pointer items-center justify-center rounded-xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2)] px-4 py-2.5 text-sm font-semibold text-[color:var(--ms-text)] transition hover:bg-white/70 dark:hover:bg-white/10"
            :class="{ 'pointer-events-none opacity-70': loading }"
            @click="load"
          >
            Atualizar
            <IconRefresh class="ml-2 h-5 w-5 text-[color:var(--ms-muted)] transition group-hover:text-[color:var(--ms-accent)]" />
          </button>
        </div>
      </div>

      <div class="border-t border-[color:var(--ms-border)]">
        <div v-if="loading" class="p-6">
          <div class="flex items-center gap-3 text-[color:var(--ms-muted)]">
            <span class="h-5 w-5 animate-spin rounded-full border-2 border-slate-300 border-t-violet-500 dark:border-white/15" />
            Carregando execuções...
          </div>
        </div>

        <div v-else-if="error" class="p-6">
          <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-rose-800">
            <div class="font-semibold">Falha ao carregar dados</div>
            <div class="mt-1 text-sm">{{ error }}</div>
          </div>
        </div>

        <div v-else class="overflow-x-auto">
          <table class="min-w-full text-left text-sm">
            <thead class="bg-[color:var(--ms-surface-2)] text-xs uppercase tracking-wide text-[color:var(--ms-muted)]">
              <tr>
                <th class="px-5 py-3 font-semibold">Status</th>
                <th class="px-5 py-3 font-semibold">Job</th>
                <th class="px-5 py-3 font-semibold">Queue</th>
                <th class="px-5 py-3 font-semibold">Duração</th>
                <th class="px-5 py-3 font-semibold">Quando</th>
                <th class="px-5 py-3 font-semibold"></th>
              </tr>
            </thead>
            <tbody class="divide-y divide-[color:var(--ms-border)]">
              <tr
                v-for="row in pageRows"
                :key="row.id"
                class="hover:bg-slate-900/[0.02] dark:hover:bg-white/5"
              >
                <td class="px-5 py-4">
                  <span
                    class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset"
                    :class="statusClass(row.status)"
                  >
                    {{ row.status }}
                  </span>
                </td>
                <td class="px-5 py-4">
                  <div class="font-semibold">{{ shortJobName(row.job_name) }}</div>
                  <div class="mt-1 font-mono text-xs text-[color:var(--ms-muted)]">{{ row.job_id }}</div>
                  <div v-if="row.last_error" class="mt-2 line-clamp-2 text-xs text-rose-600">
                    {{ row.last_error }}
                  </div>
                </td>
                <td class="px-5 py-4 text-[color:var(--ms-muted)]">{{ row.queue || '-' }}</td>
                <td class="px-5 py-4 text-[color:var(--ms-muted)]">
                  {{ row.duration_ms ? `${row.duration_ms}ms` : '-' }}
                </td>
                <td class="px-5 py-4 text-[color:var(--ms-muted)]">
                  {{ formatDate(row.created_at) }}
                </td>
                <td class="px-5 py-4 text-right">
                  <button
                    type="button"
                    class="group inline-flex cursor-pointer items-center justify-center rounded-xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2)] px-3 py-2 text-xs font-semibold text-[color:var(--ms-text)] transition hover:bg-white/70 dark:hover:bg-white/10"
                    @click="openLog(row.id)"
                  >
                    Ver log
                    <IconScroll class="ml-2 h-4 w-4 text-[color:var(--ms-muted)] transition group-hover:text-[color:var(--ms-accent)]" />
                  </button>
                </td>
              </tr>

              <tr v-if="pageRows.length === 0">
                <td class="px-5 py-6 text-[color:var(--ms-text)]" colspan="6">
                  <div class="flex flex-col gap-1">
                    <div class="font-semibold">Nenhum resultado</div>
                    <div class="text-[color:var(--ms-muted)]">Tente ajustar os filtros ou a busca.</div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="flex flex-col gap-3 border-t border-[color:var(--ms-border)] p-5 sm:flex-row sm:items-center sm:justify-between">
        <div class="text-sm text-[color:var(--ms-muted)]">
          Página <span class="font-semibold text-[color:var(--ms-text)]">{{ page }}</span> de
          <span class="font-semibold text-[color:var(--ms-text)]">{{ totalPages }}</span>
        </div>

        <div class="flex items-center gap-2">
          <button
            type="button"
            class="rounded-xl px-3 py-2 text-sm font-semibold ring-1 ring-inset transition"
            :class="
              page === 1
                ? 'cursor-not-allowed bg-slate-900/5 text-[color:var(--ms-muted)] opacity-60 ring-[color:var(--ms-border)]'
                : 'cursor-pointer bg-[color:var(--ms-surface-2)] text-[color:var(--ms-text)] ring-[color:var(--ms-border)] hover:bg-white/70 dark:hover:bg-white/10'
            "
            :disabled="page === 1"
            @click="page = Math.max(1, page - 1)"
          >
            Anterior
          </button>

          <button
            v-for="p in pageButtons"
            :key="p"
            type="button"
            class="hidden rounded-xl px-3 py-2 text-sm font-semibold ring-1 ring-inset transition sm:inline-flex"
            :class="
              p === page
                ? 'cursor-pointer bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white ring-violet-600/25'
                : 'cursor-pointer bg-[color:var(--ms-surface-2)] text-[color:var(--ms-text)] ring-[color:var(--ms-border)] hover:bg-white/70 dark:hover:bg-white/10'
            "
            @click="page = p"
          >
            {{ p }}
          </button>

          <button
            type="button"
            class="rounded-xl px-3 py-2 text-sm font-semibold ring-1 ring-inset transition"
            :class="
              page === totalPages
                ? 'cursor-not-allowed bg-slate-900/5 text-[color:var(--ms-muted)] opacity-60 ring-[color:var(--ms-border)]'
                : 'cursor-pointer bg-[color:var(--ms-surface-2)] text-[color:var(--ms-text)] ring-[color:var(--ms-border)] hover:bg-white/70 dark:hover:bg-white/10'
            "
            :disabled="page === totalPages"
            @click="page = Math.min(totalPages, page + 1)"
          >
            Próxima
          </button>
        </div>
      </div>
    </section>

    <SweetAlert
      :open="alert.open"
      :type="alert.type"
      :title="alert.title"
      :text="alert.text"
      :details="alert.details"
      @close="alert.open = false"
    />
  </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref, watch } from 'vue'
import Field from '../components/ui/Field.vue'
import SweetAlert from '../components/ui/SweetAlert.vue'
import IconArrowLeft from '../icons/IconArrowLeft.vue'
import IconRefresh from '../icons/IconRefresh.vue'
import IconScroll from '../icons/IconScroll.vue'

const rows = ref([])
const loading = ref(false)
const error = ref('')

const perPage = 10
const page = ref(1)

const selectedStatus = ref('')
const selectedQueue = ref('')

const searchInput = ref('')
const search = ref('')
let searchTimer = 0

watch(searchInput, (value) => {
  window.clearTimeout(searchTimer)
  searchTimer = window.setTimeout(() => {
    search.value = (value ?? '').trim()
    page.value = 1
  }, 150)
})

watch([selectedStatus, selectedQueue], () => {
  page.value = 1
})

const queues = computed(() => {
  const list = new Set(rows.value.map((r) => r.queue).filter(Boolean))
  return Array.from(list).sort()
})

const filteredRows = computed(() => {
  const query = search.value.toLowerCase()

  return rows.value.filter((row) => {
    if (selectedStatus.value && row.status !== selectedStatus.value) return false
    if (selectedQueue.value && row.queue !== selectedQueue.value) return false

    if (!query) return true

    const haystack = `${row.job_id} ${row.job_name ?? ''} ${row.last_error ?? ''}`.toLowerCase()
    return haystack.includes(query)
  })
})

const filteredCount = computed(() => filteredRows.value.length)

const totalPages = computed(() => Math.max(1, Math.ceil(filteredRows.value.length / perPage)))

watch(totalPages, (tp) => {
  if (page.value > tp) page.value = tp
})

const pageRows = computed(() => {
  const start = (page.value - 1) * perPage
  return filteredRows.value.slice(start, start + perPage)
})

const pageButtons = computed(() => {
  const tp = totalPages.value
  const current = page.value
  const from = Math.max(1, current - 2)
  const to = Math.min(tp, current + 2)
  const list = []
  for (let p = from; p <= to; p += 1) list.push(p)
  return list
})

const alert = reactive({
  open: false,
  type: 'info',
  title: '',
  text: '',
  details: '',
})

function showAlert({ type, title, text, details }) {
  alert.type = type
  alert.title = title
  alert.text = text ?? ''
  alert.details = details ?? ''
  alert.open = true
}

function statusClass(status) {
  if (status === 'processed')
    return 'bg-emerald-50 text-emerald-950 ring-emerald-700/25 shadow-sm dark:bg-emerald-500/15 dark:text-emerald-100 dark:ring-emerald-400/40'
  if (status === 'failed')
    return 'bg-rose-50 text-rose-950 ring-rose-700/25 shadow-sm dark:bg-rose-500/15 dark:text-rose-100 dark:ring-rose-400/40'
  return 'bg-violet-50 text-violet-950 ring-violet-700/25 shadow-sm dark:bg-violet-500/15 dark:text-violet-100 dark:ring-violet-400/40'
}

function shortJobName(name) {
  if (!name) return '-'
  const parts = String(name).split('\\\\')
  return parts[parts.length - 1] || name
}

function formatDate(value) {
  if (!value) return '-'
  try {
    const d = new Date(value)
    return new Intl.DateTimeFormat('pt-BR', { dateStyle: 'short', timeStyle: 'medium' }).format(d)
  } catch {
    return String(value)
  }
}

async function load() {
  loading.value = true
  error.value = ''

  try {
    const response = await fetch('/api/jobs/executions?limit=200', {
      headers: { Accept: 'application/json' },
    })

    if (!response.ok) throw new Error(`HTTP ${response.status}`)

    const json = await response.json()
    rows.value = json?.data ?? []
  } catch (e) {
    error.value = e instanceof Error ? e.message : 'Erro desconhecido'
  } finally {
    loading.value = false
  }
}

async function openLog(id) {
  try {
    const response = await fetch(`/api/jobs/executions/${id}`, {
      headers: { Accept: 'application/json' },
    })
    if (!response.ok) throw new Error(`HTTP ${response.status}`)

    const json = await response.json()
    const data = json?.data
    if (!data) throw new Error('Sem dados')

    const details = [
      data.log ? `LOG\n${data.log}` : '',
      data.exception_class ? `\nEXCEPTION\n${data.exception_class}\n${data.last_error ?? ''}\n` : '',
      data.exception_trace ? `\nTRACE\n${data.exception_trace}` : '',
      data.payload ? `\nPAYLOAD\n${JSON.stringify(data.payload, null, 2)}` : '',
    ]
      .filter(Boolean)
      .join('\n')
      .trim()

    showAlert({
      type: data.status === 'failed' ? 'error' : data.status === 'processed' ? 'success' : 'info',
      title: `${shortJobName(data.job_name)} • ${data.status}`,
      text: `Queue: ${data.queue ?? '-'} • Duração: ${data.duration_ms ? `${data.duration_ms}ms` : '-'}`,
      details,
    })
  } catch (e) {
    showAlert({
      type: 'error',
      title: 'Falha ao abrir log',
      text: e instanceof Error ? e.message : 'Erro desconhecido',
      details: '',
    })
  }
}

onMounted(load)
</script>
