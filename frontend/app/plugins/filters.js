import Vue from 'vue'

export default ({ app }) => {

  Vue.filter('YesNo', function (value) {
    if (value) {
        return app.i18n.t('plugins.filters.yes')
    }
    return app.i18n.t('plugins.filters.no')
  })

  Vue.filter('lower', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.toLowerCase()
  })
}
