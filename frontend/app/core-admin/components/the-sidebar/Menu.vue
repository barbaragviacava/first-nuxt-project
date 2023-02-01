<script>

let menu = []

try {

  menu = require('~/config/menu.js');
  menu = menu.default

} catch (error) {
  console.error('You need to create a file in ~/config/menu.js with the menus that will be listed in TheSidebar/Nav component.')
}

const sidebarMenu = menu;

export default sidebarMenu;
</script>
