<template>
    <div @click="onClick" class="col-xs-8 col-xs-offset-2">

        <div class="panel panel-default">
            <div class="panel-heading">Редактирование ивента ID {{data.uid}}<button class="btn-success pull-right" @click="save"><span class="fa fa-check"></span>Сохранить</button></div>
            <div class="col-xs-12">Файл вида: {{'resources/views/events/event_'+data.uid+'.blade.php'}}</div>
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#main" aria-controls="home" role="tab" data-toggle="tab">Общее</a>
                    </li>
                    <li role="presentation"><a href="#payment" aria-controls="profile" role="tab" data-toggle="tab">Оплата</a>
                    </li>
                    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Email нотификации</a>
                    </li>
                    <li role="presentation"><a href="#messages-sms" aria-controls="messages" role="tab" data-toggle="tab">СМС нотификации</a>
                    </li>
                    <li role="presentation"><a href="#seo" aria-controls="settings" role="tab" data-toggle="tab">SEO</a></li>
                </ul>

                <!-- Tab panes -->

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="main">
                        <div class="form-group">
                            <label for="">Название</label>
                            <input type="text" class="form-control" id="" v-model="data.title">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">Дата</label>
                            <datepicker :monday-first="true" language="ru" v-model="data.date"  :value="data.date" :format="format"></datepicker>
                        </div>
                        <div class="form-group">
                            <label >Место</label>
                            <input type="text" class="form-control" v-model="data.place">
                        </div>
                        <div class="form-group">
                            <input type="checkbox"  v-model="data.active" />
                            <label for="exampleInputEmail" @click="activeChange">Отображать</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox"  v-model="data.main_page" />
                            <label for="exampleInputEmail" @click="mainChange">На главной</label>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">Контакты</label>
                            <input type="text" class="form-control" id="exampleInputEmail" v-model="data.contacts">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">Соглашение</label>
                            <textarea class="form-control" rows="10" v-model="data.letter_agreement"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">Дополнительная инфо</label>
                            <textarea class="form-control" rows="10" v-model="data.additional_info"></textarea>
                        </div>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="payment">
                        <div class="form-group">
                            <label for="exampleInputEmail">
                                LiqPay ID</label>
                            <input type="text" class="form-control" id="exampleInputEmail" v-model="data.liqpay_id">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">LiqPay Secret</label>
                            <input type="text" class="form-control" id="exampleInputEmail" v-model="data.liqpay_secret">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">LiqPay URL</label>
                            <input type="text" class="form-control" id="exampleInputEmail" v-model="data.liqpay_url">
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="messages">
                        <div class="form-group">
                            <label for="exampleInputEmail">
                                E-Mail отправителя</label>
                            <input type="text" class="form-control" id="exampleInputEmail" v-model="data.email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">Имя отправителя E-Mail</label>
                            <input type="text" class="form-control" id="exampleInputEmail" v-model="data.email_from">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">Тема постоянной ссылки об оплате E-Mail</label>
                            <input type="text" class="form-control" id="exampleInputEmail" v-model="data.subject">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">
                                Текст для отправки емайла с постоянной ссылкой об оплате
                                {name_race} - Название забега
                                {name_user} - имя участника
                                {user_email} - Email участника
                                {url_payment} - посстоянная ссылка для оплаты
                            </label>
                            <textarea class="form-control" rows="10" v-model="data.email_text"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail">
                                Тема успешной оплаты E-Mail</label>
                            <input type="text" class="form-control" id="exampleInputEmail" v-model="data.email_subject_success_payment">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">
                                Текст для отправки емайла об успешной оплате
                                {name_race} - Название забега
                                {name_user} - имя участника
                                {number_user} - Номер участника
                                {user_email} - Email участника
                                {user_pdf} - постоянная ссылка на PDF файл</label>
                            <textarea class="form-control" rows="10" v-model="data.email_text_success_payment"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail">E-Mail для получения писем об оплате</label>
                            <input type="text" class="form-control" id="exampleInputEmail" v-model="data.email_subject_success_payment_admin">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">Текст письма об оплате
                                {name_race} - Название забега
                                {name_user} - имя участника
                                {number_user} - Номер участника
                                {user_email} - Email участника
                                {user_pdf} - постоянная ссылка на PDF файл
                            </label>
                            <textarea class="form-control" rows="10" v-model="data.email_text_success_payment_admin"></textarea>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="messages-sms">
                        <div class="form-group">
                            <label for="exampleInputEmail">Логин</label>
                            <input type="text" class="form-control" id="exampleInputEmail" v-model="data.sms_user">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">Пароль</label>
                            <input type="text" class="form-control" id="exampleInputEmail" v-model="data.sms_pass">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">Отправитель</label>
                            <input type="text" class="form-control" id="exampleInputEmail" v-model="data.sms_sender_from">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">
                                Текст(макс 200 символов)
                                {name_race} - Название забега
                                {name_user} - имя участника
                                {number_user} - Номер участника
                            </label>
                            <textarea class="form-control" rows="10" v-model="sms_text"></textarea><span>{{messageLength}}</span>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="seo">

                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import VueEvents from 'vue-events'
    import moment from 'moment'

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
                format:'dd-MM-yyyy',
                data: this.rowData,
                sms_text:'',
                messageLength:0
            }
        },
        computed: {

        },
        methods: {
            mainChange() {
                (this.data.main_page) ? this.data.main_page = false : this.data.main_page = true
            },
            activeChange() {
                (this.data.active) ? this.data.active = false : this.data.active = true
            },
            save() {
                //console.log('Saving', this.data)
                //Convetrting date
                this.data.date = moment(this.data.date).format('DD-MM-YYYY');
                this.$parent.$parent.client.patch('/'+this.data.uid, {
                        data:this.data
                }).then(response => {
                    (response.data.state == 'success') ? this.$parent.$snotify.success(response.data.message) : this.$parent.$snotify.error(response.data.message);
                    this.$parent.refresh();
                    console.log();
                    //console.log(response)
                });

            },
            onClick(event) {
                //console.log(this.client);
                //console.log(event);
                //console.log('my-detail-row: on-click', event.target)
            }
        },
        watch: {
            sms_text() {
                this.data.sms_text = this.sms_text
                this.messageLength = this.sms_text.length
            }
        },
        mounted() {
            (this.data.sms_text  === null) ? null : this.sms_text = this.data.sms_text;

            (this.rowData.date) ? this.rowData.date = moment(this.rowData.date, 'DD-MM-YYYY').toDate() : null;

        }
    }
</script>
