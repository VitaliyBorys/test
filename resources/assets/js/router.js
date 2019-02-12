/* eslint-disable no-undef */
import Vue from 'vue'
import Router from 'vue-router'


import Auth from './layouts/Auth';

import {store} from './store/store'

Vue.use(Router)

const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/auth-group',
            name: 'auth',
            component: require('./layouts/Auth.vue'),
            children: [
                {
                    path: '/register',
                    name: 'register',
                    component: require('./page/auth/Register'),
                    meta: {loggedOut: true}
                },
                {
                    path: '/login',
                    name: 'login',
                    component: require('./page/auth/Login'),
                    meta: {loggedOut: true}
                },
                {
                    path: '/need-confirm',
                    name: 'need-confirm',
                    component:Auth
                },
                {
                    path: '/confirm/:token',
                    name: 'confirm',
                    component: Auth

                },
                {
                    path: '/reset-link',
                    name: 'reset-link',
                    component: Auth
                },
                {
                    path: '/reset-password/:token',
                    name: 'reset-password',
                    component:Auth

                },
                {
                    path: '/logout',
                    name: 'logout',
                    component: require('./page/auth/Logout'),
                    meta: {registered: true}
                }
            ]
        },
        {
            path: '/',
            component: require('./layouts/Main'),
            meta: {
                auth: true
            },
            children: [
                {
                    path: '/',
                    name: 'profile',
                    component: require('./page/profile/Profile')
                },
                {
                    path: '/lottery',
                    name: 'lottery',
                    component: require('./page/profile/Lottery')
                },

            ]
        }

    ],
    scrollBehavior(to, from, savedPosition) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                resolve({x: 0, y: 0})
            }, 600)
        })
    }
})

router.beforeEach((to, from, next) => {


    if (to.path === from.path && (to.hash !== from.hash)) {
        return;
    }

    // loggedOut
    if (to.matched.some(record => record.meta.loggedOut)) {
        if (store.getters['auth/loggedIn'] && to.name !== 'logout') {
            next({name: 'profile'})
            return
        }
    }
    // auth
    if (to.matched.some(record => record.meta.auth)) {
        if ((!store.getters['auth/loggedIn'])) {
            next({name: 'login'})
            return
        }
    }

    next()
})

export default router
