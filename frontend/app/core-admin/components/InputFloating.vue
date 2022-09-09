<template>
    <div class="form-floating">
        <input class="form-control" :value="value" :class="inputClasses" v-bind="inputProps" @input="$emit('input', $event.target.value)">
        <label for="floatingInput" class="d-flex align-items-center fs-13px">
            {{label}}
        </label>
    </div>
</template>

<script>
export default {
    props: {
        label: {
            type: String,
            default: '',
            required: true
        },
        value: {
            default: null
        },
        type: {
            type: String,
            default: 'text',
            required: false
        },
        inputClasses: {
            required: false
        },
        maxlength: {
            required: false
        }
    },
    computed: {
        inputProps() {
            const {label, inputClasses, ...inputProps } = this.$props

            return inputProps
        }
    }
}
</script>
