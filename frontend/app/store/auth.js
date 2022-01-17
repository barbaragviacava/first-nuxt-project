export const AUTH_MUTATIONS = {
    SET_USER: 'SET_USER',
    SET_PAYLOAD: 'SET_PAYLOAD',
    LOGOUT: 'LOGOUT',
}

const initialState = {
    accessToken: null,
    refreshToken: null,
    user: {}
}

export const state = () => (initialState)

export const mutations = {

    [AUTH_MUTATIONS.SET_USER] (
        state, {
            id = state.user.id,
            email = state.user.email,
            name = state.user.name,
            avatar = state.user.avatar
        }
    ) {
        state.user = { id, email, name, avatar }
    },

    [AUTH_MUTATIONS.SET_PAYLOAD] (state, { accessToken, refreshToken = null }) {
        state.accessToken = accessToken

        if (refreshToken) {
            state.refreshToken = refreshToken
        }
    },

    [AUTH_MUTATIONS.LOGOUT] (state) {
        state.accessToken = null
        state.refreshToken = null
        state.user = {}
    },
}

export const actions = {

    login (context, payload) {
        return this.$repository.auth.login(payload)
    },

    refresh ({ state }) {
        const { refreshToken } = state

        if (refreshToken) {
            return new Promise()
        }

        return this.$repository.auth.refresh({ refreshToken })
    },

    logout () {
        return this.$repository.auth.logout()
    },
}

export const getters = {
    isAuthenticated: (state) => {
        return state.accessToken != null
    },
}
