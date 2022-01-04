const resource = '/api/usuarios'

export default ($axios) => ({
    update(payload) {
        return $axios.$put(`${resource}`, payload)
    },

    avatar(payload) {
        return $axios.$post(`${resource}/avatar`, payload)
    },
})
