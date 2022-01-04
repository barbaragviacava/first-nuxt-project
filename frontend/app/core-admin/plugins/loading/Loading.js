export default class Loading {

    constructor(store) {
        this.store = store
    }

    start() {
        this.store.commit('app/loading/start')
        this.#startNuxtLoading()
    }

    stop() {
        this.store.commit('app/loading/stop')
        this.#stopNuxtLoading()
    }

    isActive() {
        return this.store.state.app.loading.isActive
    }

    #startNuxtLoading() {
        if (!this.store._vm || !this.store._vm.$nuxt || !this.store._vm.$nuxt.$loading) {
            return;
        }
        return this.store._vm.$nuxt.$loading.start();
    }

    #stopNuxtLoading() {
        if (!this.store._vm || !this.store._vm.$nuxt || !this.store._vm.$nuxt.$loading) {
            return;
        }
        return this.store._vm.$nuxt.$loading.finish();
    }

}
