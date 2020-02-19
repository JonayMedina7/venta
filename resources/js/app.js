
require('./bootstrap');

window.Vue = require('vue');

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// 
// conponente de venta bodega...
// 
Vue.component('sale', require('./components/Sale.vue').default);


const app = new Vue({
    el: '#app',
});
