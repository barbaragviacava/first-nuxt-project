
export default class ValidationHelper {

    /**
     * @param {Object} validationStatus
     */
    flatErrorsList(validationStatus) {
        return Object.values(validationStatus.errors).flat();
    }

    /**
     * @param {Object | null} fieldError
     * @returns {Boolean}
     */
    hasFieldError(fieldError) {
        return fieldError && (typeof fieldError == 'string' || fieldError.message || fieldError[0]);
    }

    /**
     * @param {Object | null} fieldError
     * @returns {String}
     */
    getFieldErrorMessage(fieldError) {
        if (!this.hasFieldError(fieldError)) {
            return '';
        }
        if (typeof fieldError == 'string') {
            return fieldError;
        }
        if (typeof fieldError.message == 'string') {
            return fieldError.message;
        }
        if (typeof fieldError[0] == 'string') {
            return fieldError[0];
        }
        return fieldError[0].message;
    }
}
