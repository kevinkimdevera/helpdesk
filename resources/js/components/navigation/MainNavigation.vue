<template>
  <header>
    <v-app-bar
      color="primary"
      flat
    >
      <v-app-bar-nav-icon
        variant="text"
        class="d-md-none"
        @click.stop="drawer = !drawer"
      />

      <v-app-bar-title>
        {{ appTitle }}
      </v-app-bar-title>

      <template
        v-if="isAuthenticated"
        #append
      >
        <v-menu
          offset-y
          transition="slide-y-transition"
        >
          <template #activator="{ props }">
            <v-btn
              icon
              v-bind="props"
            >
              <v-avatar
                color="secondary"
                size="40"
              >
                {{ userAvatar }}
              </v-avatar>
            </v-btn>
          </template>

          <v-card width="360">
            <v-list nav>
              <v-list-item two-line>
                <template #prepend>
                  <v-avatar
                    color="secondary"
                    size="40"
                  >
                    {{ userAvatar }}
                  </v-avatar>
                </template>

                <v-list-item-title class="font-weight-medium">
                  {{ userName }}
                </v-list-item-title>
                <v-list-item-subtitle>{{ userEmail }}</v-list-item-subtitle>
              </v-list-item>

              <v-divider class="my-2" />

              <v-list-item @click="logout">
                <template #prepend>
                  <v-icon>mdi-logout-variant</v-icon>
                </template>
                <v-list-item-title>Sign Out</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-card>
        </v-menu>
      </template>
    </v-app-bar>

    <v-navigation-drawer
      v-model="drawer"
      :permanent="isOnDesktop"
    >
      <v-list
        density="compact"
        nav
        color="primary"
      >
        <v-list-item
          link
          exact
          :to="{ name: 'dashboard' }"
          prepend-icon="mdi-view-dashboard"
          title="Dashboard"
        />

        <v-list-item
          link
          exact
          :to="{ name: 'tickets.home' }"
          prepend-icon="mdi-ticket-outline"
          title="Tickets"
        />

        <v-list-item
          link
          exact
          :to="{ name: 'settings.home' }"
          prepend-icon="mdi-cog"
          title="Settings"
        />
      </v-list>
    </v-navigation-drawer>
  </header>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  data () {
    return {
      appTitle: process.env.MIX_APP_NAME,
      drawer: null
    }
  },
  computed: {
    ...mapGetters({
      user: 'auth/USER'
    }),
    isOnDesktop () {
      return this.$vuetify.display.mdAndUp
    },
    isAuthenticated () {
      return !!this.user
    },
    userName () {
      return this.user?.name
    },
    userEmail () {
      return this.user?.email
    },
    userAvatar () {
      return this.user?.avatar
    }
  },
  methods: {
    ...mapActions({
      _logout: 'auth/LOGOUT',
      _revokeToken: 'auth/REVOKE_TOKEN'
    }),
    logout () {
      this._logout()
      this._revokeToken()
      this.$router.replace({
        name: 'auth.login'
      })
    }
  }
}
</script>
