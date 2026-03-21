<template>
  <div class="mx-auto max-w-3xl">
    <header>
      <h1 class="text-2xl font-semibold text-slate-900">Envio de email</h1>
      <p class="mt-2 text-slate-600">
        Tela preparada para estudar formulários, validação, estados de loading e integração com API.
      </p>
    </header>

    <section class="mt-6 rounded-3xl border border-slate-200/70 bg-white/70 p-6 shadow-sm">
      <div class="grid gap-4">
        <Field label="Para">
          <input
            class="w-full rounded-xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-slate-900 outline-none ring-indigo-600/20 transition focus:ring-4"
            placeholder="email@exemplo.com"
            type="email"
            autocomplete="email"
          />
        </Field>
        <Field label="Assunto">
          <input
            class="w-full rounded-xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-slate-900 outline-none ring-indigo-600/20 transition focus:ring-4"
            placeholder="Assunto do email"
            type="text"
          />
        </Field>
        <Field label="Mensagem">
          <textarea
            class="min-h-32 w-full resize-y rounded-xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-slate-900 outline-none ring-indigo-600/20 transition focus:ring-4"
            placeholder="Escreva sua mensagem..."
          />
        </Field>

        <div class="flex items-center justify-end">
          <button
            type="button"
            class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-600/20"
          >
            Enviar (placeholder)
          </button>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import Field from '../components/ui/Field.vue'
</script>
