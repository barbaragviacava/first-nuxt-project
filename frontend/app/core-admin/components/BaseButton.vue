<template>
    <button class="btn" :disabled="loading" v-bind="$props" @click="handleClick">
        <slot v-if="!loading"></slot>
        <BaseLoading v-else color="white" :size="10" />
    </button>
</template>

<script>

import BaseLoading from './BaseLoading'

export default {
    components: {
        BaseLoading,
    },
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
