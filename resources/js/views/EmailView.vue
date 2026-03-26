<template>
  <div class="mx-auto max-w-3xl">
    <header>
      <h1 class="text-2xl font-semibold">Envio de email</h1>
      <p class="mt-2 text-[color:var(--ms-muted)]">
        Rotina de estudos com envio assÃ­ncrono via fila (RabbitMQ) e suporte a cache com Redis.
      </p>
    </header>

    <section class="mt-6 rounded-3xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface)] p-6 shadow-sm backdrop-blur">
      <div class="grid gap-4">
        <Field label="Para">
          <input
            v-model.trim="form.to"
            class="w-full rounded-xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2)] px-4 py-3 text-[color:var(--ms-text)] outline-none ring-violet-500/20 transition focus:ring-4 placeholder:text-slate-600 dark:placeholder:text-slate-400/80"
            placeholder="email@exemplo.com"
            type="email"
            autocomplete="email"
            :disabled="loading"
          />
        </Field>
        <Field label="Assunto">
          <input
            v-model.trim="form.subject"
            class="w-full rounded-xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2)] px-4 py-3 text-[color:var(--ms-text)] outline-none ring-violet-500/20 transition focus:ring-4 placeholder:text-slate-600 dark:placeholder:text-slate-400/80"
            placeholder="Assunto do email"
            type="text"
            :disabled="loading"
          />
        </Field>
        <Field label="Mensagem">
          <textarea
            v-model="form.message"
            class="min-h-32 w-full resize-y rounded-xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2)] px-4 py-3 text-[color:var(--ms-text)] outline-none ring-violet-500/20 transition focus:ring-4 placeholder:text-slate-600 dark:placeholder:text-slate-400/80"
            placeholder="Escreva sua mensagem..."
            :disabled="loading"
          />
        </Field>

        <div class="flex items-center justify-end">
          <button
            type="button"
            class="group inline-flex cursor-pointer items-center justify-center rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-violet-600/10 transition hover:from-violet-500 hover:to-fuchsia-500 focus:outline-none focus:ring-4 focus:ring-violet-500/25"
            :class="{ 'pointer-events-none opacity-70': loading }"
            @click="submit"
          >
            <span>{{ loading ? 'Enviando...' : 'Enviar' }}</span>
            <IconMail class="ml-2 h-5 w-5 text-white/90 group-hover:text-white" />
          </button>
        </div>
      </div>
    </section>

    <div class="mt-4 flex flex-col items-stretch justify-end gap-3 sm:flex-row sm:items-center">
      <a
        href="http://127.0.0.1:15672/#/"
        target="_blank"
        rel="noopener noreferrer"
        class="group inline-flex cursor-pointer items-center justify-center rounded-xl border border-amber-500/30 bg-gradient-to-r from-amber-500 to-orange-600 px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-orange-600/10 transition hover:from-amber-400 hover:to-orange-500 focus:outline-none focus:ring-4 focus:ring-orange-500/25"
      >
        Abrir RabbitMQ: Overview
        <IconRabbitMQ class="ml-2 h-5 w-5 text-white/90 group-hover:text-white" />
      </a>

      <RouterLink
        to="/jobs"
        class="group inline-flex cursor-pointer items-center justify-center rounded-xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2)] px-5 py-3 text-sm font-semibold text-[color:var(--ms-text)] transition hover:bg-white/70 focus:outline-none focus:ring-4 focus:ring-violet-500/20 dark:hover:bg-white/10"
      >
        Ver logs dos jobs
        <IconClipboard
          class="ml-2 h-5 w-5 text-[color:var(--ms-muted)] transition group-hover:text-[color:var(--ms-accent)]"
        />
      </RouterLink>
    </div>

    <SweetAlert
      :open="alert.open"
      :type="alert.type"
      :title="alert.title"
      :text="alert.text"
      :details="alert.details"
      @close="alert.open = false"
    />

    <VscodeCodePreview
      filename="app/Http/Controllers/EmailController.php"
      href="https://github.com/RoniDeringer/laravel-vue/blob/main/app/Http/Controllers/EmailController.php"
      :code="emailControllerCode"
    />
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import Field from '../components/ui/Field.vue'
import SweetAlert from '../components/ui/SweetAlert.vue'
import VscodeCodePreview from '../components/ui/VscodeCodePreview.vue'
import IconClipboard from '../icons/IconClipboard.vue'
import IconMail from '../icons/IconMail.vue'
import IconRabbitMQ from '../icons/IconRabbitMQ.vue'
import emailControllerCode from '../../../app/Http/Controllers/EmailController.php?raw'

const loading = ref(false)
const csrfToken = document.head.querySelector('meta[name="csrf-token"]')?.content

const form = reactive({
  to: '',
  subject: '',
  message: '',
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

function formatLaravelErrors(errors) {
  if (!errors || typeof errors !== 'object') return ''
  const lines = []
  for (const [field, messages] of Object.entries(errors)) {
    if (Array.isArray(messages)) {
      for (const message of messages) lines.push(`${field}: ${message}`)
    } else if (typeof messages === 'string') {
      lines.push(`${field}: ${messages}`)
    }
  }
  return lines.join('\n')
}

async function submit() {
  if (loading.value) return
  loading.value = true

  try {
    const payload = {
      to: form.to,
      subject: form.subject,
      message: form.message,
    }

    const response = await fetch('/api/email', {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
      },
      body: JSON.stringify(payload),
    })

    const contentType = response.headers.get('content-type') ?? ''
    const isJson = contentType.includes('application/json')
    const data = isJson ? await response.json().catch(() => null) : null
    const bodyText = !isJson ? await response.text().catch(() => '') : ''

    if (response.ok) {
      showAlert({
        type: 'success',
        title: 'Email enfileirado',
        text: `Status: ${response.status} • Fila: ${data?.queue ?? 'emails'}`,
        details: data ? JSON.stringify(data, null, 2) : '',
      })
      return
    }

    const details =
      (data?.errors && formatLaravelErrors(data.errors)) ||
      data?.error ||
      data?.message ||
      bodyText?.slice(0, 800) ||
      `HTTP ${response.status}`

    showAlert({
      type: 'error',
      title: 'Falha ao enviar/enfileirar',
      text: `Status: ${response.status}`,
      details,
    })
  } catch (error) {
    showAlert({
      type: 'error',
      title: 'Erro inesperado',
      text: 'Ocorreu um erro no front ao chamar a API.',
      details: String(error),
    })
  } finally {
    loading.value = false
  }
}
</script>

