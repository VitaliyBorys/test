<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12 d-flex align-items-end justify-content-end">
                <div class="form-group">
                    <router-link :to="{name : 'PrizeCreate'}" class="btn btn-primary">Create</router-link>
                </div>
            </div>
            <div class="col-lg-12">
                <b-card header="<i class='fa fa-align-justify'></i> Prizes">
                    <b-pagination size="md" :total-rows="result.total" v-model="pagination"
                                  :per-page="25"></b-pagination>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Poster</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="prize in result.data">
                            <td>{{prize.id}}</td>
                            <td>{{prize.title}}</td>
                            <td>
                                <div class="avatar">
                                    <img :src="prize.poster" class="img-avatar" alt="">
                                </div>
                            </td>
                            <td>
                                <router-link :to="{name : 'PrizeEdit',params : {id : prize.id}}">
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
            getResult() {
                let nextPage = this.pagination;

                if (this.result.last_page && nextPage > this.result.last_page) {
                    this.loading = false;
                    return;
                }

                let data = {}

                data.page = nextPage;

                this.loading = true;

                return axios.get('/prize', {
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