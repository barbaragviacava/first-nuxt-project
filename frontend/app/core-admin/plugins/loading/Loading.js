export default class Loading {

    constructor(store) {
        this.store = store
    }

    start() {
        this.store.commit('app/loading/start')
    }

    stop() {
        this.store.commit('app/loading/stop')
    }

    isActive() {
        return this.store.state.app.loading.isActive
    }

}
