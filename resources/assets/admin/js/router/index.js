import Vue from 'vue'
import Router from 'vue-router'

// Containers
import Full from '@/containers/Full'



// Views - Pages
import Page404 from '@/views/pages/Page404'
import Login from '@/views/pages/Login'
import {store} from "./../store/store";



//User
import UserShow from './../views/users/Show'
import UserForm from './../views/users/Form'

//Prizes
import PrizeShow from './../views/Prizes/Show'
import PrizeForm from './../views/Prizes/Form'

Vue.use(Router)

const router = new Router({
    mode: 'history', // Demo is living in GitHub.io, so required!
    linkActiveClass: 'open active',
    scrollBehavior: () => ({y: 0}),
    routes: [
        {
            path: '/login',
            name: 'Login',
            component: Login,
        },
        {
            path: '/',
            redirect: '/users',
            name: 'Home',
            component: Full,
            children: [
                {
                    path: '/users',
                    name: 'Users',
                    component: UserShow,
                },
                {
                    path: '/users/create',
                    name: 'UsersCreate',
                    component: UserForm,
                },
                {
                    path: '/users/:id/edit',
                    name: 'UsersEdit',
                    component: UserForm,
                    props : true
                },


                {
                    path: '/prizes',
                    name: 'Prizes',
                    component: PrizeShow,
                },
                {
                    path: '/prizes/create',
                    name: 'PrizeCreate',
                    component: PrizeForm,
                },
                {
                    path: '/prizes/:id/edit',
                    name: 'PrizeEdit',
                    component: PrizeForm,
                    props : true
                },

                {
                    path: '/settings',
                    name: 'Settings',
                    component: require('./../views/Setting/Form'),
                },
            ]
        },
        {
            path: '*',
            component: Page404
        }
    ]
})

router.beforeEach((to, from, next) => {


    if ((!store.getters['auth/loggedIn']) && to.name == 'Login') {
        next()
    }

    else if ((!store.getters['auth/loggedIn'])) {
        next({name: 'Login'})
        return
    }
    else if ((!store.getters['auth/loggedIn'])) {
      //  window.location.href = document.location.origin + '/login';
        return;
    } else if (store.getters['auth/loggedIn']) {
        store.dispatch('auth/roles').then(data => {
            if (data.indexOf('Admin') !== -1) {
                next();
            } else {
                auth.logout();
            //    window.location.href = document.location.origin + '/login';
            }
        }).catch(() => {

        })
    }
})


export default router
