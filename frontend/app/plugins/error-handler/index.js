import ErrorHandler from './ErrorHandler'

export default (context, inject) => {
    inject('errorHandler', new ErrorHandler(null, '', context.isDev))
}
