<script>

let menu = []

try {

  menu = require('~/config/user-menu.js');
  menu = menu.default

} catch (error) {
  console.error('You need to create a file in ~/config/user-menu.js with the menus that will be listed in TheHeader component.')
}

const userMenu = menu;

export default userMenu;
</script>
