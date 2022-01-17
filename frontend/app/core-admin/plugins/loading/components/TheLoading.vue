<template>
    <div v-show="isLoading" class="loading-screen" :style="{backgroundColor:bc}">
        <LoaderDefault />
    </div>
</template>

<script>
export default {
    props: {
        dark: {
            default: false,
            type: Boolean
        },
        background: {
            default: 'rgba(255,255,255,0.8)',
            type: String
        },
    },
    computed: {
        isLoading() {
            return this.$store.state.app.loading.isActive;
        },

        bc() {
            return this.dark ? 'rgba(0,0,0,0.8)' : this.background
        }
    }
}
</script>

<style scoped>
.loading-screen {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    width: 100vw;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 2000;
    flex-direction: column;
    user-select: none;
}
</style>
