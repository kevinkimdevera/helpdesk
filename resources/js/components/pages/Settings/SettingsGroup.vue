<template>
  <div>
    <h1 class="mb-3">
      Groups
    </h1>

    <v-card
      elevation="0"
      border
      :loading="loading"
    >
      <v-toolbar>
        <v-toolbar-title>Groups List</v-toolbar-title>

        <template #append>
          <v-btn
            icon="mdi-plus"
            @click="openGroupDialog"
          />
        </template>
      </v-toolbar>
      <template v-if="!isLoading">
        <template v-if="groups.length > 0">
          <v-table class="groups-table">
            <thead>
              <tr>
                <th class="text-left group-name">
                  Group Name
                </th>
                <th class="text-center group-users">
                  Users
                </th>
                <th class="text-center group-status">
                  Status
                </th>
                <th class="group-actions" />
              </tr>
            </thead>
            <tbody>
              <template
                v-for="(group, i) in groups"
                :key="`group-tr-${i}`"
              >
                <tr>
                  <td class="group-name">
                    {{ group.name }}
                  </td>
                  <td class="text-center group-users">
                    {{ group.users }}
                  </td>
                  <th class="text-center group-status">
                    <v-chip
                      size="small"
                      :color="group.status.color"
                      :prepend-icon="group.status.icon"
                    >
                      {{ group.status.text }}
                    </v-chip>
                  </th>
                  <td class="group-actions text-right">
                    <v-btn
                      @click="editGroup(group)"
                      variant="text"
                      color="info"
                      icon="mdi-pencil"
                      size="x-small"
                    />
                    <v-btn
                      @click="openDeleteDialog(group)"
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
            <p>No saved groups.</p>
          </v-card-text>
        </template>
      </template>
    </v-card>

    <v-dialog
      v-model="groupDialog"
      width="580"
      persistent
    >
      <v-form
        @submit.prevent="submitGroupForm"
        ref="groupForm"
        v-model="groupForm"
      >
        <v-card>
          <v-toolbar
            dark
            color="primary"
          >
            <v-toolbar-title>{{ hasSelectedGroup ? 'Edit' : 'New' }} Group</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <v-text-field
              :error="hasGroupNameError"
              :error-messages="groupNameError"
              v-model="groupName"
              required
              :rules="rules.name"
              variant="outlined"
              label="Group Name"
            />
            <template v-if="hasSelectedGroup">
              <v-label>Status</v-label>
              <v-checkbox
                v-model="groupActive"
                label="Active"
                color="primary"
              />
            </template>
          </v-card-text>
          <v-card-actions>
            <v-spacer />
            <v-btn
              color="primary"
              :disabled="groupFromSaving"
              @click="closeGroupDialog"
            >
              Cancel
            </v-btn>
            <v-btn
              color="primary"
              :loading="groupFromSaving"
              type="submit"
            >
              Save
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-dialog>

    <v-dialog
      v-model="deleteDialog"
      width="290"
      persistent
    >
      <v-form @submit.prevent="deleteGroup">
        <v-card>
          <v-card-title>Delete Group</v-card-title>
          <v-card-text>Are you sure you want to delete this group?</v-card-text>
          <v-card-actions>
            <v-spacer />
            <v-btn
              :disabled="groupDeleting"
              @click="closeDeleteDialog"
            >
              Cancel
            </v-btn>
            <v-btn
              :loading="groupDeleting"
              color="error"
              type="submit"
            >
              Delete
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-dialog>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  beforeRouteEnter (to, from, next) {
    next(vm => {
      vm.getGroups()
    })
  },
  data () {
    return {
      loading: true,
      groupDialog: false,
      deleteDialog: false,

      groups: [],

      groupForm: true,
      groupFormErrors: null,
      groupFromSaving: false,
      groupDeleting: false,

      selectedGroup: null,

      groupName: null,
      groupActive: true,

      rules: {
        name: [
          v => !!v || 'This is a required field.'
        ]
      }
    }
  },
  computed: {
    isLoading () {
      return this.groups.length === 0 &&
        this.loading
    },
    hasSelectedGroup () {
      return !!this.selectedGroup
    },
    groupNameError () {
      return this.groupFormErrors?.name
    },
    hasGroupNameError () {
      return !!this.groupNameError
    }
  },
  methods: {
    ...mapActions({
      _getGroupsList: 'groups/GET',
      _saveGroup: 'groups/SAVE',
      _updateGroup: 'groups/UPDATE',
      _deleteGroup: 'groups/DELETE'
    }),
    getGroups () {
      this.loading = true
      this._getGroupsList()
        .then((response) => {
          this.groups = response?.data
        })
        .catch((e) => {
          this.$router.replace({
            name: 'settings.home'
          })
        })
        .finally(() => {
          this.loading = false
        })
    },

    openGroupDialog () {
      this.groupDialog = true
    },

    closeGroupDialog () {
      this.groupDialog = false

      this.$refs.groupForm.reset()
      this.$refs.groupForm.resetValidation()

      this.selectedGroup = null
      this.groupFormErrors = null
    },

    submitGroupForm () {
      if (this.hasSelectedGroup) {
        this.updateGroup()
      } else {
        this.saveGroup()
      }
    },

    async saveGroup () {
      const { valid } = await this.$refs.groupForm.validate()

      if (valid) {
        this.groupFromSaving = true
        this.groupFormErrors = null

        this._saveGroup({
          name: this.groupName
        }).then((response) => {
          if (response?.saved) {
            this.getGroups()
            this.closeGroupDialog()
          }
        }).catch((e) => {
          this.groupFormErrors = e.errors
        }).finally(() => {
          this.groupFromSaving = false
        })
      }
    },

    editGroup (group) {
      this.selectedGroup = group

      this.groupName = group?.name
      this.groupActive = group?.status?.active

      this.openGroupDialog()
    },

    async updateGroup () {
      const { valid } = await this.$refs.groupForm.validate()

      if (valid) {
        this.groupFromSaving = true
        this.groupFormErrors = null

        this._updateGroup({
          id: this.selectedGroup?.id,
          data: {
            name: this.groupName,
            active: this.groupActive
          }
        }).then((response) => {
          if (response?.updated) {
            this.getGroups()
            this.closeGroupDialog()
          }
        }).catch((e) => {
          this.groupFormErrors = e.errors
        }).finally(() => {
          this.groupFromSaving = false
        })
      }
    },

    openDeleteDialog (group) {
      this.selectedGroup = group
      this.deleteDialog = true
    },

    closeDeleteDialog () {
      this.selectedGroup = null
      this.deleteDialog = false
    },

    deleteGroup () {
      this.groupDeleting = true

      this._deleteGroup({
        id: this.selectedGroup?.id
      }).then((response) => {
        if (response?.deleted) {
          this.getGroups()
          this.closeDeleteDialog()
        }
      }).finally(() => {
        this.groupDeleting = false
      })
    }
  }
}
</script>

<style lang="scss">
  .groups-table {
    .group-users,
    .group-status {
      width: 200px !important;
    }

    .group-actions {
      width: 250px !important;
    }
  }
</style>
