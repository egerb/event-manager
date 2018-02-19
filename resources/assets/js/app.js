
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example', require('./components/Example.vue'));
Vue.component('events', require('./components/Events/eventsTable.vue'));
Vue.component('laps', require('./components/Laps/lapsTable.vue'));
Vue.component('promo', require('./components/Promocodes/promoTable.vue'));
Vue.component('participants', require('./components/Participants/participantTable.vue'));
Vue.component('register', require('./components/Registration/registerNewParticipant'));

const app = new Vue({
    el: '#app'
});

