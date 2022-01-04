import AuthRepository from '~/repositories/AuthRepository'
import UsuarioRepository from '~/repositories/UsuarioRepository'
import GenericRepository from '~/repositories/GenericRepository'
import DashboardRepository from '~/repositories/DashboardRepository'

export default ($axios) => ({
    auth: AuthRepository($axios),
    usuarios: UsuarioRepository($axios),
    categorias: GenericRepository($axios)('categorias'),
    produtos: GenericRepository($axios)('produtos'),
    dashboard: DashboardRepository($axios),
})
