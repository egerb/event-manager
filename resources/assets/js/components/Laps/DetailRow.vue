<template>
    <div @click="onClick" class="col-xs-8 col-xs-offset-2">

        <div class="panel panel-primary">
            <div class="panel-heading">Редактирование <button class="btn-success pull-right" @click="save"><span class="fa fa-check"></span>Сохранить</button></div>
            <div class="panel-body">
                <div class="form-group">
                    <label>Ивент</label>
                    <select v-model="data.event_id">
                        <option value="null">Выберите ивент</option>
                        <option v-for="event in events" v-bind:value="event.id">
                            {{event.title}} | {{event.date}} | {{event.place}}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Заголовок</label>
                    <input v-model="data.title" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="checkbox"  v-model="data.active" />
                    <label @click="activeChange">Разрешить регистрацию</label>
                </div>
                <div class="form-group">
                    <label>Цена</label>
                    <input v-model="data.price" class="form-control"/>
                </div>

                <div class="form-group">
                    <label>Старт номеров</label>
                    <input disabled="" type="number" v-model="data.partisipant_start_number" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Возраст от</label>
                    <input type="number" v-model="data.age_from" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Возраст до</label>
                    <input type="number" v-model="data.age_to" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Лимит учасников</label>
                    <input type="number" v-model="data.participants_limit" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Дополнительные условия</label>
                    <textarea  v-model="data.additional_conditions" class="form-control" ></textarea>
                </div>
            </div>
        </div>
        </div>

</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import VueEvents from 'vue-events'

    Vue.use(VueEvents)

    export default {
        inherit: true,
        components: {
            Datepicker: Datepicker
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
                events:this.$parent.$parent.events,
                format:'d-MM-yyyy',
                data: this.rowData,
                selectedEvent:null,
            }
        },
        computed: {

        },
        methods: {
            activeChange() {
                (this.data.active) ? this.data.active = false : this.data.active = true
            },
            save() {
                console.log('Saving', this.data)
                this.$parent.$parent.client.patch('laps/'+this.data.uid, {
                        data:this.data
                }).then(response => {
                    (response.data.state == 'success') ? this.$snotify.success(response.data.message) : this.$snotify.error(response.data.message);

                    console.log(response)
                });

            },
            onClick(event) {

            }
        },
        watch: {

        },
        mounted() {
            console.log(this.data.uid)
            //this.selectedEvent = this.data.event_id
        }
    }
</script>
