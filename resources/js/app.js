import './bootstrap'
import Vue from 'vue'
import vuetify from '@/js/plugins/vuetify'
import VeeValidate from 'vee-validate'
import Axios from 'axios'

import Route from '@/js/routes.js'
import store from '@/js/store'
import App from '@/js/views/App'

Vue.use(VeeValidate, { inject: false })

Vue.prototype.$http = Axios;

const token = localStorage.getItem('token')
if (token) {
  Vue.prototype.$http.defaults.headers.common['Authorization'] = "Bearer " + token
}

const app = new Vue({
    el: "#app",
    store,
    vuetify,
    router: Route,
    render: h => h(App)
})