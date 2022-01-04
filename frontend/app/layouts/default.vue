<template>
    <div>
        <div
            class="app app-header-fixed app-sidebar-fixed"
            :class="{
                'app-sidebar-mobile-toggled': showSidebarMobile,
                'app-sidebar-minified': sidebarMinified,
            }"
        >
            <TheHeader />
            <TheSidebar />
            <div id="content" class="app-content" :style="cssVars">
                <Nuxt />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    middleware: ['auth'],
    data() {
        return {
            contentImage: null
        }
    },
    computed: {
        showSidebarMobile() {
            return this.$store.state.app.coreAdmin.sidebarMobile
        },
        sidebarMinified() {
            return this.$store.state.app.coreAdminPersistent.sidebarMini
        },
        cssVars() {
            return {
                '--background-image': (this.contentImage ? `var(${this.contentImage})` : 'none')
            }
        }
    },
    watch: {
        $route () {
            this.contentImage = null
            this.$store.commit('app/coreAdmin/hideSidebarMobile')
        }
    },
    created() {
        this.$nuxt.$on('load-content-image', ($payload) => { this.contentImage = $payload })
    }
}
</script>

<style scoped>
    #content {
        min-height: 100vh;
        background-image: var(--background-image);
        background-attachment: fixed;
        background-repeat: no-repeat;
        background-size: 360px;
        background-position: right bottom;
    }
</style>
