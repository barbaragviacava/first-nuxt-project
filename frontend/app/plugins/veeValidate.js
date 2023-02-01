import { extend, configure } from 'vee-validate';
import { required, email } from 'vee-validate/dist/rules';

export default function ({i18n}) {

  configure({
    classes: {
      valid: 'parsley-success',
      invalid: 'parsley-error',
    }
  })

  extend('gt_zero', {
    validate(value) {
      return value > 0;
    },
    message: (fieldName, placeholders) => {
      return {
        fieldName,
        placeholders,
        messageWithField: i18n.t('plugins.veeValidate.gtZero.messageWithField', {field_name: fieldName}),
        message: i18n.t('plugins.veeValidate.gtZero.message')
      };
    }
  });

  extend('required', {
    ...required,
    message: (fieldName, placeholders) => {
      return {
        fieldName,
        placeholders,
        messageWithField: i18n.t('plugins.veeValidate.required.messageWithField', {field_name: fieldName}),
        message: i18n.t('plugins.veeValidate.required.message')
      };
    }
  });

  extend('email', {
    ...email,
    message: (fieldName, placeholders) => {
      return {
        fieldName,
        placeholders,
        messageWithField: i18n.t('plugins.veeValidate.email.messageWithField', {field_name: fieldName}),
        message: i18n.t('plugins.veeValidate.email.message')
      };
    }
  });
}
