import Loading from './Loading'

export default ({ store }, inject) => {
    inject('coreLoading', new Loading(store))
}
