import Vue from 'vue'
import VueCurrencyInput from 'vue-currency-input'

const pluginOptions = {
    globalOptions: {
        currency: 'BRL',
        allowNegative: false,
        autoDecimalMode: true
    }
}
Vue.use(VueCurrencyInput, pluginOptions)
