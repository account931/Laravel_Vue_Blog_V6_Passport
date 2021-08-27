//Admin Part
//https://medium.com/js-dojo/build-a-simple-blog-with-multiple-image-upload-using-laravel-vue-5517de920796

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap'); //alerady included in views/layout/app.php. Otherwise Bootstrap collapsed menu won't work (bootstrap.js included 2 times)

window.Vue = require('vue');

//include Vue Router
//import router from './router/index.js'


// Blog
//window.Vue = require('vue');
import store from '../store/index'; //import Vuex Store


Vue.component('login-vue-component',        require('./components/Login_component.vue'));        //login component 
Vue.component('registration-vue-component', require('./components/Registration_component.vue')); //register component 


//Vue.component('create-post',            require('./components/CreatePost.vue')/*.default*/);
//Vue.component('all-posts',              require('./components/AllPosts.vue')/*.default*/); //register component dispalying all posts

//vue-router-menu
//Vue.component('vue-router-menu-with-link-content-display',  require('./components/VueRouterMenu.vue')); //register component dispalying vue-router-menu






/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Component to Show div with Blogs' quantity
/*
const appQuant = new Vue({
	store, //connect Vuex store, must-have
    el: '#quant'
});
*/

/*
//Component with Form to add a new blog
const app = new Vue({
	store, //connect Vuex store
    el: '#createPost'
});



//Component => Blog, Displays all Blog posts, ajax to get POST API is triggered in AllPosts.vue, executed in Vuex store
const app2 = new Vue({
	store, //connect Vuex store, must-have
    el: '#app2'
});
*/


  
  
//Component => Div with Vue Login form 
const appLogin = new Vue({
	store, //connect Vuex store, must-have
	//router, //must-have for Vue routing
    el: '#vue-login'
});


//Component => Div with Vue Register form 
const appRegister = new Vue({
	store, //connect Vuex store, must-have
	//router, //must-have for Vue routing
    el: '#vueRegistrationRest'
});

