import Vue from 'vue'
import Vuex from 'vuex'
import marketproduct from './modules/marketproduct/'

Vue.use(Vuex)

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation
 */
export default function (/* { ssrContext } */) {
  return new Vuex.Store({
    modules: {
      marketproduct
    },

    // enable strict mode (adds overhead!)
    // for dev mode only
    strict: process.env.DEV
  })
}
