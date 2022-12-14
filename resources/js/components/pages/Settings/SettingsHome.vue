<template>
  <v-row justify="center">
    <v-col
      cols="12"
      lg="6"
      xl="5"
    >
      <h1 class="mb-3">
        Settings
      </h1>

      <v-list
        border
        rounded
      >
        <v-list-item
          link
          title="Account Settings"
          subtitle="Manage your account settings"
          append-icon="mdi-open-in-new"
        />
      </v-list>

      <template v-if="canManageSettings">
        <p class="text-body-2 my-3">
          Manage
        </p>

        <v-list
          border
          rounded
        >
          <template v-if="canManageGroups">
            <v-list-item
              link
              :to="{ name: 'settings.groups' }"
              title="Groups"
              subtitle="Manage groups"
              append-icon="mdi-chevron-right"
            />
            <v-divider class="my-2" />
          </template>

          <template v-if="canManageUsers">
            <v-list-item
              link
              :to="{ name: 'settings.users' }"
              title="Users"
              subtitle="Manage other users"
              append-icon="mdi-chevron-right"
            />
          </template>
        </v-list>
      </template>
    </v-col>
  </v-row>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  data () {
    return {

    }
  },

  computed: {
    ...mapGetters({
      user: 'auth/USER'
    }),
    userPermissions () {
      return this.user?.role?.permissions
    },
    canManageSettings () {
      const settingsArray = [
        'groups',
        'users',
        'roles'
      ]

      return settingsArray.some(item => this.userPermissions?.includes(item))
    },
    canManageGroups () {
      return this.userPermissions?.includes('groups')
    },
    canManageUsers () {
      return this.userPermissions?.includes('users')
    },
    canManageRoles () {
      return this.userPermissions?.includes('roles')
    }
  }
}
</script>
