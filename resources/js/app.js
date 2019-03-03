/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import FullCalendar from 'vue-full-calendar';
import 'fullcalendar/dist/fullcalendar.css';

import VModal from 'vue-js-modal';
import VueSession from 'vue-session';

window.Vue = require('vue');
require('./bootstrap');

Vue.use(FullCalendar);
Vue.use(VModal);
Vue.use(VueSession);

Vue.component('flash-component', require('./components/FlashComponent.vue').default);
Vue.component('avatar-form', require('./components/AvatarForm.vue').default);
Vue.component('tasks-calendar', require('./components/TasksCalendar.vue').default);
Vue.component('add-announcement', require('./components/AddAnnButton.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});