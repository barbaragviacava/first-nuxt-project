import GenericRepository from '~/repositories/GenericRepository'

export const PLURAL_NAME = 'Produtos'
export const SINGULAR_NAME = 'Produto'

export default class ProductRepository extends GenericRepository
{
    /**
     * @param {Object|Function} axios
     */
    constructor(axios)
    {
        super(axios, 'products')
    }
}
