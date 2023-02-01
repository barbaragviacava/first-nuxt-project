import GenericRepository from '~/repositories/GenericRepository'

export const PLURAL_NAME = 'repositories.product.plural'
export const SINGULAR_NAME = 'repositories.product.singular'

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
