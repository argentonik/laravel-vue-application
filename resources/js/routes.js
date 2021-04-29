import Vue from 'vue'
import VueRouter from 'vue-router'

import PageNotFound from '@/js/views/PageNotFound'
import Login from '@/js/views/auth/Login'
import Register from '@/js/views/auth/Register'
import BulletinsList from '@/js/views/BulletinsList'
import BulletinView from '@/js/views/BulletinView'
import StoreBulletinView from '@/js/views/StoreBulletinView'
import store from '@/js/store'

Vue.use(VueRouter);

const router = new VueRouter({
    scrollBehavior() {
        return { x: 0, y: 0 };
    },
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: BulletinsList
        },
        {
            path: '/login',
            name: 'login',
            component: Login

        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/bulletins/:id',
            name: 'bulletin-view',
            props: true,
            component: BulletinView
        },
        {
            path: '/bulletins/create',
            name: 'bulletin-create',
            component: StoreBulletinView,
            meta: { 
                requiresAuth: true
            }
        },
        {
            path: '/bulletins/:id/edit',
            name: 'bulletin-edit',
            component: StoreBulletinView,
            props: true,
            meta: { 
                requiresAuth: true
            }
        },
        { 
            path: "*", 
            component: PageNotFound 
        }
    ]
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.isLoggedIn) {
            next()
            return
        }
        next('/login') 
    } else {
        next() 
    }
})

export default router;