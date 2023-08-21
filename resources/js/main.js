/* eslint-disable import/order */
import '@/@iconify/icons-bundle'
import App from '@/App.vue'
import vuetify from '@/plugins/vuetify'
import { loadFonts } from '@/plugins/webfontloader'
import router from '@/router'
import '@core-scss/template/index.scss'
import '@layouts/styles/index.scss'
import '@styles/styles.scss'
import VueCookies from 'vue-cookies'

import ToastPlugin from 'vue-toast-notification'
import 'vue-toast-notification/dist/theme-bootstrap.css'

import { createPinia } from 'pinia'
import { createApp } from 'vue'

loadFonts()


// Create vue app
const app = createApp(App)


// Use plugins

app.use(VueCookies)
app.use(vuetify)
app.use(ToastPlugin);
app.use(createPinia())
app.use(router)

// Mount vue app
app.mount('#app')
