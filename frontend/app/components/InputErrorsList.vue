<template>
    <ul v-if="$validationHelper.hasFieldError(errors)" class="parsley-errors-list filled">
        <li v-for="(error, index) in errors" :key="index" class="parsley-type">{{$validationHelper.getFieldErrorMessage(error)}}</li>
    </ul>
</template>

<script>
export default {
    props: {
        errors: {
            required: false
        }
    }
}
</script>
