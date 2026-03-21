<template>
  <div class="mx-auto max-w-6xl">
    <header class="flex flex-col gap-2">
      <h1 class="text-2xl font-semibold text-slate-900">Tabela Clientes</h1>
      <p class="text-slate-600">
        Tela preparada para praticar tabela, paginação, filtros, estados vazios e loading.
      </p>
    </header>

    <section class="mt-6 overflow-hidden rounded-3xl border border-slate-200/70 bg-white/70 shadow-sm">
      <div class="flex flex-col gap-3 p-5 sm:flex-row sm:items-center sm:justify-between">
        <div class="text-sm font-semibold text-slate-900">Clientes</div>
        <input
          class="w-full max-w-sm rounded-xl border border-slate-200 bg-slate-50/60 px-4 py-2.5 text-sm text-slate-900 outline-none ring-indigo-600/20 transition focus:ring-4"
          placeholder="Buscar (placeholder)"
          type="search"
        />
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full border-t border-slate-200/70 text-left text-sm">
          <thead class="bg-slate-50/70 text-xs uppercase tracking-wide text-slate-500">
            <tr>
              <th class="px-5 py-3 font-semibold">Nome</th>
              <th class="px-5 py-3 font-semibold">Email</th>
              <th class="px-5 py-3 font-semibold">Status</th>
              <th class="px-5 py-3 font-semibold">Ações</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200/70">
            <tr>
              <td class="px-5 py-4 text-slate-700" colspan="4">
                <div class="flex flex-col gap-1">
                  <div class="font-semibold text-slate-900">Sem dados ainda</div>
                  <div class="text-slate-600">
                    Quando você implementar a API/seed, os clientes vão aparecer aqui.
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </div>
</template>
