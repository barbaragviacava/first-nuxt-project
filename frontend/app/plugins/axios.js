import { TYPE } from "vue-toastification";
import { loginUrl, logoutUrl, refreshUrl } from "~/repositories/AuthRepository"

export default function (ctx) {

  const { $axios, store, $coreLoading, $errorHandler, $auth, i18n } = ctx

  const ignoredPaths = [
    loginUrl,
    logoutUrl,
    refreshUrl
  ]

  function logout() {
    ctx.$flashMessage.append(i18n.t('plugins.axios.sessionExpiredAlert'), TYPE.WARNING)

    return $auth.logout()
  }

  $axios.onRequest((config) => {
    store.commit('axios/pendingRequestCounter/increase')

    $coreLoading.start()

    if ($auth.isAuthenticated()) {
      config.headers.Authorization = 'Bearer ' + store.state.auth.accessToken
    }

    return config
  })
  $axios.onResponse(() => {
    store.commit('axios/pendingRequestCounter/decrease')

    if (store.state.axios.pendingRequestCounter.counter == 0) {
      $coreLoading.stop()
    }
  })
  $axios.onError((error) => {
    store.commit('axios/pendingRequestCounter/decrease')

    if (store.state.axios.pendingRequestCounter.counter == 0) {
      $coreLoading.stop()
    }

    return new Promise((resolve, reject) => {

      const isIgnored = ignoredPaths.some(path => error.config.url.includes(path))

      const errorResponse = $errorHandler.setAndParse(error)

      if (errorResponse.status === 401 && !isIgnored) {

        const { data: { text_code } = { text_code: null } } = error.response || {}

        const refreshToken = store.state.auth.refreshToken

        if (text_code === 'UNAUTHENTICATED' && refreshToken) {

          if (error.config.retryAttempts !== undefined) {

            return logout()

          } else {

            const config = { retryAttempts: 1, ...error.config }

            try {

              $auth.refresh()

              return resolve($axios(config))

            } catch (e) {

              return logout()
            }
          }
        } else if (text_code === 'UNAUTHENTICATED') {

          return logout()
        }
      }

      return reject(error)
    })
  })
}
