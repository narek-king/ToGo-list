
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
import * as VueGoogleMaps from 'vue2-google-maps';
import PlacesIndex from './components/places/PlacesIndex.vue';
import PlacesCreate from './components/places/PlacesCreate.vue';
import PlacesEdit from './components/places/PlacesEdit.vue';

window.Vue.use(VueRouter);

Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyA-kNf8kPC_NT6NGhYAhawVATdkweQepRM',
        libraries: 'places,drawing,visualization', // This is required if you use the Autocomplete plugin
        // OR: libraries: 'places,drawing'
        // OR: libraries: 'places,drawing,visualization'
        // (as you require)

        //// If you want to set the version, you can do so:
        // v: '3.26',
    },
    autobindAllEvents: false
});

const routes = [
    {
        path: '/',
        components:  {
            placesIndex: PlacesIndex
        }
    },
    {path: '/admin/places/create', component: PlacesCreate, name: 'createPlace'},
    {path: '/admin/places/edit/:id', component: PlacesEdit, name: 'editPlace'},
];

const router = new VueRouter({ routes });

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('places-index', require('./components/places/PlacesIndex.vue'));
Vue.prototype.$bus = new Vue({});

const app = new Vue({ router }).$mount('#app');
