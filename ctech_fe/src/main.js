import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

import './assets/main.css'
import 'bootstrap'
import "bootstrap/dist/css/bootstrap.css";

const app = createApp(App)

app.config.globalProperties.urlApi = 'http://localhost/ctech/public/api/';
app.use(router)

app.mount('#app')
