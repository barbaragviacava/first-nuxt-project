import authConfig from '~/config/auth'

export default function ({ $auth, redirect, route, localePath }) {
    if (route.name && route.name.includes('login')) {
        if ($auth.isAuthenticated()) {
            return redirect(localePath({ name: authConfig.redirect.home}))
        }
    } else if (!$auth.isAuthenticated()) {
        return redirect(localePath({ name: authConfig.redirect.logout}))
    }
}
