import AuthRepository from '~/repositories/AuthRepository'
import UsuarioRepository from '~/repositories/UsuarioRepository'
import CategoriaRepository from '~/repositories/CategoriaRepository'
import ProdutoRepository from '~/repositories/ProdutoRepository'
import DashboardRepository from '~/repositories/DashboardRepository'

export default ($axios) => ({
    auth: new AuthRepository($axios),
    usuarios: new UsuarioRepository($axios),
    categorias: new CategoriaRepository($axios),
    produtos: new ProdutoRepository($axios),
    dashboard: new DashboardRepository($axios),
})
