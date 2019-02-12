<template>
    <div class="container">
        <div class="row info" style="text-align:center;">

        </div>

        <div class="resume" v-if="user">
            <header class="page-header">
                <h1 class="page-title"> Личные данные {{user.fullname}}</h1>
            </header>
            <div class="row">
                <div class="col-xs-12 col-sm-12  col-md-12  col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading resume-heading">
                            <div class="row">
                                <div class="col-md-4">
                                    <img :src="user.avatar" alt="">
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <td>{{user.id}}</td>
                                        </tr>
                                        <tr>
                                            <th>Имя</th>
                                            <td>{{user.fullname}}</td>
                                        </tr>
                                        <tr>
                                            <th>Телефон</th>
                                            <td>{{user.phone}}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{user.email}}</td>
                                        </tr>
                                        <tr>
                                            <th>Дата рождение</th>
                                            <td>{{user.birthday}}</td>
                                        </tr>
                                        <tr>
                                            <th>Полных лет</th>
                                            <td>{{user.age}}</td>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>Бонусы</th>
                                            <td>{{user.bonuses}}</td>
                                            <td>
                                                <button class="btn btn-sm btn-success" @click="convert" v-if="!loading">
                                                    Конвертировать в деньги
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Денежные средства</th>
                                            <td>{{user.money}}</td>
                                            <td>
                                                <button class="btn btn-sm btn-success" @click="withdrow" v-if="!loading">
                                                    Вывести на карту
                                                </button>
                                            </td>
                                        </tr>
                                        </thead>
                                    </table>
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
                loading: false,
                user: false
            }
        },
        created() {
            this.loadProfile();
        },
        methods: {
            loadProfile() {
                axios.get('/api/profile')
                    .then(({data}) => {
                        this.user = data;
                    })
            },
            successAlert(msg) {
                this.$snotify.success(msg, 'Success', {
                    'maxOnScreen': 5,
                    'position': 'rightBottom'
                });
            },
            errorAlert(msg) {
                this.$snotify.error(msg, 'Data error', {
                    'maxOnScreen': 5,
                    'position': 'leftBottom'
                });
            },
            convert() {
                axios.get('/api/profile/convert')
                    .then(({data}) => {
                        this.successAlert('Конвертация прошла успешно');
                        this.loadProfile();
                    })
                    .catch(e => {
                        this.errorAlert(e.response.data.message);
                    })
            },
            withdrow() {
                axios.get('/api/profile/sendToCard')
                    .then(({data}) => {
                        this.successAlert('Выплата прошла успешно');
                        this.loadProfile();
                    })
                    .catch(e => {
                        this.errorAlert(e.response.data.message);
                    })
            }
        }
    }
</script>

<style scoped>

</style>