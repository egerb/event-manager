<template>
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
                <label>Старт номеров от</label>
                <input  type="number" v-model="data.partisipant_start_number" class="form-control"/>
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

</template>

<script>
    import Datepicker from 'vuejs-datepicker';

    export default {
        inherit: true,
        components: {
            Datepicker: Datepicker
        },
        props:['events'],
        data() {
            return {
                format:'d-MM-yyyy',
                data: {
                    active:false
                },
                sms_text:'',
                messageLength:0
            }
        },
        methods: {
            activeChange() {
                (this.data.active) ? this.data.active = false : this.data.active = true
            },
            save() {
                console.log('Saving', this.$parent.client)

                this.$parent.client.post('laps', {
                    data:this.data
                }).then(response => {
                    if (response.data.state == 'success') {
                        this.$snotify.success(response.data.message)
                        this.$parent.$refs.vuetable.refresh()
                        this.$parent.showCreateForm = false;
                    } else {
                        this.$snotify.error(response.data.message);
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