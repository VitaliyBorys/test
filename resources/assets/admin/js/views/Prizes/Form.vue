<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <b-card :no-block="true">
                    <div slot="header">
                        <strong>Данные приза</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-form-control-label" for="name">Название</label>
                                    <input type="text"
                                           class="form-control"
                                           :class="{'is-invalid': _.has(errors,'title') }"
                                           v-model="prize_info.title"
                                           id="name"
                                           name="name">

                                    <div class="invalid-feedback" v-if="_.has(errors,'title')">
                                        {{_.head(errors['title'])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-form-control-label">Ссылка на картинку</label>
                                    <input type="text"
                                           class="form-control"
                                           :class="{'is-invalid' : _.has(errors,'poster')}"
                                           v-model="prize_info.poster"
                                           name="poster">
                                    <div class="invalid-feedback" v-if="_.has(errors,'poster')">
                                        {{_.head(errors['poster'])}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <b-button variant="primary" @click="save" :disabled="saving">{{ (isCreate ? 'Сохранить' : 'Обновить')}}
                        </b-button>

                    </div>
                </b-card>
            </div><!--/.col-->

        </div>
    </div>
</template>

<script>
    export default {
        props: {
            id: {
                type: String,
                default: '0'
            }
        },
        data() {
            return {
                background: null,
                isCreate: true,
                axios: {
                    url: '/prize',
                    method: 'post'
                },
                message: {
                    put: 'Приз обновлен',
                    post: 'Приз создан'
                },
                prize_info: {
                   title : '',
                   poster : '',
                },
                errors: [],
                saving: false
            }
        },

        created() {
            if (parseInt(this.id) > 0) {
                this.loadPrize();
            }
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
                    this.background = null;
                }
            },
            save() {
                this.saving = true;
                let data = {};
                data = this.prize_info;

                axios[this.axios.method](this.axios.url, data)
                    .then(({data}) => {
                        this.saving = false;
                        this.prize_info.id = data.prize_id;
                        this.errors = [];
                        this.$snotify.success(this.message[this.axios.method], '', {
                            'maxOnScreen': 5,
                            'position': 'rightBottom'
                        });

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
            loadPrize() {
                this.isCreate = false;
                this.axios.method = 'put';
                this.axios.url = '/prize/' + this.id;
                axios.get('/prize/' + this.id).then(({data}) => {
                    this.prize_info = data;
                });
            }
        }
    }


</script>
