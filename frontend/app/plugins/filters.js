import Vue from 'vue'

Vue.filter('YesNo', function (value) {
    if (value) {
        return 'Sim'
    }
    return 'Não'
})

Vue.filter('lower', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.toLowerCase()
})
