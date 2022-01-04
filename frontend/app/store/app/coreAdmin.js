export const state = () => ({
    sidebarMobile: false
})

export const mutations = {

    showSidebarMobile(state) {
        state.sidebarMobile = true
    },

    hideSidebarMobile(state) {
        state.sidebarMobile = false
    }

}
