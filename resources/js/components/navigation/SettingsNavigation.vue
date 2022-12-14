<template>
  <header>
    <v-app-bar
      color="primary"
      flat
    >
      <template v-if="isOnDesktop">
        <v-btn
          icon="mdi-arrow-left"
          link
          :to="{ name: 'dashboard' }"
        />
      </template>

      <template v-else>
        <v-app-bar-nav-icon
          variant="text"
          @click.stop="drawer = !drawer"
        />
      </template>

      <v-app-bar-title>
        Settings
      </v-app-bar-title>
    </v-app-bar>

    <v-navigation-drawer
      class="no-transition"
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
          :to="{ name: 'settings.home' }"
          prepend-icon="mdi-cog"
          title="Home"
        />
        <template v-if="canManageSettings">
          <v-divider />
          <v-list-subheader>Manage</v-list-subheader>
          <template v-if="canManageGroups">
            <v-list-item
              link
              exact
              :to="{ name: 'settings.groups' }"
              prepend-icon="mdi-account-group"
              title="Groups"
            />
          </template>
          <template v-if="canManageUsers">
            <v-list-item
              link
              exact
              :to="{ name: 'settings.users' }"
              prepend-icon="mdi-account-multiple"
              title="Users"
            />
          </template>
        </template>
      </v-list>
    </v-navigation-drawer>
  </header>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  data () {
    return {
      drawer: null
    }
  },

  beforeRouteEnter (to, from, next) {
    next(vm => {

    })
  },

  computed: {
    ...mapGetters({
      user: 'auth/USER'
    }),
    isOnDesktop () {
      return this.$vuetify.display.mdAndUp
    },
    userPermissions () {
      return this.user?.role?.permissions
    },
    canManageSettings () {
      const settingsArray = [
        'groups',
        'users'
      ]

      return settingsArray.some(item => this.userPermissions?.includes(item))
    },
    canManageGroups () {
      return this.userPermissions?.includes('groups')
    },
    canManageUsers () {
      return this.userPermissions?.includes('users')
    }
  }
}
</script>
