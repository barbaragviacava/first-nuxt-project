import GenericRepository from '~/repositories/GenericRepository'

export const PLURAL_NAME = 'Categorias'
export const SINGULAR_NAME = 'Categoria'

export default class CategoryRepository extends GenericRepository
{
    /**
     * @param {Object|Function} axios
     */
    constructor(axios)
    {
        super(axios, 'categories')
    }
}
