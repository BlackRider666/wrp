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
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "Account",
  data(){
    return {
      showCommon: true,
      showAvatar: true,
      changePassword: false,
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
    }
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
  },
}
</script>

<style scoped>

</style>