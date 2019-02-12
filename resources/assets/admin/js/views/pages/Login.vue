<template>
    <div class="app flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card-group mb-0">
                        <div class="card p-4">
                            <div class="card-body">
                                <h1>Вход</h1>
                                <p class="text-muted">Войти в аккаунт</p>
                                <ul class="alert alert-danger" v-if='errors.length > 0'>
                                   <li v-for="(error,index) in errors" :key="index">{{error}}</li>
                                </ul>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-user"></i></span>
                                    <input type="text" class="form-control" name="email" v-model="email"
                                           placeholder="email">
                                </div>
                                <div class="input-group mb-4">
                                    <span class="input-group-addon"><i class="icon-lock"></i></span>
                                    <input type="password" class="form-control" name="password" v-model="password"
                                           placeholder="пароль">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="button" @click.prevent="login" class="btn btn-primary px-4">
                                            Войти
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                email: '',
                password: '',
                errors : []
            }
        },
        methods: {
            login() {
                let data = {
                    email: this.email,
                    password: this.password,
                }
                auth
                    .login(data)
                    .then(() => {
                        this.errors = [];
                        this.$router.push({path: '/'})
                    })
                    .catch(error => {
                        this.errors = [];
                        let response = error.response
                        if (_.has(response, 'data.errors')) {
                            let errors = response.data.errors
                            if (errors) {
                                for (let key in errors) {
                                    this.errors.push(errors[key][0]);
                                }
                            }
                        }else if(_.has(response,'data.message')){
                            this.errors.push(response.data.message);
                        }
                        console.log(response);
                    })
            }
        }
    }
</script>
