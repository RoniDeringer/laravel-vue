import './bootstrap';
import { createApp } from 'vue'
import '../css/app.css'

import App from './App.vue'
import router from './router'
import { useTheme } from './composables/useTheme'

useTheme().initTheme()

createApp(App).use(router).mount('#app')
