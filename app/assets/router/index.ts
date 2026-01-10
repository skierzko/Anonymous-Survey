import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'

import MainPage from '../pages/MainPage.vue'
import Login from '../pages/Login.vue'
import Register from '../pages/Register.vue'
import UserBoard from '../pages/UserBoard.vue'
import { authGuard } from './guards/authGuard'

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    name: 'MainPage',
    component: MainPage,
    meta: {
      guestAccessible: true,
    }
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: {
      guestOnly: true,
    }
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    meta: {
      guestOnly: true,
    }
  },
  {
    path: '/user-board',
    name: 'UserBoard',
    component: UserBoard,
    meta: {
      requiresAuth: true,
    }
  },
]

export const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach(authGuard)
