import version from "../../../../version";
window._ = require('lodash')
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import App from './App.vue';
import router from './router';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Auth from './helpers/auth'
import {store} from './store/store'
import Moment from 'moment'


import vSelect from 'vue-select'


import Snotify from 'vue-snotify';

Vue.config.productionTip = false;

Vue.use(Snotify)

Vue.component('v-select', vSelect)



Vue.prototype.$moment = Moment

window.auth = new Auth()

Vue.component('App', require('./App.vue'));
Vue.use(BootstrapVue);

Vue.prototype._ = require('lodash')


/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    store,
    template: '<App/>',
    components: {
        App
    }
})
