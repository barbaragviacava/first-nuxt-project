export const state = () => ({
    sidebarMini: false
})

export const mutations = {

    toggleSidebarMini(state) {
        state.sidebarMini = !state.sidebarMini
    }

}
