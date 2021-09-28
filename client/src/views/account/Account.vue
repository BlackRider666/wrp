<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <v-card-title>
          Account Settings
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="6">
              <v-toolbar dense color="primary">
                Common
                <v-spacer/>
                <v-btn icon @click="showCommonSheet">
                  <v-icon v-if="showCommon">mdi-chevron-up</v-icon>
                  <v-icon v-else>mdi-chevron-down</v-icon>
                </v-btn>
              </v-toolbar>

              <v-sheet v-if="showCommon" outlined>
                <v-form
                    lazy-validation
                    align="center"
                    @submit.prevent="updateUser"
                ><v-card
                    flat
                >
                  <v-card-text>
                    <v-text-field
                        v-model="user.first_name"
                        :label="$t('placeholder.first_name')"
                        outlined
                        prepend-inner-icon="mdi-account-outline"
                        :rules="[rules.required]"
                    />
                    <v-text-field
                        v-model="user.second_name"
                        :label="$t('placeholder.second_name')"
                        outlined
                        prepend-inner-icon="mdi-account-outline"
                        :rules="[rules.required]"
                    />
                    <v-text-field
                        v-model="user.surname"
                        :label="$t('placeholder.surname')"
                        outlined
                        prepend-inner-icon="mdi-account-outline"
                        :rules="[rules.required]"
                    />
                    <v-text-field
                        v-model="user.email"
                        outlined
                        prepend-inner-icon="mdi-email-outline"
                        :label="$t('placeholder.email')"
                        type="email"
                        disabled
                    />
                    <v-text-field
                        v-model="user.phone"
                        :label="$t('placeholder.phone')"
                        outlined
                        prepend-inner-icon="mdi-phone"
                        :rules="[rules.required, rules.phone]"
                    />
                    <v-textarea
                        v-model="user.desc"
                        :label="$t('placeholder.desc')"
                        outlined
                        prepend-inner-icon="mdi-card-text-outline"
                        :rules="[rules.required]"
                    ></v-textarea>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" type="submit">Update</v-btn>
                  </v-card-actions>
                </v-card>
                </v-form>
              </v-sheet>
            </v-col>
            <v-col cols="6">
              <v-row>
                <v-col cols="12">
                  <v-toolbar dense color="primary">
                    Avatar
                    <v-spacer/>
                    <v-btn icon @click="showAvatarSheet">
                      <v-icon v-if="showAvatar">mdi-chevron-up</v-icon>
                      <v-icon v-else>mdi-chevron-down</v-icon>
                    </v-btn>
                  </v-toolbar>

                  <v-sheet v-if="showAvatar" outlined>
                    <v-form
                        lazy-validation
                        align="center"
                        @submit.prevent="updateUserAvatar"
                    ><v-card
                        flat
                    >
                      <v-card-text>
                        <v-avatar
                            size="128"
                            class="my-2"
                        >
                          <v-img :src="user.avatar_url" />
                        </v-avatar>
                        <v-file-input
                            :rules="[rules.required]"
                            accept="image/png, image/jpeg, image/bmp"
                            placeholder="Pick an avatar"
                            prepend-inner-icon="mdi-camera"
                            prepend-icon=""
                            label="Avatar"
                            outlined
                            v-model="avatar"
                            @change="changeAvatarFile"
                        ></v-file-input>
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" type="submit">Update</v-btn>
                      </v-card-actions>
                    </v-card>
                    </v-form>
                  </v-sheet>
                </v-col>
                <v-col cols="12">
                  <v-toolbar dense color="primary">
                    Change password
                    <v-spacer/>
                    <v-btn icon @click="showChangePasswordSheet">
                      <v-icon v-if="changePassword">mdi-chevron-up</v-icon>
                      <v-icon v-else>mdi-chevron-down</v-icon>
                    </v-btn>
                  </v-toolbar>

                  <v-sheet v-if="changePassword" outlined>
                    <v-form
                        lazy-validation
                        align="center"
                        @submit.prevent="changeUserPassword"
                    ><v-card
                        flat
                    >
                      <v-card-text>
                        <v-text-field
                            v-model="changePasswordRequest.password"
                            :rules="[rules.required, rules.min]"
                            outlined
                            prepend-inner-icon="mdi-lock"
                            color="primary"
                            :type="changePasswordRequest.passwordType"
                            :label="$t('placeholder.password')"
                        >
                          <template v-slot:append>
                            <v-icon color="secondary" v-if="changePasswordRequest.passwordType === 'password'" @click="changePasswordRequest.passwordType = 'text'">mdi-eye</v-icon>
                            <v-icon color="primary" v-if="changePasswordRequest.passwordType === 'text'" @click="changePasswordRequest.passwordType = 'password'">mdi-eye</v-icon>
                          </template>
                        </v-text-field>
                        <v-text-field
                            v-model="changePasswordRequest.password_confirmation"
                            :type="changePasswordRequest.passwordType"
                            :label="$t('placeholder.password_confirmation')"
                            color="primary"
                            outlined
                            prepend-inner-icon="mdi-lock"
                            :rules="[rules.required, rules.min, rules.confirmation]"
                        />
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" type="submit">Change</v-btn>
                      </v-card-actions>
                    </v-card>
                    </v-form>
                  </v-sheet>
                </v-col>
              </v-row>
              </v-col>
            <v-col cols="12">
              <v-toolbar dense color="primary">
                Works
                <v-spacer/>
                <v-btn
                    icon
                    @click="openCreateWorkDialog"
                ><v-icon>mdi-plus</v-icon>
                </v-btn>
                <v-btn icon @click="showWorksSheet">
                  <v-icon v-if="worksSheet">mdi-chevron-up</v-icon>
                  <v-icon v-else>mdi-chevron-down</v-icon>
                </v-btn>
              </v-toolbar>
              <v-sheet v-if="worksSheet" outlined>
                <v-data-table
                    :headers="worksHeaders"
                    :items="works"
                    class="elevation-1"
                    dense
                >
                  <template v-slot:top>
                      <v-dialog v-model="editWorkDialog" max-width="500px">
                        <v-card>
                          <v-card-title>Edit</v-card-title>
                          <v-card-text v-if="selectedWork">
                          </v-card-text>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="darken-1" text @click="closeWorkEdit">Cancel</v-btn>
                            <v-btn color="darken-1" text @click="editWork">Update</v-btn>
                            <v-spacer></v-spacer>
                          </v-card-actions>
                        </v-card>
                      </v-dialog>
                    <v-dialog v-model="deleteWorkDialog" max-width="500px">
                      <v-card>
                        <v-card-title>Delete</v-card-title>
                        <v-card-text>Are you sure you want to delete this work?</v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn color="darken-1" text @click="closeWorkDelete">Cancel</v-btn>
                          <v-btn color="error" text @click="deleteWork">Delete</v-btn>
                          <v-spacer></v-spacer>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>
                  </template>
                  <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="openWorkEdit(item)"
                    >
                      mdi-pencil
                    </v-icon>
                    <v-icon
                        small
                        @click="openWorkDelete(item)"
                    >
                      mdi-delete
                    </v-icon>
                  </template>
                </v-data-table>
              </v-sheet>
              <v-dialog v-model="createWorkDialog" max-width="500px">
                <v-card v-if="newWork">
                  <v-card-title>Create</v-card-title>
                  <v-card-text>
                    <v-autocomplete
                        v-model="newWork.organization"
                        :items="organizations"
                        hide-no-data
                        item-text="name"
                        item-value="id"
                        label="Organization"
                        placeholder="Organization"
                        prepend-inner-icon="mdi-database-search"
                        :search-input.sync="organizationSearch"
                        return-object
                        outlined
                    ></v-autocomplete>
                    <v-autocomplete
                        v-model="newWork.structureUnit"
                        :items="structureUnits"
                        hide-no-data
                        item-text="name"
                        item-value="id"
                        label="Structure Unit"
                        placeholder="Structure Unit"
                        prepend-inner-icon="mdi-database-search"
                        :search-input.sync="structureUnitSearch"
                        return-object
                        outlined
                    ></v-autocomplete>
                    <v-text-field
                        v-model="newWork.position"
                        :label="$t('placeholder.work.position')"
                        outlined
                        prepend-inner-icon="mdi-card-text-outline"
                    />
                    <v-menu ref="menu"
                            v-model="menuStart"
                            :close-on-content-click="false"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                            :value="newWork.start"
                            :label="$t('placeholder.work.start')"
                            prepend-inner-icon="mdi-calendar"
                            readonly
                            v-on="on"
                            outlined
                        />
                      </template>
                      <v-date-picker v-model="newWork.start" no-title scrollable @input="menuStart = false"/>
                    </v-menu>
                    <v-menu ref="menu"
                            v-model="menuFinish"
                            :close-on-content-click="false"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                            :value="newWork.finish"
                            :label="$t('placeholder.work.start')"
                            prepend-inner-icon="mdi-calendar"
                            readonly
                            v-on="on"
                            outlined
                        />
                      </template>
                      <v-date-picker v-model="newWork.finish" no-title scrollable @input="menuFinish = false"/>
                    </v-menu>
                  </v-card-text>
                  <v-card-actions>
                    <v-btn color="darken-1" text @click="closeCreateWorkDialog">Cancel</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text @click="createWork">Create</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import {mapState} from "vuex";

