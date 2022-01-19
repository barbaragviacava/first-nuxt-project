export default {
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    titleTemplate(subtitle) {
        return subtitle ? `Core Admin - ${subtitle}` : 'Core Admin'
    },
    htmlAttrs: {
      lang: 'pt-br'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' }
    ]
  },

  router: {
    middleware: 'client-side/runPlugins'
  },

  publicRuntimeConfig: {
    axios: {
      browserBaseURL: process.env.BROWSER_BASE_URL
    }
  },

  privateRuntimeConfig: {
    axios: {
      baseURL: process.env.API_URL
    }
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    '~/assets/vue.scss',
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
      { src: '~/core-admin/plugins/vue-custom-scrollbar' },
      { src: '~/core-admin/plugins/loading/index' },
      { src: '~/plugins/persistedState' },
      { src: '~/plugins/auth/index' },
      { src: '~/plugins/error-handler/index' },
      { src: '~/plugins/flash-message/index' },
      { src: '~/plugins/axios' },
      { src: '~/plugins/veeValidate' },
      { src: '~/plugins/validation-helper/index' },
      { src: '~/plugins/repositoriesRegister' },
      { src: '~/plugins/filters' },
      { src: '~/plugins/vueSelect' },

      // client
      { src: '~/plugins/runClientEveryPage', mode: 'client' },
      { src: '~/plugins/vueAdvancedCropper', mode: 'client' },
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: [
    '~/components',
    { path: '~/core-admin/components', level: 1 }
  ],

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/eslint
    '@nuxtjs/eslint-module',
    '@nuxtjs/fontawesome',
  ],

  fontawesome: {
    component: 'fa',
    icons: {
      solid: true,
      regular: true
    }
  },

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/bootstrap
    'bootstrap-vue/nuxt',
    // https://www.npmjs.com/package/@nuxtjs/proxy
    '@nuxtjs/proxy',
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/axios',
    // https://www.npmjs.com/package/vue-sweetalert2
    'vue-sweetalert2/nuxt',
    // https://www.npmjs.com/package/vue-toastification
    "vue-toastification/nuxt",
    // https://www.npmjs.com/package/cookie-universal-nuxt
    'cookie-universal-nuxt',
  ],

  bootstrapVue: {
    config: {
      'BTable' : {
        'tableClass': 'table-row-dashed align-middle fsuper',
        'sortIconLeft': true,
        'noLocalSorting': true,
        'showEmpty': true,
        'emptyText': 'Não há nenhum dado para ser exibido',
        'emptyFilteredText': 'Não foi encontrado nenhum resultado para a busca realizada',
      },
      'BPagination': {
        'align': 'fill',
        'firstText': 'Primeira',
        'prevText': 'Anterior',
        'nextText': 'Próxima',
        'lastText': 'Última',
      }
    }
  },

  proxy: {
    "/api/": {
        target: process.env.API_URL,
    },
  },

  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
    credentials: true,
    proxy: true,
  },

  loading: {
    color: 'var(--bs-primary)',
    failedColor: 'var(--bs-warning)'
  },

  layoutTransition: {
    name: 'layout',
    mode: 'out-in'
  },

  pageTransition: {
    name: 'page',
    mode: 'out-in',
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
    transpile: ["vee-validate/dist/rules"],
  }
}
