<template>
    <div class="col-md-6 offset-md-3">
        <form class="form-signin">
            <div class="text-center mb-4">
                <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>
            </div>

            <div class="form-label-group">
                <label>Ваше имя</label>
                <input type="text" class="form-control" :class="{'is-invalid': _.has(errors_list,'name') }" v-model="name"
                       required autofocus>
                <div class="invalid-feedback" v-if="_.has(errors_list,'name')">
                    {{_.head(errors_list['name'])}}
                </div>
            </div>

            <div class="form-label-group">
                <label>Ваша фамилия</label>
                <input type="text" class="form-control" :class="{'is-invalid': _.has(errors_list,'lastname') }"
                       v-model="lastname" required autofocus>
                <div class="invalid-feedback" v-if="_.has(errors_list,'lastname')">
                    {{_.head(errors_list['lastname'])}}
                </div>
            </div>

            <div class="form-label-group">
                <label>Ваш номер телефона</label>
                <input type="text" class="form-control" v-model="phone" :class="{'is-invalid' : _.has(errors_list,'phone')}"
                       required autofocus>
                <div class="invalid-feedback" v-if="_.has(errors_list,'phone')">
                    {{_.head(errors_list['phone'])}}
                </div>
            </div>


            <div class="form-label-group">
                <div class="form-group">
                    <label class="form-form-control-label">Email</label>
                    <input type="email"
                           class="form-control"
                           :class="{'is-invalid' : _.has(errors_list,'email')}"
                           v-model="email"
                           name="email">
                    <div class="invalid-feedback" v-if="_.has(errors_list,'email')">
                        {{_.head(errors_list['email'])}}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-form-control-label">Birthday</label>
                <b-form-input v-model="birthday" id="birthday" type="date"
                              :class="{'is-invalid' : _.has(errors_list,'birthday')}"
                ></b-form-input>
                <div class="invalid-feedback" v-if="_.has(errors_list,'birthday')">
                    {{_.head(errors_list['birthday'])}}
                </div>
            </div>

            <div class="form-group">
                <label class="form-form-control-label">Номер банковской карты</label>
                <b-form-input v-model="card" id="card" type="text"
                              :class="{'is-invalid' : _.has(errors_list,'card')}"
                ></b-form-input>
                <div class="invalid-feedback" v-if="_.has(errors_list,'card')">
                    {{_.head(errors_list['card'])}}
                </div>
            </div>


            <div class="form-group">
                <label class="form-form-control-label">Password</label>
                <input type="password"
                       class="form-control"
                       :class="{'is-invalid' : _.has(errors_list,'password')}"
                       v-model="password"
                       name="password">
                <div class="invalid-feedback" v-if="_.has(errors_list,'password')">
                    {{_.head(errors_list['password'])}}
                </div>
            </div>
            <div class="form-group">
                <label class="form-form-control-label">Confirm Password</label>
                <input type="password"
                       class="form-control"
                       :class="{'is-invalid' : _.has(errors_list,'password_confirmation')}"
                       v-model="password_confirmation"
                       name="password_confirmation">
                <div class="invalid-feedback" v-if="_.has(errors_list,'password_confirmation')">
                    {{_.head(errors_list['password_confirmation'])}}
                </div>
            </div>
            <button class="btn btn-lg btn-primary btn-block" @click.prevent="save" type="submit">Sign up</button>
            <router-link :to="{name:'login'}">Уже есть акк ?</router-link>
        </form>
    </div>
</template>

<script>
    /* eslint-disable no-undef */
    import Datepicker from 'vuejs-datepicker';
    import flatpickr from 'flatpickr'

    export default {
        data() {
            return {
                saving : false,
                errors_list : [],
                email: '',
                password: '',
                password_confirmation: '',
                phone: '',
                name: '',
                lastname: '',
                gender: '',
                birthday: '',
                card : ''
            }
        },
        mounted() {
            flatpickr('[type=date]')
        },
        methods: {
            save() {
                this.saving = true;
                if (this.birthday) {
                    this.birthday = this.$moment(this.birthday).format('YYYY-MM-DD');
                }
                axios.post('/api/register', this.$data)
                    .then(({data}) => {
                       auth.login({
                          email : this.email,
                          password : this.password
                       });
                    })

                    .catch(e => {
                        let response = e.response;
                        if (_.has(response, 'data.errors')) {
                            this.errors_list = response.data.errors
                        }

                        this.$snotify.error('Попробуйсте еще раз', 'Error', {
                            'maxOnScreen': 5,
                            'position': 'rightBottom'
                        });
                    });
            },
        }
    }
</script>

<style scoped>

</style>