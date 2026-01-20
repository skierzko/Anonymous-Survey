import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import { authGuard } from './guards/authGuard'

import MainPage from '../pages/MainPage.vue'
import Login from '../pages/Login.vue'
import Register from '../pages/Register.vue'
import UserBoard from '../pages/UserBoard.vue'
import SurveyCreator from '../pages/SurveyCreator.vue'

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
        },
    },
    {
        path: '/survey-creator',
        name: 'SurveyCreator',
        component: SurveyCreator,
        props: false,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: '/survey/:id(\\d+)',
        name: 'SurveyEditor',
        component: SurveyCreator,
        props: route => ({
            id: Number(route.params.id)
        }),
        meta: {
            requiresAuth: true,
        },
    }
]

export const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach(authGuard)
