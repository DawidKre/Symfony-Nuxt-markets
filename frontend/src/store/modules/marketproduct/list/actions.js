import fetch from '../../../../utils/fetch'
import { MARKETPRODUCT } from '../mutation_types'
import { API } from '../../../../api/api_endpoints'

const getItems = ({ commit }, page = API.MARKET_PRODUCTS) => {
  commit(MARKETPRODUCT.LIST_TOGGLE_LOADING)

  fetch(page)
    .then(response => response.json())
    .then((data) => {
      commit(MARKETPRODUCT.LIST_TOGGLE_LOADING)
      commit(MARKETPRODUCT.LIST_SET_ITEMS, data['hydra:member'])
      commit(MARKETPRODUCT.LIST_SET_VIEW, data['hydra:view'])
    })
    .catch((e) => {
      commit(MARKETPRODUCT.LIST_TOGGLE_LOADING)
      commit(MARKETPRODUCT.LIST_SET_ERROR, e.message)
    })
}

export default getItems
