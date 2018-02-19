<template>
    <div @click="onClick" class="col-xs-8 col-xs-offset-2">

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
        </div>

</template>

<script>

    import VueEvents from 'vue-events'
    import Vue from 'vue'
    import UUID from 'vue-uuid'

    Vue.use(UUID)

    Vue.use(VueEvents)

    export default {
        inherit: true,
        components: {

        },
        props: {
            rowData: {
                type: Object,
                required: true
            },
            rowIndex: {
                type: Number
            }
        },
        data() {
            return {
                laps:this.$parent.$parent.laps,
                format:'d-MM-yyyy',
                data: this.rowData,
                selectedEvent:null,
            }
        },
        computed: {

        },
        methods: {
            save() {
                console.log('Saving', this.data)
                this.$parent.$parent.client.patch('promo/'+this.data.uid, {
                        data:this.data
                }).then(response => {
                    (response.data.state == 'success') ? this.$parent.$snotify.success(response.data.message) : this.$parent.$snotify.error(response.data.message);
                    console.log(response)
                });

            },
            onClick(event) {

            }
        },
        watch: {

        },
        mounted() {
            //this.selectedEvent = this.data.event_id
        }
    }
</script>
