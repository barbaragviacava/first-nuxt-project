<template>
	<div>

		<div id="header" class="app-header">

			<div class="navbar-header">
				<NuxtLink :to="localePath({ name: 'dashboard' })" class="navbar-brand"><span class="navbar-logo"></span> <b>Core</b> Admin</NuxtLink>
          <button type="button" class="navbar-mobile-toggler" @click="toggleSidebarMobile">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<div class="navbar-nav">
				<b-nav-item-dropdown v-if="$i18n && $i18n.locales" menu-class="dropdown-menu-end me-1" class="navbar-item navbar-user dropdown" toggle-class="navbar-link dropdown-toggle d-flex align-items-center" no-caret>
					<template slot="button-content">
            <span :class="['flag-icon', 'flag-icon-' + $i18n.localeProperties.icon, 'me-2']" :title="$i18n.localeProperties.name"></span> <b class="caret"></b>
					</template>
          <b-dropdown-item v-for="lang in $i18n.locales" :key="lang.code" :to="switchLocalePath(lang.code)">
            <span :class="['flag-icon', 'flag-icon-' + lang.icon, 'me-2']" :title="lang.name"></span> {{ lang.name }}
          </b-dropdown-item>
				</b-nav-item-dropdown>

				<b-nav-item-dropdown menu-class="dropdown-menu-end me-1" class="navbar-item navbar-user dropdown" toggle-class="navbar-link dropdown-toggle d-flex align-items-center" no-caret>
					<template slot="button-content">
            <AvatarUser size="30px" :rounded="true" class="me-2" />
						<span v-if="$auth.isAuthenticated()" class="header-user-name">{{ $auth.getUser().name }}</span> <b class="caret"></b>
					</template>
          <NuxtLink v-for="menu in userMenu" :key="menu.name" :to="localePath({ name: menu.name })" class="dropdown-item">{{ $t(menu.title) }}</NuxtLink>
				</b-nav-item-dropdown>
			</div>
		</div>
	</div>
</template>

<script>
import UserMenu from './the-header/UserMenu.vue'

export default {
	data () {
		return {
			userMenu: UserMenu
		}
	},
    methods: {
        toggleSidebarMobile() {
            this.$store.commit('app/coreAdmin/showSidebarMobile')
        }
    }
}
</script>
