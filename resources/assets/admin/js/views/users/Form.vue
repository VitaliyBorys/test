<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <b-card :no-block="true">
                    <div slot="header">
                        <strong>Данные пользователя</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-form-control-label" for="name">Имя</label>
                                    <input type="text"
                                           class="form-control"
                                           :class="{'is-invalid': _.has(errors,'name') }"
                                           v-model="user_info.name"
                                           id="name"
                                           name="name">

                                    <div class="invalid-feedback" v-if="_.has(errors,'name')">
                                        {{_.head(errors['name'])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-form-control-label">Фамилия</label>
                                    <input type="text"
                                           class="form-control"
                                           :class="{'is-invalid' : _.has(errors,'lastname')}"
                                           v-model="user_info.lastname"
                                           name="lastname">
                                    <div class="invalid-feedback" v-if="_.has(errors,'lastname')">
                                        {{_.head(errors['lastname'])}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-form-control-label" for="card">Номер банковской карты</label>
                                    <input type="text"
                                           class="form-control"
                                           :class="{'is-invalid': _.has(errors,'card') }"
                                           v-model="user_info.card"
                                           id="card"
                                           name="card">

                                    <div class="invalid-feedback" v-if="_.has(errors,'card')">
                                        {{_.head(errors['card'])}}
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-form-control-label">День рождения</label>
                                    <b-form-input id="birthday" type="date" v-model="user_info.birthday"
                                                  :class="{'is-invalid' : _.has(errors,'birthday')}"
                                    ></b-form-input>
                                    <div class="invalid-feedback" v-if="_.has(errors,'birthday')">
                                        {{_.head(errors['birthday'])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-form-control-label" for="gender">Gender</label>
                                    <b-form-radio
                                            :options="[{text: 'Male',value: 'm'},{text: 'Female',value: 'f'}]"
                                            v-model="user_info.gender"
                                            id="gender"
                                    ></b-form-radio>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-form-control-label" for="phone">Телефон</label>
                                    <input type="text"
                                           id="phone"
                                           class="form-control"
                                           :class="{'is-invalid' : _.has(errors,'phone')}"
                                           v-model="user_info.phone"
                                           name="phone">
                                    <div class="invalid-feedback" v-if="_.has(errors,'phone')">
                                        {{_.head(errors['phone'])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-form-control-label">Email</label>
                                    <input type="email"
                                           class="form-control"
                                           :class="{'is-invalid' : _.has(errors,'email')}"
                                           v-model="user_info.email"
                                           name="email">
                                    <div class="invalid-feedback" v-if="_.has(errors,'email')">
                                        {{_.head(errors['email'])}}
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-md-6">
                                <img :src="background !== null ? background : user_info.avatar"
                                     style="max-width: 250px;" alt="" class="img-thumbnail"
                                     v-if="background !== null ? background : user_info.avatar">
                            </div>
                            <div class="col-md-6">
                                <div class="custom-file">
                                    <input @change="changeFile" type="file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Выберите файл</label>
                                </div>
                            </div>
                        </div>

                    </div>
                </b-card>
            </div><!--/.col-->

        </div>
        <div class="row">
            <div class="col-md-6">
                <b-card>
                    <div slot="header">
                        <strong>Access</strong>
                    </div>
                    <div class="form-group">
                        <label class="form-form-control-label">Роли</label>
                        <v-select v-model="user_info.role" :options="this.roles"
                                  :clearable="false"
                                  :class="{'is-invalid' : _.has(errors,'role')}"
                                  :searchable="true"></v-select>
                    </div>
                    <div class="form-group">
                        <label class="form-form-control-label">Пароль</label>
                        <input type="password"
                               class="form-control"
                               :class="{'is-invalid' : _.has(errors,'password')}"
                               v-model="user_info.password"
                               name="password">
                        <div class="invalid-feedback" v-if="_.has(errors,'password')">
                            {{_.head(errors['password'])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-form-control-label">Повторите пароль</label>
                        <input type="password"
                               class="form-control"
                               :class="{'is-invalid' : _.has(errors,'password_confirmation')}"
                               v-model="user_info.password_confirmation"
                               name="password_confirmation">
                        <div class="invalid-feedback" v-if="_.has(errors,'password_confirmation')">
                            {{_.head(errors['password_confirmation'])}}
                        </div>
                    </div>
                </b-card>
            </div><!--/.col-->
            <div class="col-md-6">
                <b-card>
                    <div slot="header">
                        <strong>Save</strong>
                    </div>
                    <b-button variant="primary" @click="save" :disabled="saving">{{ (isCreate ? 'Сохранить' : 'Обновить')}}
                    </b-button>
                </b-card>
            </div>
        </div><!--/.row-->
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import flatpickr from 'flatpickr'

    export default {
        props: {
            id: {
                type: String,
                default: '0'
            }
        },
        data() {
            return {
                roles: [],
                avatar: null,
                background: null,
                isCreate: true,
                axios: {
                    url: '/user',
                    method: 'post'
                },
                message: {
                    put: 'Пользователь обновлен',
                    post: 'Пользователь создан'
                },
                user_info: {
                    role: null,
                    avatar: null,
                    id: null,
                    lastname: null,
                    name: null,
                    birthday: null,
                    languages: [],
                    phone: null,
                    email: null,
                    gender: 'm',
                    password: null,
                    password_confirmation: null,
                    card : null
                },
                errors: [],
                saving: false
            }
        },
        components: {
            Datepicker
        },
        mounted() {
            flatpickr('[type=date]')
        },
        created() {
            if (parseInt(this.id) > 0) {
                this.loadUser();
            }

            axios.get('/roles-list').then(({data}) => {
                this.roles = data.map((element) => {
                    element.label = element.name;
                    return element;
                });
            })

        },
        methods: {
            changeFile(ev) {
                if (ev.target.files && ev.target.files[0]) {
                    const file = ev.target.files[0];
                    const reader = new FileReader();

                    this.avatar = file;

                    reader.onload = (e) => {
                        this.background = e.target.result;
                    };

                    reader.readAsDataURL(file);
                } else {
                    this.avatar = null;
                    this.background = null;
                }


            },
            save() {
                this.saving = true;
                let data = {};
                data = this.user_info
                if (this.user_info.birthday) {
                    data.birthday = this.$moment(this.user_info.birthday).format('YYYY-MM-DD');
                }

                axios[this.axios.method](this.axios.url, data)
                    .then(({data}) => {
                        this.saving = false;
                        this.user_info.id = data.user_id;
                        this.errors = [];
                        this.$snotify.success(this.message[this.axios.method], '', {
                            'maxOnScreen': 5,
                            'position': 'rightBottom'
                        });

                    })
                    .then(() => {
                        if (this.avatar !== null) {
                            let formData = new FormData();
                            formData.append('avatar', this.avatar);
                            axios.post('/user/' + this.user_info.id + '/upload-avatar', formData);
                        }
                    })
                    .catch(e => {
                        this.$snotify.error('Проверьте данные и попытайтесь еще раз', 'Ошибка данных', {
                            'maxOnScreen': 5,
                            'position': 'leftBottom'
                        });
                        this.saving = false;
                        let response = e.response;
                        if (_.has(response, 'data.errors')) {
                            this.errors = response.data.errors
                        }
                    });
            },
            loadUser() {
                this.isCreate = false;
                this.axios.method = 'put';
                this.axios.url = '/user/' + this.id;
                axios.get('/user/' + this.id).then(({data}) => {
                    this.user_info = data;
                });
            }
        }
    }


</script>
