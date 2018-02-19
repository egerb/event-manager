<template>
    <div class="col-xs-10 col-xs-offset-1">
        <vue-snotify></vue-snotify>
        <button @click="createEvent" classs="btn-primary pull-right">
            <span v-if="showCreateForm"><span class="fa fa-minus"></span>Отменить</span>
            <span v-if="!showCreateForm"><span class="fa fa-plus"></span>Создать</span>
        </button>
        <div v-if="showCreateForm">
            <create-form :laps="laps"></create-form>
        </div>
        <filter-bar></filter-bar>
        <div class="form-group">
            <select v-model="selectedLap" class="form-control">
                <option value="all">Фильтровать по забегу</option>
                <option  v-for="lap in laps" v-bind:value="lap.id" >
                    {{lap.title}} |
                </option>
            </select>
        </div>
        <vuetable ref="vuetable"
                  api-url="http://events/api/promo"
                  :fields="fields"
                  pagination-path=""
                  :css="css.table"
                  detail-row-component="detail-row-promo"
                  track-by="uid"
                  :append-params="moreParams"
                  @vuetable:cell-clicked="onCellClicked"
                  @vuetable:pagination-data="onPaginationData"
        ></vuetable>
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
    Vue.use(Snotify, options)

    Vue.use(VueEvents)
    Vue.component('custom-action-promo', CustomActions)
    Vue.component('detail-row-promo', DetailRow)
    Vue.component('filter-bar', FilterBar)
    Vue.component('create-form', CreateForm)

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
                        name: 'lap_name',
                        title: 'Название забега',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    },
                    {
                        name: 'promo_code',
                        title: 'Код',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    },
                    {
                        name: 'discount_percent',
                        title: 'Процент',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    },
                    {
                        name: 'used',
                        title: 'Использован?',
                        titleClass: 'text-center',
                        dataClass: 'text-center',
                        callback:'usedDisplay'
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
                    event:this.lapUid
                }
            }
        },
        methods: {
            usedDisplay(val) {
                return (!val) ? '<i class="fa fa-close" style="color:red;"></i>' : '<i class="fa fa-check" style="color: #2b542c;"></i>';
            },
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
               if (field.name == 'lap_name' || field.name == 'promo_code') {
                   this.$refs.vuetable.toggleDetailRow(data.uid)
               }

            },
            fetch(page=1) {

            },
            runFilter() {
                console.log(this.laps)
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
            this.client.get('laps', {
                params: {
                    per_page:'all'
                }
            })
                .then((response) => {
                    self.laps = response.data
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