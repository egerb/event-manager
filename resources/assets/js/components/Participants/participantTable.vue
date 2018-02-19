<template>
    <div class="col-xs-10 col-xs-offset-1">
        <vue-snotify></vue-snotify>
        <button class="btn btn-default">
            Импорт Excel
        </button>
        <download-excel
                class   = "btn btn-default"
                :data   = "excel_data"
                :fields = "excel_fields"
                :meta   = "excel_meta"
                name    = "users.xls">

            Експорт  Excel

        </download-excel>
        <filter-bar></filter-bar>
        <div class="form-group">
            <!--<select v-model="selectedLap" class="form-control">
                <option value="all">Фильтровать по забегу</option>
                <option  v-for="lap in laps" v-bind:value="lap.id" >
                    {{lap.title}} |
                </option>
            </select>-->
        </div>
        <vuetable ref="vuetable"
                  api-url="http://events/api/participants"
                  :fields="fields"
                  pagination-path=""
                  :css="css.table"
                  detail-row-component="detail-row-participant"
                  track-by="uid"
                  :append-params="moreParams"
                  @vuetable:cell-clicked="onCellClicked"
                  @vuetable:pagination-data="onPaginationData"
        >
            <template slot="contacts" slot-scope="props">
                <div>
                    {{props.rowData.user.phone}}
                </div>
                <div>
                    {{props.rowData.user.email}}
                </div>
            </template>
            <template slot="name" slot-scope="props">
                <div>
                    {{props.rowData.user.profile.first_name}}
                </div>
                <div>
                    {{props.rowData.user.profile.last_name}}
                </div>
            </template>
            <template slot="birthday" slot-scope="props">
                <div>
                    {{props.rowData.user.profile.birth_date}}
                </div>
                <div v-if="props.rowData.user.profile.gender === 'male'">
                    мужской
                </div>
                <div v-else>
                    женский
                </div>
            </template>
        </vuetable>
        <div class="vuetable-pagination">
            <vuetable-pagination-info ref="paginationInfo"
                                      info-class="pagination-info"
            ></vuetable-pagination-info>
            <vuetable-pagination ref="pagination"
                                 :css="css.pagination"
                                 @vuetable-pagination:change-page="onChangePage"
            ></vuetable-pagination>

        </div>
    </div>
</template>

