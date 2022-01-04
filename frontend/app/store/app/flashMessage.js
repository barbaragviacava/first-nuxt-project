export const state = () => ({
    messages: []
})

export const mutations = {

    append(state, message) {
        state.messages.push(message)
    },

    clear(state) {
        state.messages = []
    }

}
