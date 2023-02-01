import Vue from 'vue'
import VueCurrencyInput from 'vue-currency-input'

export default ({ app }) => {

  const pluginOptions = {
      globalOptions: {
          currency: app.i18n.localeProperties.currency,
          allowNegative: false,
          autoDecimalMode: true
      }
  }
  Vue.use(VueCurrencyInput, pluginOptions)

}
