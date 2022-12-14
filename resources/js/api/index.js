import axios from 'axios'

export default {
  setAuthToken: (token) => {
    axios.defaults.headers.common.Authorization = `Bearer ${token}`
  },

  removeAuthToken: () => {
    delete axios.defaults.headers.common.Authorization
  },

  get: (url, params) => {
    return new Promise((resolve, reject) => {
      axios.get(url, {
        responseType: 'json',
        params: params
      }).then((response) => {
        resolve(response.data)
      }).catch((e) => {
        reject(e.response.data)
      })
    })
  },

  post: (url, data) => {
    return new Promise((resolve, reject) => {
      axios.post(url, data, {
        responseType: 'json'
      }).then((response) => {
        resolve(response.data)
      }).catch((e) => {
        reject(e.response.data)
      })
    })
  },

  patch: (url, data = {}) => {
    return new Promise((resolve, reject) => {
      axios.patch(url, data, {
        responseType: 'json'
      }).then((response) => {
        resolve(response.data)
      }).catch((e) => {
        reject(e.response.data)
      })
    })
  },

  delete: (url, data = {}) => {
    return new Promise((resolve, reject) => {
      axios.delete(url, data, {
        responseType: 'json'
      }).then((response) => {
        resolve(response.data)
      }).catch((e) => {
        reject(e.response.data)
      })
    })
  }
}
