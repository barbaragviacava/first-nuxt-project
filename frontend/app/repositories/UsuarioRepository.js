const resource = '/api/usuarios'

export default class UsuarioRepository
{
    /**
     * @param {Object|Function} axios
     */
    constructor(axios)
    {
        this.axios = axios
    }

    /**
     * @param {*} payload
     * @returns {Promise}
     */
    update(payload)
    {
        return this.axios.$put(`${resource}`, payload)
    }

    /**
     * @param {*} payload
     * @returns {Promise}
     */
    avatar(payload)
    {
        return this.axios.$post(`${resource}/avatar`, payload)
    }
}
