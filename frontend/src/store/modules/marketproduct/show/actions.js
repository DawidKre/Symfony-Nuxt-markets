import fetch from '../../../../utils/fetch'
import { MARKETPRODUCT } from '../mutation_types'

export const retrieve = ({ commit }, id) => {
  commit(MARKETPRODUCT.SHOW_TOGGLE_LOADING)

  return fetch(id)
    .then(response => response.json())
    .then((data) => {
      commit(MARKETPRODUCT.SHOW_TOGGLE_LOADING)
      commit(MARKETPRODUCT.SHOW_SET_RETRIEVED, data)
    })
    .catch((e) => {
      commit(MARKETPRODUCT.SHOW_TOGGLE_LOADING)
      commit(MARKETPRODUCT.SHOW_SET_ERROR, e.message)
    })
}

export const reset = ({ commit }) => {
  commit(MARKETPRODUCT.SHOW_RESET)
}
