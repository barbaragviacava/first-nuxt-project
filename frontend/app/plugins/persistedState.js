import createPersistedState from 'vuex-persistedstate'
import config from '~/config/auth'

export default ({ store, isDev, $cookies }) => {
    createPersistedState({
        paths: [
            'auth',
            'app.flashMessage',
            'app.coreAdminPersistent',
        ],
        storage: {
            getItem: key => $cookies.get(key, {parseJSON : true}),
            setItem: (key, value) => {
                if (key !== '@@') {
                    $cookies.set(key, value, { maxAge: 60 * 60 * 24 * config.numberDaysToExpires, path: '/', secure: !isDev })
                }
            },
            removeItem: key => $cookies.remove(key)
        }
    })(store)
}
