<template>
  <div>
    <h1 class="mb-3">
      Users
    </h1>

    <v-card
      elevation="0"
      border
      :loading="loading"
    >
      <v-toolbar>
        <v-toolbar-title>Users List</v-toolbar-title>

        <template #append>
          <v-btn
            icon="mdi-plus"
            @click="openGroupDialog"
          />
        </template>
      </v-toolbar>
      <template v-if="!isLoading">
        <template v-if="users.length > 0">
          <v-table class="groups-table">
            <thead>
              <tr>
                <th class="text-left">
                  Name
                </th>
                <th class="text-center">
                  Role
                </th>
                <th class="text-center">
                  Groups
                </th>
                <th class="user-actions" />
              </tr>
            </thead>
            <tbody>
              <template
                v-for="(user, i) in users"
                :key="`user-tr-${i}`"
              >
                <tr>
                  <td class="group-name">
                    <v-list-item class="px-0">
                      <template #prepend>
                        <v-avatar
                          color="primary"
                          size="32"
                        >
                          {{ user.avatar }}
                        </v-avatar>
                      </template>

                      <v-list-item-title class="text-body-2">
                        {{ user.name }}
                      </v-list-item-title>
                      <v-list-item-subtitle class="text-caption">
                        {{ user.email }}
                      </v-list-item-subtitle>
                    </v-list-item>
                  </td>
                  <td class="text-center">
                    {{ user.role.name }}
                  </td>
                  <td class="text-center">

                  </td>
                  <td class="user-actions text-right">
                    <v-btn
                      variant="text"
                      color="info"
                      icon="mdi-pencil"
                      size="x-small"
                    />
                    <v-btn
                      variant="text"
                      color="error"
                      icon="mdi-delete"
                      size="x-small"
                    />
                  </td>
                </tr>
              </template>
            </tbody>
          </v-table>
        </template>
        <template v-else>
          <v-card-text class="text-center text-body-1">
            <p class="mb-3">
              <v-icon
                size="36"
                icon="mdi-information-outline"
              />
            </p>
            <p>No saved users.</p>
          </v-card-text>
        </template>
      </template>
    </v-card>
  </div>
</template>
<script>
import { mapActions } from 'vuex'

export default {
  beforeRouteEnter (to, from, next) {
    next(vm => {
      vm.getUsers()
    })
  },
  data () {
    return {
      loading: false,

      groups: [],
      roles: [],
      users: []
    }
  },
  computed: {
    isLoading () {
      return this.users.length === 0 &&
        this.loading
    },
  },
  methods: {
    ...mapActions({
      _getUsers: 'users/GET'
    }),

    getUsers () {
      this.loading = true

      this._getUsers()
        .then((response) => {
          this.groups = response?.groups
          this.roles = response?.roles
          this.users = response?.users
        })
        .catch((e) => {
          this.$router.replace({
            name: 'settings.home'
          })
        })
        .finally(() => {
          this.loading = false
        })
    }
  }
}
</script>
