import { createWebHistory, createRouter } from 'vue-router'

import MainNavigation from '../components/navigation/MainNavigation'
import SettingsNavigation from '../components/navigation/SettingsNavigation'
import TicketsNavigation from '../components/navigation/TicketNavigation.vue'

import AuthLogin from '../components/pages/Auth/LoginPage.vue'
import UserDashboard from '../components/pages/UserDashboard'

import TicketsPage from '../components/pages/TicketsPage.vue'
import TicketsHome from '../components/pages/Tickets/TicketsHome.vue'

import SettingsPage from '../components/pages/SettingsPage.vue'
import SettingsHome from '../components/pages/Settings/SettingsHome.vue'
import SettingsGroup from '../components/pages/Settings/SettingsGroup.vue'
import SettingsUser from '../components/pages/Settings/SettingsUser.vue'

const routes = [
  {
    path: '/',
    name: 'dashboard',
    components: {
      default: UserDashboard,
      navigation: MainNavigation
    },
    meta: {
      middleware: 'auth',
      title: 'Dashboard'
    }
  },

  {
    path: '/settings',
    components: {
      default: SettingsPage,
      navigation: SettingsNavigation
    },
    children: [
      { name: 'settings.home', path: '', component: SettingsHome },
      { name: 'settings.groups', path: 'groups', component: SettingsGroup },
      { name: 'settings.users', path: 'users', component: SettingsUser }
    ],
    meta: {
      middleware: 'auth',
      title: 'Settings'
    }
  },

  {
    path: '/tickets',
    components: {
      default: TicketsPage,
      navigation: TicketsNavigation
    },
    children: [
      { name: 'tickets.home', path: '', component: TicketsHome },
    ],
    meta: {
      middleware: 'auth',
      title: 'Settings'
    }
  },

  {
    path: '/login',
    name: 'auth.login',
    components: {
      default: AuthLogin
    },
    meta: {
      middleware: 'guest',
      title: 'Login'
    }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  const tokenName = process.env.MIX_APP_AUTH_TOKEN_NAME
  const userToken = localStorage.getItem(tokenName)

  if (to.meta.middleware === 'auth') {
    if (!userToken) {
      next({ name: 'auth.login' })
    }
    next()
  } else if (to.meta.middleware === 'guest') {
    if (userToken) {
      next({ name: 'dashboard' })
    }
    next()
  }

  next()
})

export default router
