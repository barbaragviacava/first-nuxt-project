import Vue from 'vue'

import Loading from './Loading'

import TheLoading from './components/TheLoading'

Vue.component('TheLoading', TheLoading)

export default ({ store }, inject) => {
    inject('coreLoading', new Loading(store))
}
