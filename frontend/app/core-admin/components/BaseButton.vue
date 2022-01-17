<template>
    <button class="btn" :disabled="loading" v-bind="$props" @click="handleClick">
        <slot></slot><LoaderBars v-if="loading" color="white" :size="18" class="ms-2" />
    </button>
</template>

<script>

export default {
    props: {
        loading: {
            default: false,
            type: Boolean,
        }
    },
    methods: {
        handleClick() {
            this.$emit('click')
        }
    }
}
</script>
