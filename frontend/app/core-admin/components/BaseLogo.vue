<template>
    <div class="brand">
        <div class="d-flex align-items-center">
            <span class="logo"></span> <b>Core</b> Admin
        </div>
        <small v-if="slogan">{{ $t('coreAdmin.components.baseLogo.slogan') }}</small>
    </div>
</template>

<script>
export default {
    props: {
        slogan: {
            default: false,
            type: Boolean,
            required: false
        }
    }
}
</script>
