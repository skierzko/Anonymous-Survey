import './styles/app.css'
import { createApp, h } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import { router } from './router'

const appElement = document.getElementById('app')


if (appElement) {
    const appProps = window.__APP_PROPS__ ?? {}
    const app = createApp({
        render: () => h(App, appProps)
    })
    const pinia = createPinia()

    if (import.meta.env.DEV) {
        app.config.devtools = true
        app.config.performance = true
    }

    app
        .use(pinia)
        .use(router)
        .mount(appElement)
}