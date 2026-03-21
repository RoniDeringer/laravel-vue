import { createRouter, createWebHistory } from 'vue-router'

import WelcomeView from '../views/WelcomeView.vue'
import DashboardView from '../views/DashboardView.vue'
import EmailView from '../views/EmailView.vue'
import ClientsView from '../views/ClientsView.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', name: 'home', component: WelcomeView },
    { path: '/dashboard', name: 'dashboard', component: DashboardView },
    { path: '/email', name: 'email', component: EmailView },
    { path: '/clientes', name: 'clientes', component: ClientsView },
    { path: '/:pathMatch(.*)*', redirect: '/' },
  ],
})

router.afterEach((to) => {
  const titles = {
    home: 'Boas-vindas',
    dashboard: 'Dashboard',
    email: 'Envio de Email',
    clientes: 'Tabela de Clientes',
  }

  document.title = titles[to.name] ? `${titles[to.name]} • mixed salad` : 'mixed salad'
})

export default router
