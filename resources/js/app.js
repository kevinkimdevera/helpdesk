import { createApp } from 'vue'

import App from './components/layouts/App.vue'
import vuetify from './plugins/vuetify'
import router from './router'
import store from './store'

require('./bootstrap')

const app = createApp(App)

app.use(vuetify)
  .use(router)
  .use(store)
  .mount('#app')
