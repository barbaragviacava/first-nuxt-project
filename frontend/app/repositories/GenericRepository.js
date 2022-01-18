const proxy = '/api'

export default class GenericRepository
{
    /**
     * @param {Object|Function} axios
     * @param {String} resource
     */
    constructor(axios, resource)
    {
        this.axios = axios
        this.resource = resource
    }

    /**
     * @param {*} payload
     * @returns {Promise}
     */
    list(payload)
    {
        return this.axios.$get(`${proxy + '/' + this.resource}`, { params: payload })
    }

    /**
     * @param {Number} id
     * @returns {Promise}
     */
    show(id)
    {
        return this.axios.$get(`${proxy + '/' + this.resource}/${id}`)
    }

    /**
     * @param {*} payload
     * @returns {Promise}
     */
    create(payload)
    {
        return this.axios.$post(`${proxy + '/' + this.resource}`, payload)
    }

    /**
     * @param {Number} id
     * @param {*} payload
     * @returns {Promise}
     */
    update(id, payload)
    {
        return this.axios.$put(`${proxy + '/' + this.resource}/${id}`, payload)
    }

    /**
     * @param {Number} id
     * @returns {Promise}
     */
    delete(id)
    {
        return this.axios.$delete(`${proxy + '/' + this.resource}/${id}`)
    }

    /**
     * @param {Number} id
     * @returns {Promise}
     */
    toggleActive(id)
    {
        return this.axios.$put(`${proxy + '/' + this.resource}/toggleActive/${id}`)
    }
}