export default {
  name: "Account",
  data(){
    return {
      showCommon: true,
      showAvatar: true,
      changePassword: false,
      worksSheet: false,
      createWorkDialog: false,
      editWorkDialog: false,
      deleteWorkDialog: false,
      user: {
        first_name: '',
        second_name: '',
        surname: '',
        email: '',
        phone: '',
        desc: '',
      },
      avatar: null,
      changePasswordRequest: {
        password: '',
        password_confirmation: '',
        passwordType: 'password',
      },
      rules: {
        required: value => !!value || 'Required.',
        phone: value => {
          const pattern = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im
          return pattern.test(value) || 'Invalid phone'
        },
        min: v => v.length >= 8 || 'Min 8 characters',
        confirmation: v => v === this.changePasswordRequest.password || 'Password mismatch',
      },
      worksHeaders: [
        { text: 'Title', value: 'title' },
        { text: 'Start', value: 'start' },
        { text: 'Finish', value: 'finish' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      newWork: null,
      selectedWork: null,
      organizationSearch:'',
      structureUnitSearch: '',
      menuStart:false,
      menuFinish:false,
    }
  },
  computed: {
    ...mapState({
      works: (state) => state.account.works,
      organizations: (state) => state.organization.organizations,
      structureUnits: (state) => state.organization.structureUnits,
    }),
  },
  mounted() {
    this.user = this.$store.getters['account/getAccount'];
  },
  methods: {
    showCommonSheet() {
      this.showCommon = !this.showCommon;
    },
    showAvatarSheet() {
      this.showAvatar = !this.showAvatar;
    },
    showChangePasswordSheet() {
      this.changePassword = !this.changePassword
    },
    showWorksSheet() {
      this.worksSheet = !this.worksSheet;
      if (this.worksSheet) {
        this.$store.dispatch('account/downloadWorks');
      }
    },
    updateUser(e) {
      e.preventDefault();
      e.stopPropagation();
      this.$loading();
      this.$store.dispatch('account/update',this.user)
          .then((res) => {
            this.user = res;
            this.$loadingClose();
            this.$store.dispatch('account/downloadAccount');
            this.$notify('','success', 'Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    updateUserAvatar(e) {
      e.preventDefault();
      e.stopPropagation();
      this.$loading();
      let form = new FormData();
      form.append('photo', this.avatar);
      this.$store.dispatch('account/updatePhoto',form)
          .then((res) => {
            this.user = res;
            this.$loadingClose();
            this.$store.dispatch('account/downloadAccount');
            this.$notify('','success', 'Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    changeAvatarFile() {
      let reader = new FileReader();
      reader.readAsDataURL(this.avatar);
      reader.onload =  () => {
        this.user.avatar_url = reader.result
      };
    },
    changeUserPassword(e) {
      e.preventDefault();
      e.stopPropagation();
      this.$loading();
      this.$store.dispatch('account/updatePassword',this.changePasswordRequest)
          .then((res) => {
            this.user = res;
            this.$loadingClose();
            this.$store.dispatch('account/downloadAccount')
            this.$notify('','success','Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    openCreateWorkDialog() {
      this.createWorkDialog = true;
      this.newWork = {
        organization: null,
        structureUnit: null,
        position: '',
        start: new Date().toISOString().substr(0, 10),
        finish: new Date().toISOString().substr(0, 10),
      };
      this.$store.dispatch('organization/downloadOrganizations');
    },
    closeCreateWorkDialog() {
      this.createWorkDialog = false;
    },
    openWorkEdit (item) {
      this.editWorkDialog = true;
      this.selectedWork = item;
    },
    closeWorkEdit() {
      this.editWorkDialog = false;
      this.selectedWork = null;
    },
    openWorkDelete (item) {
      this.deleteWorkDialog = true;
      this.selectedWork = item;
    },
    closeWorkDelete() {
      this.deleteWorkDialog = false;
      this.selectedWork = null;
    },
    createWork () {
      if (this.newWork.organization === null) {
        this.newWork.organization = {
          name:this.organizationSearch,
        }
        this.newWork.structureUnit = {
          name: this.structureUnitSearch,
        }
      }
      if (this.this.newWork.structureUnit === null) {
        this.newWork.structureUnit = {
          name: this.structureUnitSearch,
        }
      }
      this.newWork.structure_unit = this.newWork.structureUnit;
      this.$loading();
      this.$store.dispatch('account/createWork',this.newWork)
          .then((res) => {
            this.user = res;
            this.$loadingClose();
            this.closeCreateWorkDialog();
            this.$notify('','success', 'Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    editWork() {

    },
    deleteWork() {

    },
  },
}
</script>

<style scoped>

</style>