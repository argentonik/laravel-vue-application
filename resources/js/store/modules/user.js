export default {
    state: {
        status: '',
        token: localStorage.getItem('token') || '',
        currentUserId: '',
        currentUserName: ''
    },
    actions: {
        login({commit}, user){
            commit('auth_request')
            axios.post('/api/login', user)
                .then(resp => {
                    const token = resp.data.access_token
                    localStorage.setItem('token', token)
                    axios.defaults.headers.common['Authorization'] = "Bearer " + token
                    commit('auth_success', token)
                    return axios.get('/api/currentUser')
                })
                .then(res => {
                    commit('update_user_info', res.data)
                })
                .catch(err => {
                    commit('auth_error')
                    localStorage.removeItem('token')
                    console.log(err)
                })
        },
        register({commit}, user) {
            commit('auth_request')
            axios.post('/api/register', user)
                .then(resp => {
                    const token = resp.data.access_token
                    localStorage.setItem('token', token)
                    axios.defaults.headers.common['Authorization'] = "Bearer " + token
                    commit('auth_success', token)
                    return axios.get('/api/currentUser')
                })
                .then(res => {
                    commit('update_user_info', res.data)
                })
                .catch(err => {
                    console.log(err)
                    commit('auth_error', err)
                    localStorage.removeItem('token')
                })
        },
        logout({commit}){
            axios.post('/api/logout')
                    .then(() => {
                        commit('logout')
                        localStorage.removeItem('token')
                        delete axios.defaults.headers.common['Authorization']
                    })
                    .catch(err => {
                        console.log(err)
            })   
        }
    },
    mutations: {
        update_user_info(state, user) {
            state.currentUserId = user.id
            state.currentUserName = user.name
        },
        auth_request(state){
            state.status = 'loading'
        },
        auth_success(state, token){   
            state.status = 'success'
            state.token = token

        },
        auth_error(state){
            state.status = 'error'
        },
        logout(state){
            state.status = ''
            state.token = ''
            state.currentUserId = ''
            state.currentUserName = ''
        },
    },
    getters : {
        currentUserId: state => state.currentUserId,
        currentUserName: state => state.currentUserName,
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status,
    }
}