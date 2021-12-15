//Vue Menu for One Menu <li> Item (switches text "login"/"logged")(component used in Menu in /views/layouts/app.php)


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap'); //otherwise Bootstrap collapsed menu won't work (bootstrap.js included 2 times)

window.Vue = require('vue');
import store from '../store/index'; //import Vuex Store

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('menu-one-item', require('./components/one-menu.vue')); //components containing menu with (login/logged) switch
//Vue.component('vue-router-menu-with-link-content-display',  require('./components/VueRouterMenu.vue')); //register component dispalying vue-router-menu

const appDD = new Vue({
    el: '#menuOneItem',
	store, //connect Vuex store, must-have
});
