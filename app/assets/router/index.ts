import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'

import MainPage from '../pages/MainPage.vue'
import Login from '../pages/Login.vue'
import Register from '../pages/Register.vue'

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    name: 'MainPage',
    component: MainPage,
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
  },
]

export const router = createRouter({
  history: createWebHistory(),
  routes,
})