
window._ = require('lodash');
window.Popper = require('popper.js').default;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

axios.interceptors.response.use(function (response) {
    return response
}, function (error) {
    console.log(error);
    let refresh_token = window.localStorage.getItem('refresh_token')

    const originalRequest = error.config

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
    }else if(error.response.status === 401 && window.location.pathname !== '/login'){
        auth.logout();
    }else if( window.location.pathname !== '/login'){
      //  auth.logout();
    }
    return Promise.reject(error)
})

window.axios.defaults.baseURL = '/api/';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
