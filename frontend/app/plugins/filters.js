import Vue from 'vue'

Vue.filter('YesNo', function (value) {
    if (value) {
        return 'Sim'
    }
    return 'Não'
})
