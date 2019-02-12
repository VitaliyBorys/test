<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <b-card header="<i class='fa fa-align-justify'></i> Настройки">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Ключ</th>
                            <th>Значение</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(field,index) in fields" :key="index">
                            <td>{{field.name}}</td>
                            <td>
                                <input type="text" class="form-control" v-model="fields[index].value" :name="field.key">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-success pull-right" @click.prevent="save">Сохранить</button>
                </b-card>
            </div><!--/.col-->
        </div><!--/.row-->

    </div>
</template>

<script>
    export default {
        created()
        {
            axios.get('/settings')
                .then(({data}) => {
                  this.settings = data;

                    _.forEach(data, (value, key) =>  {
                        _.find(this.fields, function(o) { return o.key == value.key; }).value = value.value;
                    });


                }).catch(e => {
                console.log(e);
            })
        },
        data(){
            return {
                settings : [],
                fields : [
                    {
                        name : 'Коэффициент конвертации денежнего приза',
                        key : 'k_convert',
                        value : 0
                    },
                    {
                        name : 'Ограничение денежнего приза',
                        key : 'limit_money',
                        value : 0
                    }
                ]
            }
        },
        methods:{
            getValueByKey(key){
                if(_.has(this.settings,key)){
                   return _.find(this.settings, function(o) { return o.key < key; });
                }
              return 1;
            },
            save(){
                axios.post('/settings',this.fields)
                    .then(({data}) => {
                        this.$snotify.success('Сохранение прошло успешно', 'Success', {
                            'maxOnScreen': 5,
                            'position': 'rightBottom'
                        });
                    }).catch(e => {
                    this.$snotify.error('Попробуйсте еще раз', 'Error', {
                        'maxOnScreen': 5,
                        'position': 'leftBottom'
                    });
                })
            }
        }
    }
</script>

<style scoped>

</style>