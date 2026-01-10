import { defineStore } from 'pinia'
import axios from 'axios'

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
        const res = await axios.get('/api/me', { withCredentials: true })
        this.user = res.data
      } catch {
        this.user = null
      } finally {
        this.loading = false
      }
    },

    async logout() {
      await axios.post('/logout', {}, { withCredentials: true })
      this.user = null
    }
  }
})