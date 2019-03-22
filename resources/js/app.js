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
Vue.component('tasks-component', require('./components/tasks/TasksComponent.vue').default);
Vue.component('avatar-form', require('./components/AvatarForm.vue').default);
Vue.component('tasks-calendar', require('./components/TasksCalendar.vue').default);
Vue.component('add-announcement', require('./components/AddAnnButton.vue').default);
Vue.component('add-new-user', require('./components/AddNewUser.vue').default);
Vue.component('edit-user', require('./components/EditUser.vue').default);
Vue.component('project-card', require('./components/ProjectCard.vue').default);
Vue.component('add-task', require('./components/tasks/AddTask.vue').default);
Vue.component('user-stats', require('./components/UserStats.vue').default);
Vue.component('paginator', require('./components/Paginator.vue').default);
Vue.component('general-notes', require('./components/GeneralNotes.vue').default);
Vue.component('latest-project-updates', require('./components/LatestProjectUpdates.vue').default);

const app = new Vue({
    el: '#app',

});

