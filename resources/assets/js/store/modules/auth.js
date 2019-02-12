import router from './../../router'
export default {
  namespaced: true,
  state: {
    user: window.localStorage.getItem('user') ? JSON.parse(window.localStorage.getItem('user')) : false
  },
  mutations: {

    logout: (state) => {
      window.localStorage.removeItem('user')
      state.user = false
      router.push('/login')
    },
    setUser: (state, user) => {
      state.user = user
      window.localStorage.setItem('user', JSON.stringify(user))
    }
  },
  getters: {
    loggedIn (state) {
      return state.user
    },
    filled (state) {
      return !!state.user.name
    },
    getRefToken (state) {
      return state.user.refToken
    },
    avatar (state) {
      return state.user.smallAvatar ? state.user.smallAvatar : '/img/content/no-image.png'
    }
  }
}