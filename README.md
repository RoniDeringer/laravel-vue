<div align="center">
  <h1>🚀 Laravel + Vue + Tailwind</h1>
  <p>Starter full‑stack para acelerar seu setup com <b>Laravel</b>, <b>Vue</b> e <b>Tailwind CSS</b>.</p>

  <p>
    <img
      alt="Ícones do stack"
      src="https://skillicons.dev/icons?i=laravel,vue,tailwind,vite,nodejs,npm,php,composer"
    />
  </p>

  <p>
    <img alt="Laravel" src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
    <img alt="Vue" src="https://img.shields.io/badge/Vue-3-42b883?style=for-the-badge&logo=vue.js&logoColor=white" />
    <img alt="Tailwind CSS" src="https://img.shields.io/badge/Tailwind_CSS-4-06b6d4?style=for-the-badge&logo=tailwindcss&logoColor=white" />
    <img alt="Vite" src="https://img.shields.io/badge/Vite-6-646CFF?style=for-the-badge&logo=vite&logoColor=white" />
  </p>
</div>

---

## ✨ Visão geral

- 🧩 Backend com Laravel
- 🎨 Frontend com Vue + Tailwind CSS
- 🧱 Sem biblioteca de UI pronta: foco em aprender Tailwind “na mão” (utilitários + componentes próprios)
- ⚡ Build/Dev server com Vite
- 🧵 Dev script com `composer run dev` (server + queue + logs + vite)

## 🧰 Stack e versões

| Ferramenta | Versão (detectada) | Como foi detectado |
|---|---:|---|
| 🟥 Laravel | `12.55.1` | `php artisan --version` |
| 🟩 Vue | `3.5.30` | `node_modules/vue/package.json` |
| 🌬️ Tailwind CSS | `4.2.2` | `node_modules/tailwindcss/package.json` |
| 🟪 Node.js | `v22.13.1` | `node -v` |
| 📦 npm | *(não detectável automaticamente aqui)* | rode `npm -v` no seu terminal |

> Observação: o `package-lock.json` está no `lockfileVersion: 3` (compatível com npm 7+).

## ✅ Requisitos

- 🐘 PHP `8.2+` (projeto usa `^8.2`)
- 🎼 Composer `2.x`
- 🟪 Node.js (recomendado usar a mesma versão do time/CI)
- 📦 npm (ou gerenciador compatível com `package-lock.json`)
- 🗄️ Banco de dados (SQLite já funciona muito bem para dev)

## ⚙️ Instalação

1) Dependências do PHP:

```bash
composer install
```

2) Variáveis de ambiente + key:

```bash
copy .env.example .env
php artisan key:generate
```

3) (Opcional) SQLite para dev:

```bash
New-Item -ItemType File -Force database/database.sqlite
php artisan migrate
```

4) Dependências do frontend:

```bash
npm install
```

## ▶️ Rodando o projeto

- ⭐ Recomendado (tudo junto):

```bash
composer run dev
```

- Alternativa (2 terminais):

```bash
php artisan serve
```

```bash
npm run dev
```

## 🤖 GitHub Actions (CI)

Este projeto tem um workflow automatizado no GitHub Actions em `.github/workflows/tests.yml` que roda **todo dia** e também pode ser executado manualmente (`workflow_dispatch`).

### 🔍 O que esse workflow faz (pipeline mental)

`checkout → setup PHP → composer install → .env + key → SQLite → setup Node → npm install + build → php artisan test`

- ✅ checkout → baixa seu código
- 🐘 setup PHP → prepara ambiente Laravel
- 📦 composer install → instala backend
- 🔑 .env + key → deixa app funcional
- 🗄️ SQLite → evita precisar de MySQL (mais simples pra CI)
- 🟢 setup Node → prepara Vue/Vite
- 📦 npm install + build → garante que frontend compila
- 🧪 php artisan test → valida tudo

> Agenda: `0 3 * * *` (03:00 UTC — 00:00 em `America/Sao_Paulo`).

## 🧪 Testes

```bash
php artisan test
```

## 📦 Build (produção)

```bash
npm run build
```

## 📄 Licença

Este projeto segue a licença MIT (mesma do skeleton do Laravel).
