const resource = '/api/auth'

export const loginUrl = `${resource}/login`
export const logoutUrl = `${resource}/logout`
export const refreshUrl = `${resource}/refresh`

export default class AuthRepository
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
    login(payload)
    {
        return this.axios.$post(`${loginUrl}`, payload)
    }

    /**
     * @returns {Promise}
     */
    logout()
    {
        return this.axios.$post(`${logoutUrl}`)
    }

    /**
     * @param {*} payload
     * @returns {Promise}
     */
    refresh(payload)
    {
        return this.axios.$post(`${refreshUrl}`, payload)
    }
}

