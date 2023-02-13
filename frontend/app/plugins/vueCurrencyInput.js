import Vue from 'vue'
import VueCurrencyInput from 'vue-currency-input'

export default () => {

  const pluginOptions = {
      globalOptions: {
          autoDecimalMode: true
      }
  }
  Vue.use(VueCurrencyInput, pluginOptions)

}
