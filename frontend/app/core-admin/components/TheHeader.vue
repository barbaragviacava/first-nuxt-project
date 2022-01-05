<template>
	<div>

		<div id="header" class="app-header">

			<div class="navbar-header">
				<NuxtLink to="/" class="navbar-brand"><span class="navbar-logo"></span> <b>Core</b> Admin</NuxtLink>
                <button type="button" class="navbar-mobile-toggler" @click="toggleSidebarMobile">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<div class="navbar-nav">
				<b-nav-item-dropdown menu-class="dropdown-menu-end me-1" class="navbar-item navbar-user dropdown" toggle-class="navbar-link dropdown-toggle d-flex align-items-center" no-caret>
					<template slot="button-content">
                        <AvatarUser size="30px" :rounded="true" class="me-2" />
						<span v-if="$auth.isAuthenticated()">{{ $auth.getUser().name }}</span> <b class="caret"></b>
					</template>
                    <NuxtLink :to="{ name: 'usuario-perfil' }" class="dropdown-item">Perfil</NuxtLink>
					<a href="javascript:;" class="dropdown-item" @click="logout">Sair</a>
				</b-nav-item-dropdown>
			</div>
		</div>
	</div>
</template>

<script>
export default {
    methods: {
        logout() {
            try {

                this.$auth.logout()

            } catch (errors) {

                const errorResponse = this.$errorHandler.setAndParse(errors)

                this.$nuxt.error({ statusCode: errorResponse.status, message: errorResponse.message })
            }
        },

        toggleSidebarMobile() {
            this.$store.commit('app/coreAdmin/showSidebarMobile')
        }
    }
}
</script>
