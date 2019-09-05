import * as types from '../mutation_types'

export default {
  [types.MARKETPRODUCT.LIST_RESET] (state) {
    Object.assign(state, {
      error: '',
      isLoading: false,
      items: [],
      view: []
    })
  },

  [types.MARKETPRODUCT.LIST_SET_ERROR] (state, error) {
    Object.assign(state, { error })
  },

  [types.MARKETPRODUCT.LIST_SET_ITEMS] (state, items) {
    Object.assign(state, { items })
  },

  [types.MARKETPRODUCT.LIST_TOGGLE_LOADING] (state) {
    Object.assign(state, { isLoading: !state.isLoading })
  },

  [types.MARKETPRODUCT.LIST_SET_VIEW] (state, view) {
    Object.assign(state, { view })
  }
}
