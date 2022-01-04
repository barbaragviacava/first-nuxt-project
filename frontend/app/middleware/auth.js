import authConfig from '~/config/auth'

export default function ({ $auth, redirect, route, req }) {
    if (route.name == 'login') {
        if ($auth.isAuthenticated()) {
            return redirect(authConfig.redirect.home)
        }
    } else if (!$auth.isAuthenticated()) {
        console.log('middleware cookies', req.headers.cookie)
        return redirect(authConfig.redirect.logout)
    }
}
