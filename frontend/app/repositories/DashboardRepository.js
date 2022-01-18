const resource = '/api/dashboard'

export default class DashboardRepository
{
    /**
     * @param {Object|Function} axios
     */
    constructor(axios)
    {
        this.axios = axios
    }

    /**
     * @returns {Promise}
     */
    contarCategorias()
    {
        return this.axios.$get(`${resource}/contarCategorias`)
    }

    /**
     * @returns {Promise}
     */
    contarProdutos()
    {
        return this.axios.$get(`${resource}/contarProdutos`)
    }
}
