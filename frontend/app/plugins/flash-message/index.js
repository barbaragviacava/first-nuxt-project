import FlashMessage from './FlashMessage'

export default ({ store, $toast }, inject) => {
    inject('flashMessage', new FlashMessage(store, $toast))
}
