<template>
    <div class="panel panel-primary">
        <div class="panel-heading">Редактирование <button class="btn-success pull-right" @click="save"><span class="fa fa-check"></span>Сохранить</button></div>
        <div class="panel-body">
            <div class="form-group">
                <label>Выберите забег</label>
                <select v-model="data.lap_id">
                    <option value="null">Забег</option>
                    <option v-for="lap in laps" v-bind:value="lap.id">
                        {{lap.title}} |
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label>Код<button @click="data.promo_code = $uuid.v1()">сгенерировать</button></label>
                <input v-model="data.promo_code" class="form-control"/>
            </div>
            <div class="form-group">
                <label>Скидка, %</label>
                <input v-model="data.discount_percent" class="form-control"/>
            </div>
        </div>
    </div>

</template>

<script>
    import Vue from 'vue'
    import UUID from 'vue-uuid'

    Vue.use(UUID)

    export default {
        inherit: true,
        components: {

        },
        props:['laps'],
        data() {
            return {
                data: {
                    promo_code:''
                },
            }
        },
        methods: {
            save() {
                console.log('Saving', this.$parent.client)

                this.$parent.client.post('promo', {
                    data:this.data
                }).then(response => {
                    if (response.data.state == 'success') {
                        this.$parent.$snotify.success(response.data.message)
                        this.$parent.$refs.vuetable.refresh()
                        this.$parent.showCreateForm = false;
                    } else {
                        this.$parent.$snotify.error(response.data.message);
                    }
                });

            },
            onClick(event) {
                //console.log(this.client);
                //console.log(event);
                //console.log('my-detail-row: on-click', event.target)
            }
        }
    }
</script>

<style>
 #createForm {
     margin-top:20px;
 }
</style>