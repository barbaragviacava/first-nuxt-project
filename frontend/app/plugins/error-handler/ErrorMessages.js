/**
 * Baseado no Error Handler do projeto @zaengle/error-handler (https://github.com/zaengle/error-handler)
 */

export const defaultGeneralErrorMessage = 'Ixi! Você descobriu um problema que a nossa equipe precisa investigar. Por favor, informe o nosso suporte sobre o ocorrido.';

export const defaultIcon = 'error';

export const defaultErrorMessages = {
    401: { defaultMessage: `Você precisa estar logado para acessar esta funcionalidade.`, ignoreServerMessage: false, icon: 'warning' },
    403: { defaultMessage: `Você não possui permissão para utilizar esta funcionalidade.`, ignoreServerMessage: false, icon: 'warning' },
    404: { defaultMessage: `Não conseguimos encontrar a funcionalidade que você tentou acessar. Por favor, tente novamente ou entre em contato com a nossa equipe.`, ignoreServerMessage: false, icon: 'error' },
    422: { defaultMessage: 'Erro na validação', ignoreServerMessage: false, icon: 'warning' },
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
