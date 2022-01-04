import createPersistedState from 'vuex-persistedstate'
import * as Cookies from 'js-cookie'
import cookie from 'cookie'
import config from '~/config/auth'

export default ({ store, req, res, isDev }) => {
    createPersistedState({
        paths: [
            'app.flashMessage',
            'app.coreAdminPersistent',
            'auth',
        ],
        storage: {
            getItem: key => process.client ? Cookies.get(key) : cookie.parse(req.headers.cookie || '')[key],
            setItem: (key, value) => {
                if (key !== '@@') {

                    if (process.client) {
                        Cookies.set(key, value, { expires: config.numberDaysToExpires, secure: !isDev })
                    } else {
                        res.setHeader('Set-Cookie', cookie.serialize(key, value, { maxAge: 60 * 60 * 24 * config.numberDaysToExpires, secure: !isDev }))
                    }
                }
            },
            removeItem: key => Cookies.remove(key)
        }
    })(store)
}
