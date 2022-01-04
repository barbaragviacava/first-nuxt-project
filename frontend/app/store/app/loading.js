export const state = () => ({
    isActive: false,
})

export const mutations = {
    start (state) {
        state.isActive = true
    },

    stop (state) {
        state.isActive = false
    },
}
