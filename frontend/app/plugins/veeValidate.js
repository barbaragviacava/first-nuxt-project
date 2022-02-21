import { extend, configure } from 'vee-validate';
import { required, email } from 'vee-validate/dist/rules';

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
            messageWithField: `O valor do campo ${fieldName} precisa ser maior do que zero`,
            message: 'O valor deste campo precisa ser maior do que zero'
        };
    }
});

extend('required', {
    ...required,
    message: (fieldName, placeholders) => {
        return {
            fieldName,
            placeholders,
            messageWithField: `O campo ${fieldName} é obrigatório`,
            message: 'Este campo é obrigatório'
        };
    }
});

extend('email', {
    ...email,
    message: (fieldName, placeholders) => {
        return {
            fieldName,
            placeholders,
            messageWithField: `O campo ${fieldName} precisa conter um e-mail válido`,
            message: 'O E-mail informado é inválido.'
        };
    }
});
