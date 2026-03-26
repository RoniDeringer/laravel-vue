<template>
  <div class="mx-auto max-w-6xl">
    <header class="flex flex-col gap-2">
      <h1 class="text-2xl font-semibold">Listagem de cidades</h1>
      <p class="text-[color:var(--ms-muted)]">
        Dados carregados da API do IBGE, com filtros, pesquisa instantânea e paginação.
      </p>
    </header>

    <section class="mt-6 overflow-hidden rounded-3xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface)] shadow-sm backdrop-blur">
      <div class="flex flex-col gap-4 p-5 md:flex-row md:items-end md:justify-between">
        <div class="grid w-full gap-3 md:max-w-2xl md:grid-cols-3">
          <Field label="Pesquisar">
            <input
              v-model="searchInput"
              class="w-full cursor-text rounded-xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2)] px-4 py-2.5 text-sm text-[color:var(--ms-text)] outline-none ring-violet-500/20 transition focus:ring-4 placeholder:text-slate-500/80 dark:placeholder:text-slate-400/70"
              placeholder="Cidade, UF ou estado..."
              type="search"
              autocomplete="off"
            />
          </Field>

          <Field label="UF">
            <select
              v-model="selectedUf"
              class="w-full cursor-pointer rounded-xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2)] px-4 py-2.5 text-sm text-[color:var(--ms-text)] outline-none ring-violet-500/20 transition focus:ring-4"
            >
              <option value="">Todas</option>
              <option v-for="uf in ufs" :key="uf" :value="uf">{{ uf }}</option>
            </select>
          </Field>

          <Field label="Região">
            <select
              v-model="selectedRegion"
              class="w-full cursor-pointer rounded-xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2)] px-4 py-2.5 text-sm text-[color:var(--ms-text)] outline-none ring-violet-500/20 transition focus:ring-4"
            >
              <option value="">Todas</option>
              <option v-for="region in regions" :key="region" :value="region">
                {{ region }}
              </option>
            </select>
          </Field>
        </div>

        <div class="flex items-center justify-between gap-3 md:justify-end">
          <div class="text-sm text-[color:var(--ms-muted)]">
            <span class="font-semibold text-[color:var(--ms-text)]">{{ filteredCount }}</span>
            resultados
          </div>
        </div>
      </div>

      <div class="border-t border-[color:var(--ms-border)]">
        <div v-if="loading" class="p-6">
          <div class="flex items-center gap-3 text-[color:var(--ms-muted)]">
            <span
              class="h-5 w-5 animate-spin rounded-full border-2 border-slate-300 border-t-violet-500 dark:border-white/15"
            />
            Carregando cidades...
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
            <thead class="bg-[color:var(--ms-surface-2)] text-xs uppercase tracking-wide text-slate-500 dark:text-slate-300">
              <tr>
                <th class="px-5 py-3 font-semibold">Cidade</th>
                <th class="px-5 py-3 font-semibold">UF</th>
                <th class="px-5 py-3 font-semibold">Estado</th>
                <th class="px-5 py-3 font-semibold">Região</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-[color:var(--ms-border)]">
              <tr
                v-for="row in pageRows"
                :key="row.id"
                class="hover:bg-slate-900/[0.02] dark:hover:bg-white/5"
              >
                <td class="px-5 py-4 font-semibold">
                  {{ row.city }}
                </td>
                <td class="px-5 py-4 text-[color:var(--ms-muted)]">{{ row.uf }}</td>
                <td class="px-5 py-4 text-[color:var(--ms-muted)]">{{ row.state }}</td>
                <td class="px-5 py-4 text-[color:var(--ms-muted)]">{{ row.region }}</td>
              </tr>

              <tr v-if="pageRows.length === 0">
                <td class="px-5 py-6 text-slate-700" colspan="4">
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
                ? 'cursor-not-allowed bg-slate-900/5 text-slate-400 ring-[color:var(--ms-border)]'
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
                ? 'cursor-not-allowed bg-slate-900/5 text-slate-400 ring-[color:var(--ms-border)]'
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
  </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue'
import Field from '../components/ui/Field.vue'

const rows = ref([])
const loading = ref(false)
const error = ref('')

const perPage = 10
const page = ref(1)

const selectedUf = ref('')
const selectedRegion = ref('')

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

watch([selectedUf, selectedRegion], () => {
  page.value = 1
})

const ufs = computed(() => {
  const list = new Set(rows.value.map((r) => r.uf).filter(Boolean))
  return Array.from(list).sort()
})

const regions = computed(() => {
  const list = new Set(rows.value.map((r) => r.region).filter(Boolean))
  return Array.from(list).sort()
})

const filteredRows = computed(() => {
  const query = search.value.toLowerCase()

  return rows.value.filter((row) => {
    if (selectedUf.value && row.uf !== selectedUf.value) return false
    if (selectedRegion.value && row.region !== selectedRegion.value) return false

    if (!query) return true

    const haystack = `${row.city} ${row.uf} ${row.state} ${row.region}`.toLowerCase()
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

async function load() {
  loading.value = true
  error.value = ''

  try {
    const response = await fetch('/api/ibge/municipios', {
      headers: { Accept: 'application/json' },
    })

    if (!response.ok) throw new Error(`HTTP ${response.status}`)

    rows.value = await response.json()
  } catch (e) {
    error.value = e instanceof Error ? e.message : 'Erro desconhecido'
  } finally {
    loading.value = false
  }
}

onMounted(load)
</script>
