import router from './../../router'
export default {
    namespaced: true,
    state: {
        user: window.localStorage.getItem('user') ? JSON.parse(window.localStorage.getItem('user')) : false,
        roles : false
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
        },
        setRoles:(state,payload) => {
            state.roles = payload;
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
        },
        getRoles(state){
            return state.roles;
        }
    },
    actions:{
        roles(store,payload){
            return new Promise(resolve => {
               if(store.state.roles !== false){
                   resolve(store.state.roles);
               }else{
                   axios.get('/profile/roles').then(({data}) => {
                       store.commit('setRoles',data);
                       resolve(store.state.roles);
                   });
               }
            });
        }
    }
}