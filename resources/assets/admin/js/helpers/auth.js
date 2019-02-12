/* eslint-disable camelcase,no-undef */
import {store} from '../store/store'
import router from '../router'

class Auth {
    /** Restore session after reload page */
    constructor () {
        let token = window.localStorage.getItem('access_token') ? window.localStorage.getItem('access_token') : window.sessionStorage.getItem('access_token')

        let refresh_token = window.localStorage.getItem('refresh_token') ? window.localStorage.getItem('refresh_token') : window.sessionStorage.getItem('refresh_token')

        if (refresh_token) {
            this.setRefreshInterceptor(refresh_token)
        }

        if (token) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
            this.getUser()
        }
    }

    /** Set Refresh token Interceptor for axios */
    setRefreshInterceptor () {
        axios.interceptors.response.use(function (response) {
            return response
        }, function (error) {
            let refresh_token = window.localStorage.getItem('refresh_token')

            console.log('HERE');
            const originalRequest = error.config

            console.log(error);
            if (error.response.status === 401 && refresh_token) {
                window.localStorage.removeItem('refresh_token')

                originalRequest._retry = true

                return axios.post('/refresh', { refresh_token })
                    .then(({data}) => {
                        window.localStorage.setItem('access_token', data.access_token)
                        window.localStorage.setItem('refresh_token', data.refresh_token)
                        axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.access_token
                        originalRequest.headers['Authorization'] = 'Bearer ' + data.access_token
                        return axios(originalRequest)
                    })
            }
            return Promise.reject(error)
        })
    }

    login (data) {
        let storage = 'localStorage';
        return new Promise((resolve, reject) => {
            axios.post('/login', data)
                .then(({data}) => {
                    window[storage].setItem('access_token', data.access_token)
                    window[storage].setItem('refresh_token', data.refresh_token)
                    this.setRefreshInterceptor(data.refresh_token)
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.access_token
                    this.getUser().then(() => {
                        resolve()
                    })
                })
                .catch(err => {
                    reject(err)
                })
        })
    };

    confirm (data) {
        store.commit('auth/setUser', data.user)
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.access_token
    }

    logout () {
        window.localStorage.removeItem('access_token')
        window.localStorage.removeItem('refresh_token')
        window.sessionStorage.removeItem('access_token')
        window.sessionStorage.removeItem('refresh_token')
        store.commit('auth/logout')
        router.push({name: 'login'})
    }

    getUser () {
        return new Promise((resolve, reject) => {
            axios.get('/get-user').then(({data}) => {
                store.commit('auth/setUser', data)
                resolve()
            }).catch(e => {
                this.logout()
            })
        })
    }

    check () {
        return store.getters['auth/loggedIn']
    }

    /**
     * Protects routes when guest is trying to serf on preview page
     * @param ref_token
     * @param ref_type
     */
    protectRoutesForInvitee (ref_token, ref_type) {
        router.beforeEach((to, from, next) => {
            if (to.name === 'register' ||
                to.name === 'need-confirm' ||
                to.name === ref_type + '-preview') {
                return next()
            }
            // invited preview
            if (from.matched.some(record => record.meta.preview)) {
                if ((!store.getters['auth/loggedIn']) && to.name !== from.name) {
                    let registerUrl = {
                        name: 'register',
                        query: {ref: ref_type, token: ref_token}
                    }
                    flash('You should register to visit all pages', {linkUrl: registerUrl, linkTitle: 'Register', timeout: 3000})
                    return
                }
            }
            if (to.name === 'login') {
                return next()
            }
        })
    }
}

export default Auth
