import { useAuthStore } from "../../stores/auth"

export async function authGuard(to) {
  const auth = useAuthStore()

  if (!auth.user && !auth.loading) {
    await auth.fetchUser()
  }

  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    return '/login'
  }

  if (to.meta.guestOnly && auth.isAuthenticated) {
    return '/user-board'
  }

  if (to.meta.roles) {
    const hasRole = to.meta.roles.some(role => auth.user?.roles.includes(role))
    if (!hasRole) {
      return '/403'
    }
  }
  
  return true
}