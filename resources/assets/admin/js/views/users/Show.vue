<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12 d-flex align-items-end justify-content-end">
                <div class="form-group">
                    <router-link :to="{name : 'UsersCreate'}" class="btn btn-primary">Создать</router-link>
                </div>
            </div>
            <div class="col-lg-12">
                <b-card header="<i class='fa fa-align-justify'></i> Users">
                    <b-pagination size="md" :total-rows="result.total" v-model="pagination"
                                  :per-page="25"></b-pagination>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя пользователя</th>
                            <th>Дата регистрации</th>
                            <th>Возраст</th>
                            <th>Статус</th>
                            <th>Аватар</th>
                            <th>Дейтсвия</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="user in result.data">
                            <td>{{user.id}}</td>
                            <td>{{user.name}}</td>
                            <td> {{ $moment(user.created_at).calendar() }}</td>
                            <td>{{user.age}}</td>
                            <td>
                                <c-switch @change="setStatusConfirm(user.id,$event)" type="icon" variant="primary" v-bind="{on: '\uf00c', off: '\uf00d'}" :pill="true" :checked="user.confirmed"/>
                            </td>
                            <td>
                                <div class="avatar">
                                    <img :src="user.avatar" class="img-avatar" alt="">
                                </div>
                            </td>
                            <td>
                                <router-link :to="{name : 'UsersEdit',params : {id : user.id}}">
                                    <i class="icon-pencil"></i>
                                </router-link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <b-pagination size="md" :total-rows="result.total" v-model="pagination"
                                  :per-page="25"></b-pagination>
                </b-card>
            </div><!--/.col-->
        </div><!--/.row-->

    </div>

</template>

<script>
    import Qs from 'qs'
    import cSwitch from '../../components/Switch'
    export default {
        components:{
          cSwitch
        },
        data() {
            return {
                result: {
                    data: [],
                    total: 0,
                    last_page: 0,
                    current_page: 0
                },
                loading: false,
                pagination: 0
            }
        },
        created() {
           // this.getResult();
        },
        watch: {
            pagination: function () {
                this.getResult();
            }
        },
        methods: {
            setStatusConfirm(id,e){
              axios.put('/user/set-status-confirm',{
                  id : id,
                  status : e
              });
            },
            getResult() {
                let nextPage = this.pagination;

                if (this.result.last_page && nextPage > this.result.last_page) {
                    this.loading = false;
                    return;
                }

                let data = {}

                data.page = nextPage;

                this.loading = true;

                return axios.get('/user', {
                    params: data,
                    paramsSerializer: params => {
                        return Qs.stringify(params, {arrayFormat: 'brackets'})
                    }
                })
                    .then(({data}) => {
                        this.result.data = data.data
                        this.result.total = data.meta.total
                        this.result.last_page = data.meta.last_page
                        this.result.current_page = data.meta.current_page
                        this.loading = false
                        this.pagination = data.meta.current_page
                    }).catch(e => {
                        console.log(e)
                    })
            }
        }
    }
</script>

<style scoped>

</style>