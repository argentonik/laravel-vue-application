import Vue from 'vue'
import Vuex from 'vuex'

import bulletin from './modules/bulletin'
import user from './modules/user'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        user,
        bulletin
    }
})