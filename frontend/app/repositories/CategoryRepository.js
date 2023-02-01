import GenericRepository from '~/repositories/GenericRepository'

export const PLURAL_NAME = 'repositories.category.plural'
export const SINGULAR_NAME = 'repositories.category.singular'

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
