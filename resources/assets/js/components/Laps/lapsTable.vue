<template>
    <div class="col-xs-10 col-xs-offset-1">
        <vue-snotify></vue-snotify>
        <button @click="createEvent" classs="btn-primary pull-right">
            <span v-if="showCreateForm"><span class="fa fa-minus"></span>Отменить</span>
            <span v-if="!showCreateForm"><span class="fa fa-plus"></span>Создать</span>
        </button>
        <div v-if="showCreateForm">
            <create-form-lap :events="events"></create-form-lap>
        </div>
        <filter-bar></filter-bar>
        <div class="form-group">
            <select v-model="selectedEvent" class="form-control">
                <option value="all">Фильтровать по ивенту</option>
                <option  v-for="event in events" v-bind:value="event.id" @changed="">
                    {{event.title}} | {{event.date}} | {{event.place}}
                </option>
            </select>
        </div>
        <vuetable ref="vuetable"
                  api-url="http://events/api/laps"
                  :fields="fields"
                  pagination-path=""
                  :css="css.table"
                  :multi-sort="true"
                  detail-row-component="detail-row-lap"
                  track-by="uid"
                  :append-params="moreParams"
                  @vuetable:cell-clicked="onCellClicked"
                  @vuetable:pagination-data="onPaginationData"
        >
            <template slot="countPromo" slot-scope="props">
                <div v-if="props.rowData.count_promo != 0">
                    <a :href="'/admin/promo-table/?lap='+props.rowData.uid">
                        {{props.rowData.count_promo}}
                    </a>
                </div>
                <div v-else>
                    {{props.rowData.count_promo}}
                </div>
            </template>
            <template slot="participants" slot-scope="props">
                {{props.rowData.count_participants}} - <a :href="'/admin/participants-table/?lap='+props.rowData.uid"> Перейти</a>
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
    //Notifications
    import Snotify, { SnotifyPosition } from 'vue-snotify'
    import 'vue-snotify/styles/material.css';
    const options = {
        toast: {
            position: SnotifyPosition.rightTop
        }
    }
    Vue.use(Snotify, options)

    Vue.use(VueEvents)
    Vue.component('custom-action-lap', CustomActions)
    Vue.component('detail-row-lap', DetailRow)
    Vue.component('filter-bar', FilterBar)
    Vue.component('create-form-lap', CreateForm)

    export default {
        components: {
            Vuetable,
            VuetablePagination,
            VuetablePaginationInfo,
        },
        props:['eventUid'],
        data () {
            return {
                selectedEvent:'all',
                events:[],
                event:null,
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
                        name: 'title',
                        title: 'Название забега',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    },
                    {
                        name: 'price',
                        title: 'Цена',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    },
                    {
                        name: 'partisipant_start_number',
                        title: 'Старт номеров',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    },
                    {
                        name:'__slot:participants',
                        title:'Учасники',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    },
                    {
                        name: '__slot:countPromo',
                        title: 'Промо коды',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    },
                    {
                        name: 'participants_limit',
                        title: 'Макс. Кол. учасников',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    },
                    {
                        name: 'active',
                        title: 'Отображать?',
                        titleClass: 'text-center',
                        dataClass: 'text-center',
                        callback:'active'
                    },
                    {
                        name: '__component:custom-action-lap',
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
                    event:this.eventUid
                }
            }
        },
        methods: {
            createEvent() {
                (this.showCreateForm) ?  this.showCreateForm = false : this.showCreateForm = true
            },
            active(val) {
                return (val) ? '<span class="fa fa-check-square-o"></span>':'<span class="fa fa-low-vision"></span>';
            },
            formatDate (value, fmt = 'D MMM YYYY') {
                return (value == null)
                    ? ''
                    : moment(value).format(fmt)
            },
            onPaginationData (paginationData) {
                this.$refs.pagination.setPaginationData(paginationData)
                this.$refs.paginationInfo.setPaginationData(paginationData)
            },
            onChangePage (page) {
                this.$refs.vuetable.changePage(page)
            },
            onCellClicked (data, field, event) {
               if (field.name == 'title' || field.name == 'datetime') {
                   this.$refs.vuetable.toggleDetailRow(data.uid)

               }
            },
            fetch(page=1) {

            },
            runFilter() {
                console.log(this.events)
                self = this
                this.events.forEach(function(event){
                   if (event.uid == self.eventUid) self.selectedEvent = event.id
                })
            }
        },
        watch: {
            selectedEvent() {
                self = this
                console.log(this.selectedEvent)
                if(this.selectedEvent == 'all') {
                    self.moreParams.event = null
                    self.$refs.vuetable.resetData()
                    self.$refs.vuetable.reload()
                } else
                this.events.forEach(function (event) {
                    if (event.id == self.selectedEvent) {
                        self.moreParams.event = event.uid
                        self.$refs.vuetable.resetData()
                        self.$refs.vuetable.reload()
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
            this.client.get('events', {
                params: {
                    per_page:'all'
                }
            })
                .then((response) => {
                    self.events = response.data
                    if (self.eventUid.length) this.runFilter()
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