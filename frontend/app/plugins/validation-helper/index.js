import ValidationHelper from './ValidationHelper'

export default (context, inject) => {
    inject('validationHelper', new ValidationHelper())
}
