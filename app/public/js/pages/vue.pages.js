import Vue from 'vue';
import VueTest from '../../vue/index.vue';

window.onload = () => {
  new Vue(VueTest).$mount('#root')
}