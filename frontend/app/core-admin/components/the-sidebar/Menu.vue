<script>

let menu = []

try {

    menu = require('~/config/menu.js');
    menu = menu.default

} catch (error) {
    console.error('Você precisa criar um arquivo em ~/config/menu.js com os menus que serão listados no componente TheSidebar/Nav.')
}

const sidebarMenu = menu;

export default sidebarMenu;
</script>
