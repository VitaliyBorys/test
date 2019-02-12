<template>
    <div class="col-md-6 offset-md-3">
        <form class="form-signin">
            <div class="text-center mb-4">
                <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
            </div>
            <div class="form-label-group">
                <label>Email</label>
                <input type="email" class="form-control" v-model="email" placeholder="Введите Email" required autofocus>
            </div>

            <div class="form-label-group">
                <label>Введите пароль</label>
                <input type="password"  class="form-control" v-model="password" placeholder="Пароль" required>
            </div>

            <button :disabled="loading" class="btn btn-lg btn-primary btn-block" @click.prevent="login" type="submit">Sign in</button>
            <router-link :to="{name:'register'}">Регистрация</router-link>
        </form>
    </div>
</template>

<script>
    /* eslint-disable no-undef */

    export default {
        data () {
            return {
                email: '',
                password: '',
                loading : false
            }
        },
        methods: {
            login () {
                let data = {
                    email: this.email,
                    password: this.password,
                    remember: this.remember
                }
                this.loading = true;
                auth
                    .login(data)
                    .then(() => {
                       this.$router.push({name : 'profile'})
                        this.loading = false;
                    })
                    .catch(error => {
                        this.$snotify.error('Неверный и/или пароль', 'Error', {
                            'maxOnScreen': 5,
                            'position': 'rightBottom'
                        });
                        this.loading = false;
                    })
            }
        }
    }
</script>

<style scoped>

</style>