import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'

import MainPage from '../pages/MainPage.vue'

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    name: 'MainPage',
    component: MainPage,
  },
]

export const router = createRouter({
  history: createWebHistory(),
  routes,
})