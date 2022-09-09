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
    countCategories()
    {
        return this.axios.$get(`${resource}/countCategories`)
    }

    /**
     * @returns {Promise}
     */
    countProducts()
    {
        return this.axios.$get(`${resource}/countProducts`)
    }
}
