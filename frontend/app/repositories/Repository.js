import AuthRepository from '~/repositories/AuthRepository'
import UserRepository from '~/repositories/UserRepository'
import CategoryRepository from '~/repositories/CategoryRepository'
import ProductRepository from '~/repositories/ProductRepository'
import DashboardRepository from '~/repositories/DashboardRepository'

export default ($axios) => ({
    auth: new AuthRepository($axios),
    users: new UserRepository($axios),
    categories: new CategoryRepository($axios),
    products: new ProductRepository($axios),
    dashboard: new DashboardRepository($axios),
})
