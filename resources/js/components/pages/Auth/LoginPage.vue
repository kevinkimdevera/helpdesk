<template>
  <v-container fluid>
    <v-row
      justify="center"
      align="center"
    >
      <v-col
        cols="12"
        md="7"
        lg="5"
        xl="3"
      >
        <v-form
          ref="loginForm"
          v-model="loginFormValid"
          @submit.prevent="validateLogin"
        >
          <v-card
            :loading="authenticating"
            elevation="7"
          >
            <v-card-text class="text-center">
              <p class="text-h5 font-weight-bold mb-3">
                {{ appTitle }}
              </p>
              <p>Sign in to your account</p>
            </v-card-text>

            <v-card-text>
              <v-text-field
                label="Email"
                variant="outlined"
                v-model="email"
                :rules="rules.email"
                required
                class="mb-3"
                :error="!!loginError"
                :error-messages="loginError"
              />

              <v-text-field
                label="Password"
                variant="outlined"
                :type="showPassword ? 'text' : 'password'"
                v-model="password"
                :rules="rules.password"
                required
                class="mb-3"
              />

              <v-checkbox
                color="primary"
                label="Show Password"
                class="mt-0"
                v-model="showPassword"
              />

              <v-btn
                color="primary"
                block
                size="large"
                type="submit"
                variant="flat"
                :disabled="authenticating"
              >
                Login
              </v-btn>
            </v-card-text>
          </v-card>
        </v-form>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  data: () => ({
    appTitle: process.env.MIX_APP_NAME,

    authenticating: false,
    loginFormValid: true,
    loginError: '',

    email: '',
    password: '',
    showPassword: false,

    rules: {
      email: [
        v => !!v || 'Please enter your email.'
      ],

      password: [
        v => !!v || 'Please enter your password.'
      ]
    }
  }),

  methods: {
    ...mapActions({
      _attemptLogin: 'auth/ATTEMPT_LOGIN',
      _authenticateToken: 'auth/AUTHENTICATE_TOKEN',
      _login: 'auth/LOGIN'
    }),
    async validateLogin () {
      const { valid } = await this.$refs.loginForm.validate()

      if (valid) {
        this.authenticating = true

        this._attemptLogin({
          email: this.email,
          password: this.password
        }).then((response) => {
          const data = response?.data
          if (data) {
            this._login(data?.user)
            this._authenticateToken(data?.token)

            this.$router.replace({
              name: 'dashboard'
            })
          }
        }).catch((e) => {
          this.loginError = e.message
          this.authenticating = false
        })
      }
    }
  }
}
</script>
