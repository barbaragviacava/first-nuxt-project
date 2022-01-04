<template>
	<!-- menu with submenu -->
	<div v-if="menu.children" class="menu-item has-sub" :class="{ 'active': subIsActive(menu.path), 'expand': stat =='expand', 'd-none': stat =='hide' }">
		<a href="#" class="menu-link" @click.prevent.stop="expand($event)">
			<div v-if="menu.icon" class="menu-icon"><i :class="menu.icon"></i></div>
			<div v-if="menu.img" class="menu-icon-img"><img :src="menu.img" alt="" /></div>
			<div class="menu-text">
				{{ menu.title }}
				<span v-if="menu.label" class="menu-label">{{ menu.label }}</span>
				<i v-if="menu.highlight" class="fa fa-paper-plane text-theme"></i>
			</div>
			<div v-if="menu.badge" class="menu-badge">{{ menu.badge }}</div>
			<div v-else class="menu-caret"></div>
		</a>
		<div class="menu-submenu" :class="{ 'd-block': stat == 'expand', 'd-none': stat == 'collapse' }">
			<template v-for="submenu in menu.children">
				<TheSidebarNavList :key="submenu.path" ref="sidebarNavList" :menu="submenu" @collapse-other="handleCollapseOther(submenu)"></TheSidebarNavList>
			</template>
		</div>
	</div>

	<!-- menu without submenu -->
	<NuxtLink v-else :to="menu.path" class="menu-item" :class="{ 'd-none': stat =='hide' }" :title="menu.title" active-class="active" tag="div" @click.native="collapseOther()">
		<a class="menu-link">
			<div v-if="menu.icon" class="menu-icon"><fa v-if="menu.icon" :icon="menu.icon" /></div>
			<div v-if="menu.img" class="menu-icon-img"><img :src="menu.img" alt="" /></div>
			<div class="menu-text">
				{{ menu.title }}
				<span v-if="menu.label" class="menu-label">{{ menu.label }}</span>
				<i v-if="menu.highlight" class="fa fa-paper-plane text-theme"></i>
			</div>
			<div v-if="menu.badge" class="menu-badge">{{ menu.badge }}</div>
		</a>
	</NuxtLink>
</template>

<script>
export default {
	props: ['menu', 'scrollTop'],
	data() {
		return {
			stat: ''
		}
	},
	methods: {
		expand () {
			if (this.stat == '') {
				this.stat = (this.subIsActive(this.menu.path)) ? 'collapse' : 'expand';
			} else {
				this.stat = (this.stat == 'expand') ? 'collapse' : 'expand'
			}
			this.$emit('collapse-other', this.menu);
		},
		collapse (menu) {
			if (this.menu !== menu) {
				this.stat = 'collapse'
			}
		},
		hide () {
			this.stat = 'hide'
		},
		show () {
			this.stat = '';
		},
		searchExpand () {
			this.stat = 'expand'
		},
		collapseOther () {
			this.$emit('collapse-other', this.menu)
		},
		handleCollapseOther (menu) {
			for (let i = 0; i < this.menu.children.length; i++) {
				this.$refs.sidebarNavList[i].collapse(menu);
			}
		},
		subIsActive(path) {
			const paths = Array.isArray(path) ? path : [path]
			return paths.some(path => {
				return this.$route.path.indexOf(path) === 0
			})
		}
  }
}
</script>
