<template>
	<div>
		<!-- BEGIN #sidebar -->
		<div id="sidebar" class="app-sidebar">
			<!-- BEGIN scrollbar -->
			<VueCustomScrollbar class="app-sidebar-content h-100">

				<!-- begin sidebar nav -->
				<TheSidebarNav ref="sidebarNav"
					:scroll-top="scrollTop"
					@show-float-submenu="handleShowFloatSubmenu"
					@hide-float-submenu="handleHideFloatSubmenu"></TheSidebarNav>
				<!-- end sidebar nav -->
			</VueCustomScrollbar>
			<!-- END scrollbar -->
		</div>
		<div class="app-sidebar-bg"></div>
		<div class="app-sidebar-mobile-backdrop"><a href="#" class="stretched-link" @click="dismissSidebarMobile"></a></div>

	</div>
</template>

<script>
export default {
	directives: {
		scroll: {
			inserted (el, binding) {
				const f = function (evt) {
					if (binding.value(evt, el)) {
						el.removeEventListener('scroll', f)
					}
				}
				el.addEventListener('scroll', f)

				if (typeof(Storage) !== 'undefined') {
					if (localStorage.sidebarScroll) {
						el.scrollTop = localStorage.sidebarScroll;
					}
				}
			}
		}
	},
	data() {
		return {
			scrollTop: '',
			floatSubmenu: false,
			floatSubmenuMenu: '',
			floatSubmenuTop: '',
			floatSubmenuBottom: '',
			floatSubmenuLeft: '',
			floatSubmenuRight: '',
			floatSubmenuArrowTop: '',
			floatSubmenuArrowBottom: '',
			floatSubmenuLineTop: '',
			floatSubmenuLineBottom: '',
			clearSubmenu: '',
			subMenuOffset: ''
		}
	},
	methods: {
		handleCalcFloatSubmenu () {
			setTimeout(() => {
				const targetTop = this.subMenuOffset.top;
				const windowHeight = window.innerHeight;
				const targetHeight = document.querySelector('.app-sidebar-float-submenu-container').offsetHeight;

				if ((windowHeight - targetTop) > targetHeight) {
					this.floatSubmenuTop = this.subMenuOffset.top + 'px';
					this.floatSubmenuBottom = 'auto';
					this.floatSubmenuArrowTop = '20px';
					this.floatSubmenuArrowBottom = 'auto';
					this.floatSubmenuLineTop = '20px';
					this.floatSubmenuLineBottom = 'auto';
				} else {
					this.floatSubmenuTop = 'auto';
					this.floatSubmenuBottom = '0';

					const arrowBottom = (windowHeight - targetTop) - 21;
					this.floatSubmenuArrowTop = 'auto';
					this.floatSubmenuArrowBottom = arrowBottom + 'px';
					this.floatSubmenuLineTop = '20px';
					this.floatSubmenuLineBottom = arrowBottom + 'px';
				}
			}, 0);
		},
		handleShowFloatSubmenu (data, offset) {
			this.floatSubmenuMenu = data;
			this.floatSubmenu = true;
			this.subMenuOffset = offset;

			const targetTop = offset.top;
			const windowHeight = window.innerHeight;

			setTimeout(() => {
				const targetHeight = document.querySelector('.app-sidebar-float-submenu-container').offsetHeight;

				if ((windowHeight - targetTop) > targetHeight) {
					this.floatSubmenuTop = offset.top + 'px';
					this.floatSubmenuBottom = 'auto';
					this.floatSubmenuArrowTop = '20px';
					this.floatSubmenuArrowBottom = 'auto';
					this.floatSubmenuLineTop = '20px';
					this.floatSubmenuLineBottom = 'auto';
				} else {
					this.floatSubmenuTop = 'auto';
					this.floatSubmenuBottom = '0';

					const arrowBottom = (windowHeight - targetTop) - 21;
					this.floatSubmenuArrowTop = 'auto';
					this.floatSubmenuArrowBottom = arrowBottom + 'px';
					this.floatSubmenuLineTop = '20px';
					this.floatSubmenuLineBottom = arrowBottom + 'px';
				}
			}, 0);

			this.floatSubmenuRight = 'auto';
			this.floatSubmenuLeft = (document.getElementById('sidebar').offsetLeft + offset.width) + 'px';

			clearTimeout(this.clearSubmenu);
		},
		handleHideFloatSubmenu () {
			this.clearSubmenu = setTimeout(() => {
				this.floatSubmenu = false;
			}, 250);
		},
		clearHideFloatSubmenu () {
			clearTimeout(this.clearSubmenu);
		},
		handleScroll (evt) {
			this.scrollTop = evt.target.scrollTop;
			if (typeof(Storage) !== 'undefined') {
				localStorage.setItem('sidebarScroll', this.scrollTop);
			}
		},
		dismissSidebarMobile (evt) {
			evt.preventDefault();
            this.$store.commit('app/coreAdmin/hideSidebarMobile')
		}
	}
}
</script>
