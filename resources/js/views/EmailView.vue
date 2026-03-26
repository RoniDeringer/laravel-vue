<template>
  <div class="mx-auto max-w-3xl">
    <header>
      <h1 class="text-2xl font-semibold">Envio de email</h1>
      <p class="mt-2 text-[color:var(--ms-muted)]">
        Rotina de estudos com envio assíncrono via fila (RabbitMQ) e suporte a cache com Redis.
      </p>
    </header>

    <section class="mt-6 rounded-3xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface)] p-6 shadow-sm backdrop-blur">
      <div class="grid gap-4">
        <Field label="Para">
          <input
            class="w-full rounded-xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2)] px-4 py-3 text-[color:var(--ms-text)] outline-none ring-violet-500/20 transition focus:ring-4 placeholder:text-slate-500/80 dark:placeholder:text-slate-400/70"
            placeholder="email@exemplo.com"
            type="email"
            autocomplete="email"
          />
        </Field>
        <Field label="Assunto">
          <input
            class="w-full rounded-xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2)] px-4 py-3 text-[color:var(--ms-text)] outline-none ring-violet-500/20 transition focus:ring-4 placeholder:text-slate-500/80 dark:placeholder:text-slate-400/70"
            placeholder="Assunto do email"
            type="text"
          />
        </Field>
        <Field label="Mensagem">
          <textarea
            class="min-h-32 w-full resize-y rounded-xl border border-[color:var(--ms-border)] bg-[color:var(--ms-surface-2)] px-4 py-3 text-[color:var(--ms-text)] outline-none ring-violet-500/20 transition focus:ring-4 placeholder:text-slate-500/80 dark:placeholder:text-slate-400/70"
            placeholder="Escreva sua mensagem..."
          />
        </Field>

        <div class="flex items-center justify-end">
          <button
            type="button"
            class="inline-flex cursor-pointer items-center justify-center rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-violet-600/10 transition hover:from-violet-500 hover:to-fuchsia-500 focus:outline-none focus:ring-4 focus:ring-violet-500/25"
          >
            Enviar <EmojiIcon name="incoming_envelope" class="ml-2 h-5 w-5" />
          </button>
        </div>
      </div>
    </section>

    <VscodeCodePreview
      filename="app/Http/Controllers/EmailController.php"
      href="https://github.com/RoniDeringer/laravel-vue/blob/main/app/Http/Controllers/EmailController.php"
      :code="emailControllerCode"
    />
  </div>
</template>

<script setup>
import Field from '../components/ui/Field.vue'
import EmojiIcon from '../components/ui/EmojiIcon.vue'
import VscodeCodePreview from '../components/ui/VscodeCodePreview.vue'
import emailControllerCode from '../../../app/Http/Controllers/EmailController.php?raw'
</script>
