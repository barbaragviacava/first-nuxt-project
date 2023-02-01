/**
 * Baseado no Error Handler do projeto @zaengle/error-handler (https://github.com/zaengle/error-handler)
 */

export const defaultGeneralErrorMessage = 'plugins.errorHandler.errorMessages.defaultGeneralErrorMessage';

export const defaultIcon = 'error';

export const defaultErrorMessages = {
  401: { defaultMessage: 'plugins.errorHandler.errorMessages.401', ignoreServerMessage: false, icon: 'warning' },
  403: { defaultMessage: 'plugins.errorHandler.errorMessages.403', ignoreServerMessage: false, icon: 'warning' },
  404: { defaultMessage: 'plugins.errorHandler.errorMessages.404', ignoreServerMessage: false, icon: 'error' },
  422: { defaultMessage: 'plugins.errorHandler.errorMessages.422', ignoreServerMessage: false, icon: 'warning' },
  500: { defaultMessage: defaultGeneralErrorMessage, ignoreServerMessage: false, icon: 'error' },
}

export default class ErrorMessages {

  constructor(errorMessages, generalErrorMessage, icon) {
    this.errorMessages = errorMessages || defaultErrorMessages
    this.generalErrorMessage = generalErrorMessage || defaultGeneralErrorMessage
    this.defaultIcon = icon || defaultIcon
  }

  /**
   * Retrieve the error message for a particular status code.
   *
   * @param {number} errorStatus
   * @return {string} errorMessage
   */
  getErrorMessage(errorStatus) {
    if (errorStatus && this.errorMessages[errorStatus]) {
      return this.errorMessages[errorStatus].defaultMessage
    }

    return this.generalErrorMessage
  }

  getIcon(errorStatus) {
    if (errorStatus && this.errorMessages[errorStatus]) {
      return this.errorMessages[errorStatus].getIcon
    }

    return this.icon
  }
}
