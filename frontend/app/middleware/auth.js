import authConfig from '~/config/auth'

export default function ({ $auth, redirect, route }) {
    if (route.name == 'login') {
        if ($auth.isAuthenticated()) {
            return redirect(authConfig.redirect.home)
        }
    } else if (!$auth.isAuthenticated()) {
        return redirect(authConfig.redirect.logout)
    }
}
