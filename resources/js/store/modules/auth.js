import api from '../../api'

const state = {
  user: null,
  authTokenName: process.env.MIX_APP_AUTH_TOKEN_NAME
}

const getters = {
  TOKEN: state => localStorage.getItem(state.authTokenName),
  USER: state => state.user
}

const mutations = {
  SET_USER: (state, payload) => { state.user = payload }
}

const actions = {
  AUTHENTICATE_TOKEN: ({ commit }, token) => {
    api.setAuthToken(token)
    localStorage.setItem(state.authTokenName, token)
  },

  REVOKE_TOKEN: ({ commit }) => {
    api.removeAuthToken()
    localStorage.removeItem(state.authTokenName)
  },

  ATTEMPT_LOGIN: async ({ dispatch }, credentials) => {
    return await api.post('/api/auth/login', credentials)
  },

  GET_USER_DATA: async ({ commit }) => {
    return await api.get('/api/auth/user')
  },

  LOGIN: ({ commit }, user) => {
    commit('SET_USER', user)
  },

  LOGOUT: ({ commit }) => {
    commit('SET_USER', null)
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
