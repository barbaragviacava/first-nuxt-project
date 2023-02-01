<template>
    <!-- begin sidebar nav -->
    <div v-if="menus" class="menu">
      <div class="menu-header"></div>
      <template v-for="menu in menus">
        <TheSidebarNavList
            ref="sidebarNavList"
            :key="menu.name"
            :menu="menu"
            :scroll-top="scrollTop"
            :status="menu.status"
            @collapse-other="handleCollapseOther(menu)"
            @show-float-submenu="handleShowFloatSubmenu"
            @hide-float-submenu="handleHideFloatSubmenu"></TheSidebarNavList>
      </template>

      <div class="menu-item d-flex">
        <a href="javascript:;" class="app-sidebar-minify-btn ms-auto" @click="handleSidebarMinify()">
            <fa :icon="sidebarMinified ? 'angle-double-right' : 'angle-double-left'"/>
        </a>
      </div>
    </div>
    <!-- end sidebar nav -->
</template>

<script>
import SidebarMenu from './Menu.vue'

export default {
	props: ['scrollTop'],
	data () {
		return {
			menus: SidebarMenu
		}
	},
  computed: {
      sidebarMinified() {
          return this.$store.state.app.coreAdminPersistent.sidebarMini
      }
  },
	methods: {
		handleShowFloatSubmenu (menu, offset) {
			this.$emit('show-float-submenu', menu, offset);
		},
		handleHideFloatSubmenu () {
			this.$emit('hide-float-submenu');
		},
		handleCollapseOther (menu) {
			for (let i = 0; i < this.menus.length; i++) {
				this.$refs.sidebarNavList[i].collapse(menu);
			}
		},
		handleSidebarMinify () {
            this.$store.commit('app/coreAdminPersistent/toggleSidebarMini')
		},
		handleSidebarFilter (e) {
			let value = e.target.value;
            value = value.toLowerCase();

			if (value) {
				for (let x = 0; x < this.menus.length; x++) {
					const title = (this.menus[x].title).toLowerCase();
					const children = this.menus[x].children;

					if (title.search(value) > -1) {
						this.$refs.sidebarNavList[x].show();

						if (children) {
							this.$refs.sidebarNavList[x].searchExpand();
						}
					} else if (children) {
                        let hasActive = false;
                        for (let y = 0; y < children.length; y++) {
                            const title2 = (children[y].title).toLowerCase();

                            if (title2.search(value) > -1) {
                                hasActive = true;
                                this.$refs.sidebarNavList[x].$refs.sidebarNavList[y].show();
                                this.$refs.sidebarNavList[x].searchExpand();
                            } else {
                                if (hasActive) {
                                    this.$refs.sidebarNavList[x].searchExpand();
                                } else {
                                    this.$refs.sidebarNavList[x].hide();
                                }
                                this.$refs.sidebarNavList[x].$refs.sidebarNavList[y].hide();
                            }
                        }
                    } else {
                        this.$refs.sidebarNavList[x].hide();
                    }
				}
			} else {
				for (let a = 0; a < this.menus.length; a++) {
					this.$refs.sidebarNavList[a].show();

					const submenu = this.menus[a].children;
					if (submenu) {
						for (let b = 0; b < submenu.length; b++) {
							this.$refs.sidebarNavList[a].$refs.sidebarNavList[b].show();
						}
					}
				}
			}
		}
	}
}
</script>
