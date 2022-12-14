<template>
  <v-layout>
    <v-overlay
      v-model="userLoading"
      class="align-center justify-center"
      persistent
      opacity="1"
      color="white"
    >
      <v-progress-circular
        active
        size="64"
        indeterminate
        color="primary"
      />
    </v-overlay>

    <router-view name="navigation" />

    <v-main class="no-transition">
      <router-view />
    </v-main>
  </v-layout>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  data: () => ({
    userLoading: false
  }),

  computed: {
    ...mapGetters({
      user: 'auth/USER',
      token: 'auth/TOKEN'
    })
  },

  methods: {
    ...mapActions({
      _authenticateToken: 'auth/AUTHENTICATE_TOKEN',
      _revokeToken: 'auth/REVOKE_TOKEN',
      _getUserData: 'auth/GET_USER_DATA',
      _login: 'auth/LOGIN',
      _logout: 'auth/LOGOUT'
    }),

    authenticate (token) {
      this.userLoading = true

      this._authenticateToken(token)
      this._getUserData()
        .then((response) => {
          const user = response?.data
          this._login(user)
        })
        .catch((e) => {
          this._logout()
          this._revokeToken()
          this.$router.replace({
            name: 'auth.login'
          })
        })
        .finally(() => {
          this.userLoading = false
        })
    }
  },

  created () {
    const token = this.token

    if (token) {
      this.authenticate(token)
    }
  }
}
</script>

<style lang="scss">
  .no-transition {
    transition: none !important;
  }
</style>
