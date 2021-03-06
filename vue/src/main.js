import Vue from 'vue';
import VueRouter from 'vue-router';
import { sync } from 'vuex-router-sync';

import VueAnalytics from 'vue-analytics';
import BootstrapVue from 'bootstrap-vue';

import 'bootstrap-vue/dist/bootstrap-vue.css';

import './style.css';
import './font.css';

import store from './store';
import router from './router';
import i18n from './i18n';

import storeService from './services/storeService';

import CardsBrowser from './components/Cards/Browser';

Vue.config.productionTip = false;

Vue.use(BootstrapVue);
Vue.use(VueRouter);
Vue.use(VueAnalytics, {
  id: process.env.GA_TRACKING_ID,
  router,
});

sync(store, router);

storeService.load().then(() => {
  /* eslint-disable no-new */
  new Vue({
    el: '#app',
    router,
    i18n,
    components: {
      CardsBrowser,
    },
  });
});
