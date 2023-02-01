import Auth from './Auth'

export default ({ store, redirect, localePath }, inject) => {
  inject('auth', new Auth(store, (path) => redirect(localePath(path))))
}
