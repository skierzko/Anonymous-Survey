import { defineStore } from 'pinia'
import { api } from "../pages/services/api";
import { logout as logoutService } from '../pages/services/logout';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null as null | { id: number; email: string; roles: string[] },
    loading: false
  }),

  getters: {
    isAuthenticated: (state) => !!state.user
  },

  actions: {
    async fetchUser() {
      this.loading = true
      try {
        const res = await api.get('/user', { withCredentials: true })
        this.user = res.data
      } catch {
        this.user = null
      } finally {
        this.loading = false
      }
    },

    async logout() {
      await logoutService.post('', {}, { withCredentials: true })
      this.user = null
    }
  }
})