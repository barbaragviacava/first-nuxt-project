const resource = '/api/auth'

export const loginUrl = `${resource}/login`
export const logoutUrl = `${resource}/logout`
export const refreshUrl = `${resource}/refresh`

export default ($axios) => ({
    login(payload) {
        return $axios.$post(`${loginUrl}`, payload)
    },

    logout() {
        return $axios.$post(`${logoutUrl}`)
    },

    refresh(payload) {
        return $axios.$post(`${refreshUrl}`, payload)
    }
})
