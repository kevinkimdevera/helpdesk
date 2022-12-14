import api from '../../api'

const state = {
}

const getters = {
}

const mutations = {
}

const actions = {
  GET: async ({ commit }, params) => {
    return await api.get('/api/settings/users', params)
  },

  SAVE: async ({ commit }, data) => {
    return await api.post('/api/settings/users', data)
  },

  UPDATE: async ({ commit }, payload) => {
    return await api.patch(`/api/settings/users/${payload.id}`, payload.data)
  },

  DELETE: async ({ commit }, data) => {
    return await api.delete(`/api/settings/users/${data.id}`)
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
