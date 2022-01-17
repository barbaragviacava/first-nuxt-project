<template>
    <LoaderBars v-bind="$props" />
</template>

<script>
export default {
    props: {
        color: {
            default: 'var(--bs-primary)',
            type: String
        },
        size: {
            default: 15,
            type: Number
        }
    }
}
</script>