<script>
    //import accounting from 'accounting'
    import Vuetable from 'vuetable-2/src/components/Vuetable'
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
    import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
    import VueEvents from 'vue-events'
    import CustomActions from './CustomActions'
    import DetailRow from './DetailRow'
    import FilterBar from './FilterBar'
    import CreateForm from'./createForm'
    import moment from 'moment'
    import Snotify, { SnotifyPosition } from 'vue-snotify'
    import 'vue-snotify/styles/material.css';
    const options = {
        toast: {
            position: SnotifyPosition.rightTop
        }
    }
    import JsonExcel from 'vue-json-excel';


    Vue.use(Snotify, options)

    Vue.use(VueEvents)
    Vue.component('custom-action-participant', CustomActions)
    Vue.component('detail-row-participant', DetailRow)
    Vue.component('filter-bar', FilterBar)
    Vue.component('create-form-participant', CreateForm)
    Vue.component('downloadExcel', JsonExcel);

    export default {
        components: {
            Vuetable,
            VuetablePagination,
            VuetablePaginationInfo,
        },
        props:['lapUid'],
        data () {
            return {
                selectedLap:'all',
                laps:[],
                excel_meta: [
                    [{
                        "key": "charset",
                        "value": "utf-8"
                    }]
                ],
                excel_fields: {
                    'Имя':"first_name",
                    'Фамилия':"last_name",
                    'Дата рождения':"birth_date",
                    'Телефон':"phone",
                    'Email':"email"
                },
                excel_data:[],
                //lap:null,
                showCreateForm:false,
                per_page:10,
                client:null,
                fields: [
                    {
                        name: '__sequence',
                        title: '#',
                        titleClass: 'text-right',
                        dataClass: 'text-right'
                    },
                    {
                        name: '__checkbox',
                        titleClass: 'text-center',
                        dataClass: 'text-center',
                    },
                    {
                        name: 'uid',
                        title: 'Идентификатор',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    },
                    {
                        name: 'tracker_id',
                        title: 'Код трекера',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    },
                    {
                        name: '__slot:name',
                        title: 'Имя, Фамилия',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    },
                    {
                        name: '__slot:birthday',
                        title: 'Дата рождения, пол',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    },
                    {
                        name: '__slot:contacts',
                        title: 'Контакты',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    },
                    {
                        name:'payment',
                        title:'Оплата',
                        callback:'payment',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    },
                    {
                        name: '__component:custom-action-promo',
                        title: 'Actions',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    }
                ],
                css: {
                    table: {
                        tableClass: 'table table-bordered table-striped table-hover',
                        ascendingIcon: 'glyphicon glyphicon-chevron-up',
                        descendingIcon: 'glyphicon glyphicon-chevron-down'
                    },
                    pagination: {
                        wrapperClass: 'pagination',
                        activeClass: 'active',
                        disabledClass: 'disabled',
                        pageClass: 'page',
                        linkClass: 'link',
                        icons: {
                            first: '',
                            prev: '',
                            next: '',
                            last: '',
                        },
                    },
                    icons: {
                        first: 'glyphicon glyphicon-step-backward',
                        prev: 'glyphicon glyphicon-chevron-left',
                        next: 'glyphicon glyphicon-chevron-right',
                        last: 'glyphicon glyphicon-step-forward',
                    },
                },
//                sortOrder: [
//
//                    { field: 'email', sortField: 'email', direction: 'asc'}
//                ],
                moreParams: {
                    lapUid:this.lapUid
                }
            }
        },
        methods: {
            payment(val){
                if (val==='NO_PAYMENT')
                    return 'Не оплачено'
                else (val==='BY_MANUAL')
                    return 'Оплачено'
            },
            usedDisplay(val) {
                return (!val) ? '<i class="fa fa-close" style="color:red;"></i>' : '<i class="fa fa-check" style="color: #2b542c;"></i>';
            },
            create() {
                (this.showCreateForm) ?  this.showCreateForm = false : this.showCreateForm = true
            },
            onPaginationData (paginationData) {
                this.$refs.pagination.setPaginationData(paginationData)
                this.$refs.paginationInfo.setPaginationData(paginationData)
            },
            onChangePage (page) {
                this.$refs.vuetable.changePage(page)
            },
            onCellClicked (data, field, event) {
               /*if (field.name == 'lap_name' || field.name == 'promo_code') {
                   this.$refs.vuetable.toggleDetailRow(data.uid)
               }*/

            },
            runFilter() {
                //console.log(this.laps)
                self = this
                this.laps.forEach(function(lap){
                   if (lap.uid == self.lapUid) self.selectedLap = lap.id
                })
            }
        },
        watch: {
            selectedLap() {
                self = this
                if(this.selectedLap == 'all') {
                    self.moreParams.lap = null
                    self.$refs.vuetable.resetData()
                    self.$refs.vuetable.reload()
                } else
                this.laps.forEach(function (lap) {
                    if (lap.id == self.selectedLap) {
                        self.moreParams.lap = lap.uid
                        self.$refs.vuetable.resetData()
                        self.$refs.vuetable.reload()
                        console.log(self.$refs.vuetable.tableData)
                    }
                })
            }
        },
        mounted() {
            self = this
            this.client = axios.create({
                baseURL: 'http://events/api/',
                headers: {
                    //"content-type": "application/json",
                    "Accept": "application/json",
                    //'Authorization': 'Bearer ' + this.bearer
                }
            });
            //Get all events
            //+(this.lapUid) ? this.lapUid : null
            this.client.get('participants/', {

                params: {
                    lapUid:self.lapUid,
                    per_page:'all'
                }
            })
                .then((response) => {
                    console.log(response)
                    response.data.data.forEach(function(part){
                        let row = {}
                        row.first_name = part.user.profile.first_name;
                        row.last_name = part.user.profile.last_name;
                        row.birth_date = part.user.profile.birth_date;
                        row.phone = part.user.phone;
                        row.email = part.user.email;
                        self.excel_data.push(row);
                    });
                    //self.laps = response.data
                    if (self.lapUid) this.runFilter()
                })


        },
        events: {
            'filter-set' (filterText) {
                this.moreParams = {
                    filter: filterText
                }
                Vue.nextTick( () => this.$refs.vuetable.refresh() )
            },
            'filter-reset' () {
                this.moreParams = {}
                Vue.nextTick( () => this.$refs.vuetable.refresh() )
            }
        }
    }
</script>
<style>
    .alert {
        z-index: 10000;
    }
    .pagination {
        margin: 0;
        float: right;
    }
    .pagination a.page {
        border: 1px solid lightgray;
        border-radius: 3px;
        padding: 5px 10px;
        margin-right: 2px;
    }
    .pagination a.page.active {
        color: white;
        background-color: #337ab7;
        border: 1px solid lightgray;
        border-radius: 3px;
        padding: 5px 10px;
        margin-right: 2px;
    }
    .pagination a.btn-nav {
        border: 1px solid lightgray;
        border-radius: 3px;
        padding: 5px 7px;
        margin-right: 2px;
    }
    .pagination a.btn-nav.disabled {
        color: lightgray;
        border: 1px solid lightgray;
        border-radius: 3px;
        padding: 5px 7px;
        margin-right: 2px;
        cursor: not-allowed;
    }
    .pagination-info {
        float: left;
    }
</style>