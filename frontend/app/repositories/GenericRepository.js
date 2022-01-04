const proxy = '/api'

export default $axios => resource => ({
    list(payload) {
        return $axios.$get(`${proxy + '/' + resource}`, { params: payload })
    },

    show(id) {
        return $axios.$get(`${proxy + '/' + resource}/${id}`)
    },

    create(payload) {
        return $axios.$post(`${proxy + '/' + resource}`, payload)
    },

    update(id, payload) {
        return $axios.$put(`${proxy + '/' + resource}/${id}`, payload)
    },

    delete(id) {
        return $axios.$delete(`${proxy + '/' + resource}/${id}`)
    }
})
