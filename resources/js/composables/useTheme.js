import { ref } from 'vue'

const theme = ref('light')
const ready = ref(false)

function apply(nextTheme) {
  const isDark = nextTheme === 'dark'
  document.documentElement.classList.toggle('dark', isDark)
  document.body?.classList.toggle('dark', isDark)

  try {
    document.documentElement.style.colorScheme = isDark ? 'dark' : 'light'
  } catch {
    // ignore
  }
}

function persistTheme(nextTheme) {
  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')

  return fetch('/api/preferences/theme', {
    method: 'POST',
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json',
      ...(csrf ? { 'X-CSRF-TOKEN': csrf } : {}),
    },
    body: JSON.stringify({ theme: nextTheme }),
  })
}

function setTheme(nextTheme, { persist = true } = {}) {
  if (nextTheme !== 'light' && nextTheme !== 'dark') return

  theme.value = nextTheme
  apply(nextTheme)

  try {
    localStorage.setItem('theme', nextTheme)
  } catch {
    // ignore
  }

  if (!persist) return Promise.resolve(true)

  return persistTheme(nextTheme)
    .then(() => true)
    .catch(() => false)
}

async function initTheme() {
  try {
    const localTheme = localStorage.getItem('theme')
    if (localTheme === 'light' || localTheme === 'dark') {
      setTheme(localTheme, { persist: false })
      // Keep going: DB is still the source of truth across browsers.
    }
  } catch {
    // ignore
  }

  try {
    const response = await fetch('/api/preferences/theme', {
      headers: { Accept: 'application/json' },
    })
    if (!response.ok) return

    const data = await response.json()
    if (data?.theme === 'light' || data?.theme === 'dark') {
      setTheme(data.theme, { persist: false })
    }
  } catch {
    // If there's no backend available yet, fallback to system preference
    if (theme.value !== 'light' && theme.value !== 'dark') theme.value = 'light'
    if (!localStorage.getItem('theme')) {
      const prefersDark = window.matchMedia?.('(prefers-color-scheme: dark)')?.matches
      setTheme(prefersDark ? 'dark' : 'light', { persist: false })
    }
  } finally {
    ready.value = true
  }
}

function toggleTheme() {
  return setTheme(theme.value === 'dark' ? 'light' : 'dark')
}

export function useTheme() {
  return {
    theme,
    ready,
    initTheme,
    setTheme,
    toggleTheme,
  }
}
