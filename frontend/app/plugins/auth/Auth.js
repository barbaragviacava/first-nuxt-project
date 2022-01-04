import { AUTH_MUTATIONS } from '~/store/auth'

import config from '~/config/auth'

export default class Auth {

    constructor(store, redirect) {
        this.store = store
        this.redirect = redirect
    }

    isAuthenticated() {
        return this.store.getters['auth/isAuthenticated']
    }

    getUser() {
        return this.store.state.auth.user
    }

    setUser(user) {
        this.#commit(AUTH_MUTATIONS.SET_USER, user)
    }

    async login(email, password) {

        const {access_token, refresh_token, user } = await this.store.dispatch('auth/login', { email, password })

        this.#commit(AUTH_MUTATIONS.SET_USER, user)
        this.#commit(AUTH_MUTATIONS.SET_PAYLOAD, { accessToken: access_token, refreshToken: refresh_token })

        return this.redirect(config.redirect.home)
    }

    async logout() {

        await this.store.dispatch('auth/logout')

        this.#commit(AUTH_MUTATIONS.LOGOUT)

        return this.redirect(config.redirect.logout)
    }

    async refresh() {

        const { data: { payload } } = await this.store.dispatch('auth/refresh')

        this.#commit(AUTH_MUTATIONS.SET_PAYLOAD, payload)
    }

    #commit(action, ...param) {
        this.store.commit(`auth/${action}`, ...param)
    }

}
