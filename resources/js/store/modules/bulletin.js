export default {
    actions: {
        getById({commit}, id) {
            commit('updateLoaded', false)
            axios.get('/api/bulletins/' + id)
                .then(res => {
                    commit('updateCurrent', res.data.bulletin)
                }).catch(err => {
                    console.log(err)
                })
        },
        createBulletin({commit, dispatch}, bulletin) {
            axios.post('/api/bulletins/store', bulletin)
                .then(res => {
                    return dispatch('getById', res.data.id)
                }).catch(err => {
                    console.log(err)
                })
        },

        updateBulletin({commit, dispatch}, bulletin) {
            axios.post('/api/bulletins/' + bulletin.id + '/update', bulletin, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(() => {
                return dispatch('getById', bulletin.get('id'))
            }).catch(err => {
                console.log(err)
            })
        },
        fetchBulletins({commit}, currentPage = 1) {
            commit('updateLoaded', false)
            axios.get('/api/bulletins?page=' + currentPage)
                .then(res => {
                    commit('updateBulletins', res.data.data)
                    commit('updatePagination', {
                        current: res.data.current_page,
                        total: res.data.last_page
                    })
                }).catch(err => {
            })
        }
    },
    mutations: {
        updateCurrent(state, bulletin) {
            state.currentBulletin = bulletin
            state.loaded = true
        },

        updateBulletins(state, bulletins) {
            state.bulletins = bulletins
            state.loaded = true
        },

        updatePagination(state, pagination) {
            state.pagination = pagination
        }, 

        updateLoaded(state, loaded) {
            state.loaded = loaded
        }
    },
    state: {
        currentBulletin: null,
        bulletins: [],
        pagination: {
            current: null,
            total: null
        }, 
        loaded: false
    },
    getters: {
        currentBulletin(state) {
            return state.currentBulletin;
        },

        allBulletins(state) {
            return state.bulletins;
        },

        pagination(state) {
            return state.pagination;
        },

        isLoaded(state) {
            return state.loaded
        }
    }
}