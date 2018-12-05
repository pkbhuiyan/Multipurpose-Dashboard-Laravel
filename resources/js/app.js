import './bootstrap';

// import Vue from 'vue'
window.Vue = require('vue');

import moment from 'moment'
import swal from 'sweetalert2'
import VueRouter from 'vue-router'
import VueProgressBar from 'vue-progressbar'


import Gate from './Gate';
Vue.prototype.$gate = new Gate(window.user);


Vue.use(VueRouter)
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '4px',
    transition: {
        speed: '0.7s',
        opacity: '0.6s',
        termination: 900
    }

})

// Sweet alert

window.swal = swal

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast


// reload the state with updated user with axios
window.Fire = new Vue()
Fire.$on('AfterAction', () => {
    this.loadUser()
    console.log("Fire load");

})

// reload webpage after click
window.Reload = new Vue()
Reload.$on('AfterSubmit', () => {
    setTimeout(function () { window.location.reload(); }, 10)
    console.log("Reload");
})

// component declaration
//  use it in laravel
let Myheader = require('./components/Myheader.vue');
let Myfooter = require('./components/Myfooter.vue');
// let Pagination = require('./components/Pagination.vue');


let Dashboard = require('./components/Dashboard.vue')
let Home = require('./components/Home.vue')
let Profile = require('./components/Profile.vue')
let User = require('./components/User.vue')
let AdminOrderList = require('./components/AdminOrderList.vue')
let UserCreateOrder = require('./components/UserCreateOrder.vue')

// Routes declaration and registration

const routes = [
    {path:'/dashboard',component: Dashboard},
    {path:'/home',component: Home},
    {path:'/profile',component: Profile},
    {path:'/user',component: User},
    { path: '/orders', component: AdminOrderList},
    { path: '/create-order', component: UserCreateOrder},
];

const router = new VueRouter({
    mode: 'history',
    routes,
    linkActiveClass: 'active',
    
});

// Vue filter for capitalize and time-format

Vue.filter('capitalize',function(value){
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
})

Vue.filter('time-format',function(create){
    return moment(create).format('MMMM Do YYYY');
})


//  example component
//  use it in vue

Vue.component('home', require('./components/Home.vue'));
Vue.component('pagination', require('./components/Pagination.vue'));
Vue.component('not-found', require('./components/NotFound.vue'));


// app registration

const app = new Vue({
    el: '#app',
    router,
    components: { Myheader, Myfooter },
    
});
