import api from '../../api'

const state = {
}

const getters = {
}

const mutations = {
}

const actions = {
  GET: async ({ commit }, params) => {
    return await api.get('/api/settings/groups', params)
  },

  SAVE: async ({ commit }, data) => {
    return await api.post('/api/settings/groups', data)
  },

  UPDATE: async ({ commit }, payload) => {
    return await api.patch(`/api/settings/groups/${payload.id}`, payload.data)
  },

  DELETE: async ({ commit }, data) => {
    return await api.delete(`/api/settings/groups/${data.id}`)
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
