<template>
    <div class="col-xs-10 col-xs-offset-1">
        <vue-snotify></vue-snotify>
        <button @click="createEvent" classs="btn-primary pull-right">
            <span v-if="showCreateForm"><span class="fa fa-minus"></span>Отменить</span>
            <span v-if="!showCreateForm"><span class="fa fa-plus"></span>Создать</span>
        </button>
        <div v-if="showCreateForm">
            <create-form-event></create-form-event>
        </div>
        <filter-bar></filter-bar>
        <vuetable ref="vuetable"
                  api-url="http://events/api/events"
                  :fields="fields"
                  pagination-path=""
                  :css="css.table"
                  :sort-order="sortOrder"
                  :multi-sort="true"
                  detail-row-component="detail-row-event"
                  track-by="uid"
                  :append-params="moreParams"
                  @vuetable:cell-clicked="onCellClicked"
                  @vuetable:pagination-data="onPaginationData"
        >
            <template slot="laps" slot-scope="props">
                <div v-if="props.rowData.all_laps != 0">
                    <a :href="'/admin/laps-table?event='+props.rowData.uid">
                        {{props.rowData.all_laps}}
                    </a>
                </div>
                <div v-else="">
                    {{props.rowData.all_laps}}
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
    //import Vue from 'vue'
    import VueEvents from 'vue-events'
    import CustomActions from './CustomActions'
    import DetailRow from './DetailRowEvent'
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
    Vue.component('custom-action-event', CustomActions)
    Vue.component('detail-row-event', DetailRow)
    Vue.component('filter-bar', FilterBar)
    Vue.component('create-form-event', CreateForm)

    window.bus = new Vue();

    export default {
        components: {
            Vuetable,
            VuetablePagination,
            VuetablePaginationInfo,
        },
        data () {
            return {
                showCreateForm:false,
                per_page:20,
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
                        title: 'Название ивента',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    },
                    {
                        name: 'place',
                        title: 'Место',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    },
                    {
                        name: 'link',
                        title: 'URL',
                        titleClass: 'text-center',
                        callback: 'buildUrl'
                    },
                    {
                        name: 'main_page',
                        title: 'На главной',
                        titleClass: 'text-center',
                        callback: 'mainPage'
                    },
                    {
                        name: '__slot:laps',
                        title: 'Забегов',
                        titleClass: 'text-center',
                        dataClass: 'text-center',
                        callback:'lapsLink'
                    },
                    {
                        name: 'date',
                        title: 'Дата',
                        titleClass: 'text-center',
                        dataClass: 'text-center',
                        callback:'formatDate'
                    },
                    {
                        name: 'active',
                        title: 'Регистрация?',
                        titleClass: 'text-center',
                        dataClass: 'text-center',
                        callback:'active'
                    },
                    {
                        name: '__component:custom-action-event',
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
                sortOrder: [
                    { field: 'email', sortField: 'email', direction: 'asc'}
                ],
                moreParams: {}
            }
        },
        methods: {
            mainPage(val) {
                return (val) ? '<span class="fa fa-check-square-o"></span>':'<span class="fa fa-low-vision"></span>';
            },
            buildUrl(val) {
                return '<a href="'+val+'" target="_blank">Перейти</a>';
            },
            createEvent() {
                (this.showCreateForm) ?  this.showCreateForm = false : this.showCreateForm = true
            },
            active(val) {
                return (val) ? '<span class="fa fa-check-square-o"></span>':'<span class="fa fa-low-vision"></span>';
            },
            formatDate (value, fmt = 'D-MM-YYYY') {
                return (value == null)
                    ? ''
                    : moment(value, 'DD-MM-YYYY').format(fmt)
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

            }
        },
        mounted() {
            this.client = axios.create({
                baseURL: 'http://events/api/events',
                headers: {
                    //"content-type": "application/json",
                    "Accept": "application/json",
                    //'Authorization': 'Bearer ' + this.bearer
                }
            });

            this.fetch();
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