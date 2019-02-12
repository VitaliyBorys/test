<template>
    <div>
        <h1 class="mt-5">Лотерея</h1>
        <div class="row">
            <div class="col-md-8">
                <b-pagination class='pull-left' size="md" :total-rows="result.total" v-model="pagination"
                              :per-page="25"></b-pagination>
            </div>
            <div class="col-md-4" style="text-align: right">
                <button class="btn btn-success" @click.prevent="getPrize">Получить случайный приз</button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <b-card header="<i class='fa fa-align-justify'></i> Prizes">
                    <div class="col-md-3 bg" v-if="loading">
                        <div class="loader" id="loader-6">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Приз</th>
                            <th>Дата и время выиграша</th>
                            <th>Статус</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="prize in result.data">
                            <td>{{prize.id}}</td>
                            <td v-html="prize.title"></td>
                            <td>{{prize.created_at}}</td>
                            <td v-html="prize.status"></td>
                            <td>
                                <button v-for="(action,index) in prize.actions" :key="index" class="btn btn-sm btn-block"
                                        :class="'btn-'+action.label" @click="runAction(action.url,prize.id)">
                                    {{action.text}}
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </b-card>
            </div><!--/.col-->
        </div><!--/.row-->

    </div>
</template>

<script>
    import Qs from 'qs'

    export default {
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
            this.loadPrizes();
        },
        watch: {
            pagination: function () {
                this.loadPrizes();
            }
        },
        methods: {
            runAction(url, id) {
                axios.get('/api/' + url, {
                    params: {
                        prize_id: id
                    }
                })
                    .then(() => {
                        this.loadPrizes()
                    });
            },
            loadPrizes() {


                let nextPage = this.pagination;

                if (this.result.last_page && nextPage > this.result.last_page) {
                    this.loading = false;
                    return;
                }

                let data = {}
                data.page = nextPage;

                this.loading = true;

                return axios.get('/api/prizes', {
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
            },
            getPrize() {
                axios.get('/api/get-prize')
                    .then(({data}) => {
                        this.loadPrizes();
                        this.$snotify.warning('Вы выиграли '+data.message, 'Поздравляем', {
                            'maxOnScreen': 5,
                            'position': 'rightTop'
                        });
                    })
            }
        }
    }
</script>

<style lang="scss">
    @import "~vue-snotify/styles/material";

    .loader {
        width: 100px;
        height: 100px;
        border-radius: 100%;
        position: relative;
        margin: 0 auto;
    }


    /* LOADER 6 */

    #loader-6 {
        top: 40px;
        left: -2.5px;
    }

    #loader-6 span {
        display: inline-block;
        width: 5px;
        height: 20px;
        background-color: #3498db;
    }

    #loader-6 span:nth-child(1) {
        animation: grow 1s ease-in-out infinite;
    }

    #loader-6 span:nth-child(2) {
        animation: grow 1s ease-in-out 0.15s infinite;
    }

    #loader-6 span:nth-child(3) {
        animation: grow 1s ease-in-out 0.30s infinite;
    }

    #loader-6 span:nth-child(4) {
        animation: grow 1s ease-in-out 0.45s infinite;
    }

    @keyframes grow {
        0%, 100% {
            -webkit-transform: scaleY(1);
            -ms-transform: scaleY(1);
            -o-transform: scaleY(1);
            transform: scaleY(1);
        }

        50% {
            -webkit-transform: scaleY(1.8);
            -ms-transform: scaleY(1.8);
            -o-transform: scaleY(1.8);
            transform: scaleY(1.8);
        }
    }

</style>