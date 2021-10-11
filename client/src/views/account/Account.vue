<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <v-card-title>
          {{$t('account.title','Account Settings')}}
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="6">
              <v-toolbar dense color="primary">
                {{$t('account.common-title','Common')}}
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
                        :label="$t('placeholder.first_name', 'First Name')"
                        outlined
                        prepend-inner-icon="mdi-account-outline"
                        :rules="[rules.required]"
                    />
                    <v-text-field
                        v-model="user.second_name"
                        :label="$t('placeholder.second_name', 'Second Name')"
                        outlined
                        prepend-inner-icon="mdi-account-outline"
                        :rules="[rules.required]"
                    />
                    <v-text-field
                        v-model="user.surname"
                        :label="$t('placeholder.surname', 'Surname')"
                        outlined
                        prepend-inner-icon="mdi-account-outline"
                        :rules="[rules.required]"
                    />
                    <v-text-field
                        v-model="user.email"
                        outlined
                        prepend-inner-icon="mdi-email-outline"
                        :label="$t('placeholder.email', 'Email')"
                        type="email"
                        disabled
                    />
                    <v-text-field
                        v-model="user.phone"
                        :label="$t('placeholder.phone', 'Phone')"
                        outlined
                        prepend-inner-icon="mdi-phone"
                        :rules="[rules.required, rules.phone]"
                    />
                    <v-textarea
                        v-model="user.desc"
                        :label="$t('placeholder.desc', 'Desc')"
                        outlined
                        prepend-inner-icon="mdi-card-text-outline"
                        :rules="[rules.required]"
                    ></v-textarea>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" type="submit">{{$t('btn.update','Update')}}</v-btn>
                  </v-card-actions>
                </v-card>
                </v-form>
              </v-sheet>
            </v-col>
            <v-col cols="6">
              <v-row>
                <v-col cols="12">
                  <v-toolbar dense color="primary">
                    {{$t('avatar.title','Avatar')}}
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
                            :label="$t('placeholder.avatar','Avatar')"
                            outlined
                            v-model="avatar"
                            @change="changeAvatarFile"
                        ></v-file-input>
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" type="submit">{{$t('btn.update','Update')}}</v-btn>
                      </v-card-actions>
                    </v-card>
                    </v-form>
                  </v-sheet>
                </v-col>
                <v-col cols="12">
                  <v-toolbar dense color="primary">
                    {{$t('change-password.title','Change password')}}
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
                            :label="$t('placeholder.password', 'Password')"
                        >
                          <template v-slot:append>
                            <v-icon color="secondary" v-if="changePasswordRequest.passwordType === 'password'" @click="changePasswordRequest.passwordType = 'text'">mdi-eye</v-icon>
                            <v-icon color="primary" v-if="changePasswordRequest.passwordType === 'text'" @click="changePasswordRequest.passwordType = 'password'">mdi-eye</v-icon>
                          </template>
                        </v-text-field>
                        <v-text-field
                            v-model="changePasswordRequest.password_confirmation"
                            :type="changePasswordRequest.passwordType"
                            :label="$t('placeholder.password_confirmation', 'Confirm Password')"
                            color="primary"
                            outlined
                            prepend-inner-icon="mdi-lock"
                            :rules="[rules.required, rules.min, rules.confirmation]"
                        />
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" type="submit">{{$t('btn.change','Change')}}</v-btn>
                      </v-card-actions>
                    </v-card>
                    </v-form>
                  </v-sheet>
                </v-col>
              </v-row>
              </v-col>
            <v-col cols="12">
              <v-toolbar dense color="primary">
                {{$t('works.title','Works')}}
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
                          <v-card-title>{{$t('works.edit.title','Edit')}}</v-card-title>
                          <v-card-text v-if="selectedWork">
                            <v-autocomplete
                                v-model="selectedWork.organization"
                                :items="organizations"
                                hide-no-data
                                item-text="name"
                                item-value="id"
                                :label="$t('works.placeholder.organization','Organization')"
                                :placeholder="$t('works.placeholder.organization','Organization')"
                                prepend-inner-icon="mdi-database-search"
                                :search-input="organizationSearch"
                                @update:search-input="(value) => changeOrganization(value)"
                                return-object
                                outlined
                            ></v-autocomplete>
                            <v-autocomplete
                                v-model="selectedWork.structure_unit"
                                :items="structureUnits"
                                hide-no-data
                                item-text="name"
                                item-value="id"
                                :label="$t('works.placeholder.structure-unit','Structure Unit')"
                                :placeholder="$t('works.placeholder.structure-unit','Structure Unit')"
                                prepend-inner-icon="mdi-database-search"
                                :search-input="structureUnitSearch"
                                @update:search-input="(value) => changeStructureUnit(value)"
                                return-object
                                outlined
                            ></v-autocomplete>
                            <v-text-field
                                v-model="selectedWork.position"
                                :label="$t('works.placeholder.position','Position')"
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
                                    :value="selectedWork.start"
                                    :label="$t('works.placeholder.start', 'Worked from')"
                                    prepend-inner-icon="mdi-calendar"
                                    readonly
                                    v-on="on"
                                    outlined
                                />
                              </template>
                              <v-date-picker v-model="selectedWork.start" no-title scrollable @input="menuStart = false"/>
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
                                    :value="selectedWork.finish"
                                    :label="$t('works.placeholder.finish','Worked Until')"
                                    prepend-inner-icon="mdi-calendar"
                                    readonly
                                    v-on="on"
                                    outlined
                                />
                              </template>
                              <v-date-picker v-model="selectedWork.finish" no-title scrollable @input="menuFinish = false"/>
                            </v-menu>
                          </v-card-text>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="darken-1" text @click="closeWorkEdit">{{$t('btn.cancel','Cancel')}}</v-btn>
                            <v-btn color="darken-1" text @click="editWork">{{$t('btn.update','Update')}}</v-btn>
                            <v-spacer></v-spacer>
                          </v-card-actions>
                        </v-card>
                      </v-dialog>
                    <v-dialog v-model="deleteWorkDialog" max-width="500px">
                      <v-card>
                        <v-card-title>{{$t('works.delete.title','Delete')}}</v-card-title>
                        <v-card-text>{{$t('works.delete.message','Are you sure you want to delete this work?')}}</v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn color="darken-1" text @click="closeWorkDelete">{{$t('btn.cancel','Cancel')}}</v-btn>
                          <v-btn color="error" text @click="deleteWork">{{$t('btn.delete','Delete')}}</v-btn>
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
                  <v-card-title>{{$t('works.create.title','Create')}}</v-card-title>
                  <v-card-text>
                    <v-autocomplete
                        v-model="newWork.organization"
                        :items="organizations"
                        hide-no-data
                        item-text="name"
                        item-value="id"
                        :label="$t('works.placeholder.organization','Organization')"
                        :placeholder="$t('works.placeholder.organization','Organization')"
                        prepend-inner-icon="mdi-database-search"
                        :search-input="organizationSearch"
                        @update:search-input="(value) => changeOrganization(value)"
                        return-object
                        outlined
                    ></v-autocomplete>
                    <v-autocomplete
                        v-model="newWork.structure_unit"
                        :items="structureUnits"
                        hide-no-data
                        item-text="name"
                        item-value="id"
                        :label="$t('works.placeholder.structure-unit','Structure Unit')"
                        :placeholder="$t('works.placeholder.structure-unit','Structure Unit')"
                        prepend-inner-icon="mdi-database-search"
                        :search-input="structureUnitSearch"
                        @update:search-input="(value) => changeStructureUnit(value)"
                        return-object
                        outlined
                    ></v-autocomplete>
                    <v-text-field
                        v-model="newWork.position"
                        :label="$t('works.placeholder.position','Position')"
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
                            :label="$t('works.placeholder.start', 'Worked from')"
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
                            :label="$t('works.placeholder.finish','Worked Until')"
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
                    <v-btn color="darken-1" text @click="closeCreateWorkDialog">{{$t('btn.cancel','Cancel')}}</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text @click="createWork">{{$t('btn.create','Create')}}</v-btn>
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
        structure_unit: null,
        position: '',
        start: new Date().toISOString().substr(0, 10),
        finish: null,
      };
      this.$store.dispatch('organization/downloadOrganizations');
    },
    closeCreateWorkDialog() {
      this.createWorkDialog = false;
    },
    openWorkEdit (item) {
      this.editWorkDialog = true;
      this.selectedWork = item;
      this.selectedWork.organization = this.selectedWork.unit.organization;
      this.selectedWork.structure_unit = this.selectedWork.unit;
      this.$store.dispatch('organization/downloadOrganizations');
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
      this.$loading();
      this.$store.dispatch('account/updateWork',this.selectedWork)
          .then((res) => {
            this.user = res;
            this.$loadingClose();
            this.closeWorkEdit();
            this.$notify('','success', 'Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    deleteWork() {
      this.$loading();
      this.$store.dispatch('account/deleteWork',this.selectedWork.id)
          .then((res) => {
            this.user = res;
            this.$loadingClose();
            this.closeWorkDelete();
            this.$notify('','success', 'Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    changeOrganization(item) {
      if (item) {
        let organization = this.organizations.find((o) => o.name === item);
        if (!organization) {
          if (this.createWorkDialog) this.newWork.structure_unit = null;
          if (this.editWorkDialog) this.selectedWork.structure_unit = null;
          let org = this.organizations.find((i) => i.id === 'new');
          if (org) {
            org.name = item;
          } else {
            this.organizations.push({id:'new',name:item});
          }
        }
      }
    },
    changeStructureUnit(item) {
      if (item) {
        let unit = this.structureUnits.find((u) => u.name === item);
        if (!unit) {
          let structureUnit = this.structureUnits.find((i) => i.id === 'new');
          if (structureUnit) {
            structureUnit.name = item;
          } else {
            this.structureUnits.push({id:'new',name:item});
          }
        }
      }
    },
  },
  watch: {
    'newWork.organization'(item) {
      if (item) {
        if (item.id !== 'new') {
          this.$store.dispatch('organization/downloadStructureUnits',item.id)
        } else {
          this.$store.dispatch('organization/clearStructureUnits');
        }
      }
    },
    'selectedWork.organization'(item) {
      if (item) {
        if (item.id !== 'new') {
          this.$store.dispatch('organization/downloadStructureUnits',item.id)
        } else {
          this.$store.dispatch('organization/clearStructureUnits');
        }
      }
    },
  },
}
</script>

<style scoped>

</style>