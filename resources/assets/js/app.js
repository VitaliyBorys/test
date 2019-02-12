window._ = require('lodash')

import router from './router'
import veevalidate from 'vee-validate'
import {store} from './store/store'
import validator from './helpers/validator'
import Auth from './helpers/auth'
import Preloader from './helpers/preloader'
import Error from './helpers/errorHandler'
import Moment from 'moment'
import vSelect from 'vue-select'
import Vue from 'vue'
import version from '../../../version'
import vueSmoothScroll from 'vue2-smooth-scroll'
import common from './helpers/common'
import vueScrollTo from 'vue-scrollto'

import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue);


window.version = version

window.axios = require('axios')
window.validator = validator
window.auth = new Auth()
window.Vue = require('vue')
window.preloader = Preloader
window.common = common
window.error = Error
Vue.prototype.$moment = Moment

// Event Bus
window.events = new Vue()

Vue.prototype._ = require('lodash')

// confirmation popups

Vue.use(veevalidate)
Vue.use(vueSmoothScroll)

Vue.use(vueScrollTo);


import Snotify from 'vue-snotify';

Vue.config.productionTip = false;

Vue.use(veevalidate, {
    errorBagName: 'vErrors'
});

Vue.use(Snotify)

/** Select2 */
Vue.component('v-select', vSelect)

Vue.component('app', require('./App.vue'))


const app = new Vue({
    store,
    router,
    el: '#app'
})

