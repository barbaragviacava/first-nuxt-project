const resource = '/api/dashboard'

export default ($axios) => ({

    contarCategorias() {
        return $axios.$get(`${resource}/contarCategorias`)
    },

    contarProdutos() {
        return $axios.$get(`${resource}/contarProdutos`)
    }
})
