import { createApp, h } from 'vue'
import App from './App.vue'
import { router } from './router'

const appElement = document.getElementById('app')

if (appElement) {
    const props = appElement.dataset.props
        ? JSON.parse(appElement.dataset.props)
        : {}

    const app = createApp({
        render: () => h(App, props)
    })

    if (import.meta.env.DEV) {
        app.config.devtools = true
        app.config.performance = true
    }

    app
        .use(router)
        .mount(appElement)
}