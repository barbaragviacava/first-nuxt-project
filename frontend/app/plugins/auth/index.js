import Auth from './Auth'

export default ({ store, redirect }, inject) => {
    inject('auth', new Auth(store, redirect))
}
