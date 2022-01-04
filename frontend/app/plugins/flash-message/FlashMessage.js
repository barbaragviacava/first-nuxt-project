import { TYPE } from "vue-toastification";

export default class FlashMessage {

    constructor(store, toast) {
        this.store = store
        this.toast = toast
    }

    /**
     * @param {String} text
     * @param {String} type
     * @param {Object} options
     */
    append(text, type = TYPE.SUCCESS, options = {}) {

        const message = {
            text,
            type,
            options,
        }

        this.store.commit('app/flashMessage/append', message)
    }

    show() {
        const messages = this.store.state.app.flashMessage.messages

        messages.forEach((message) => {
            this.toast(message.text, {
                type: message.type,
                ...message.options
            })
        })

        if (messages && messages.length) {
            this.clear()
        }
    }

    clear() {
        this.store.commit('app/flashMessage/clear')
    }

}
