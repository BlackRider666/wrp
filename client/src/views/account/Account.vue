<template>
  <v-row>
<!--    <Occupancy/>-->
    <v-col cols="12">
      <v-card>
        <v-card-title>
          {{$t('account.title','Account Settings')}}
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="6">
              <v-toolbar dense dark color="primary" class="pl-2">
<!--              <v-toolbar dense dark color="primary" :class="fillCommon?'blink':''"  class="pl-2">-->
                {{$t('account.common-title','Common')}}
                <v-spacer/>
                <v-btn :icon="showCommon?'mdi-chevron-up':'mdi-chevron-down'" @click="showCommonSheet"></v-btn>
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
                    <v-tabs v-model="activePositionTab" align-tabs="end" class="pb-1" selected-class="text-primary">
                      <v-tab key="en">English</v-tab>
                      <v-tab key="uk">Українська</v-tab>
                    </v-tabs>
                    <v-window v-model="activePositionTab" class="pt-2">
                      <v-window-item key="en">
                        <v-text-field
                            v-model="user.first_name.en"
                            :label="$t('placeholder.first_name', 'First Name')"
                            variant="outlined"
                            prepend-inner-icon="mdi-account-outline"
                            :rules="[rules.required]"
                        />
                        <v-text-field
                            v-model="user.second_name.en"
                            :label="$t('placeholder.second_name', 'Second Name')"
                            variant="outlined"
                            prepend-inner-icon="mdi-account-outline"
                            :rules="[rules.required]"
                            aria-autocomplete="none"
                        />
                        <v-text-field
                            v-model="user.surname.en"
                            :label="$t('placeholder.surname', 'Surname')"
                            variant="outlined"
                            prepend-inner-icon="mdi-account-outline"
                            :rules="[rules.required]"
                        />
                      </v-window-item>
                      <v-window-item key="uk">
                        <v-text-field
                            v-model="user.first_name.uk"
                            :label="$t('placeholder.first_name', 'First Name')"
                            variant="outlined"
                            prepend-inner-icon="mdi-account-outline"
                            :rules="[rules.required]"
                        />
                        <v-text-field
                            v-model="user.second_name.uk"
                            :label="$t('placeholder.second_name', 'Second Name')"
                            variant="outlined"
                            prepend-inner-icon="mdi-account-outline"
                            :rules="[rules.required]"
                            aria-autocomplete="none"
                        />
                        <v-text-field
                            v-model="user.surname.uk"
                            :label="$t('placeholder.surname', 'Surname')"
                            variant="outlined"
                            prepend-inner-icon="mdi-account-outline"
                            :rules="[rules.required]"
                        />
                      </v-window-item>
                    </v-window>
                    <v-text-field
                        v-model="user.email"
                        variant="outlined"
                        prepend-inner-icon="mdi-email-outline"
                        :label="$t('placeholder.email', 'Email')"
                        type="email"
                        disabled
                    />
                    <v-text-field
                        v-model="user.phone"
                        :label="$t('placeholder.phone', 'Phone')"
                        variant="outlined"
                        prepend-inner-icon="mdi-phone"
                        :rules="[rules.required, rules.phone]"
                    />
                    <v-tabs v-model="activePositionTab" align-tabs="end" class="pb-1" selected-class="text-primary">
                      <v-tab key="en">English</v-tab>
                      <v-tab key="uk">Українська</v-tab>
                    </v-tabs>
                    <v-window v-model="activePositionTab" class="pt-2">
                      <v-window-item key="en">
                        <simple-editor
                            v-model="user.desc.en"
                            :placeholder="$t('placeholder.desc', 'Desc')"
                        ></simple-editor>
                      </v-window-item>
                      <v-window-item key="uk">
                        <simple-editor
                            v-model="user.desc.uk"
                            :placeholder="$t('placeholder.desc', 'Desc')"
                        ></simple-editor>
                      </v-window-item>
                    </v-window>
                    <v-select
                        v-model="user.degree"
                        :label="$t('placeholder.degree', 'Degree')"
                        variant="outlined"
                        prepend-inner-icon="mdi-account"
                        :items="degrees"
                        :item-title="item => item.value ? $t('placeholder.degree.'+ item.value, item.value): null"

                    ></v-select>
                    <v-text-field
                        v-model="user.position"
                        :label="$t('placeholder.position', 'Position')"
                        variant="outlined"
                        prepend-inner-icon="mdi-account"
                    />
                    <v-autocomplete
                        v-model="user.organization_id"
                        :items="organizations"
                        hide-no-data
                        :item-title="`name.${locale.iso_code}`"
                        item-value="id"
                        :label="$t('placeholder.organization','Organization')"
                        :placeholder="$t('works.placeholder.organization','Organization')"
                        prepend-inner-icon="mdi-database-search"
                        :search-input="organizationSearch"
                        variant="outlined"
                    ></v-autocomplete>
                    <v-select
                        v-model="user.country_id"
                        :items="countries"
                        :item-title="`name[${locale.iso_code}]`"
                        item-value="id"
                        :label="$t('placeholder.country','Country')"
                        prepend-inner-icon="mdi-database-search"
                        variant="outlined"
                    ></v-select>
                    <v-select
                        v-model="user.city_id"
                        :items="cities"
                        :item-title="`name[${locale.iso_code}]`"
                        item-value="id"
                        :label="$t('placeholder.city','City')"
                        prepend-inner-icon="mdi-database-search"
                        variant="outlined"
                    ></v-select>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" type="submit">{{$t('btn.update','Update')}}</v-btn>
<!--                    <v-btn color="primary" :class="fillCommon?'blink':''" type="submit">{{$t('btn.update','Update')}}</v-btn>-->
                  </v-card-actions>
                </v-card>
                </v-form>
              </v-sheet>
            </v-col>
            <v-col cols="6">
              <v-row>
                <v-col cols="12">
                  <v-toolbar dense dark color="primary"  class="pl-2">
<!--                  <v-toolbar dense dark :class="fillAvatar?'blink':''" color="primary"  class="pl-2">-->
                    {{$t('avatar.title','Avatar')}}
                    <v-spacer/>
                    <v-btn icon @click="showAvatarSheet">
                      <v-icon v-if="showAvatar">mdi-chevron-up</v-icon>
                      <v-icon v-else>mdi-chevron-down</v-icon>
<!--                      <v-icon v-else :class="fillAvatar?'blink':''">mdi-chevron-down</v-icon>-->
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
<!--                        <v-avatar-->
<!--                            size="128"-->
<!--                            class="my-2"-->
<!--                            :class="fillAvatar?'blink':''"-->
<!--                        >-->
                          <v-img :src="user.avatar_url" />
                        </v-avatar>
                        <v-file-input
                            :rules="[rules.required]"
                            accept="image/png, image/jpeg, image/bmp"
                            placeholder="Pick an avatar"
                            prepend-inner-icon="mdi-camera"
                            prepend-icon=""
                            :label="$t('placeholder.avatar','Avatar')"
                            variant="outlined"
                            v-model="avatar"
                            @change="changeAvatarFile"
                        ></v-file-input>
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" type="submit">{{$t('btn.update','Update')}}</v-btn>
<!--                        <v-btn color="primary" :class="fillAvatar?'blink':''" type="submit">{{$t('btn.update','Update')}}</v-btn>-->
                      </v-card-actions>
                    </v-card>
                    </v-form>
                  </v-sheet>
                </v-col>
                <v-col cols="12">
                  <v-toolbar dark dense color="primary"  class="pl-2">
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
                            variant="outlined"
                            prepend-inner-icon="mdi-lock"
                            color="primary"
                            :type="changePasswordRequest.passwordType"
                            :label="$t('placeholder.password', 'Password')"
                        >
                          <template v-slot:append-inner>
                            <v-icon color="secondary" v-if="changePasswordRequest.passwordType === 'password'" @click="changePasswordRequest.passwordType = 'text'">mdi-eye</v-icon>
                            <v-icon color="primary" v-if="changePasswordRequest.passwordType === 'text'" @click="changePasswordRequest.passwordType = 'password'">mdi-eye</v-icon>
                          </template>
                        </v-text-field>
                        <v-text-field
                            v-model="changePasswordRequest.password_confirmation"
                            :type="changePasswordRequest.passwordType"
                            :label="$t('placeholder.password_confirmation', 'Confirm Password')"
                            color="primary"
                            variant="outlined"
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
            <Work/>
            <Grant/>
            <Project/>
            <SocialLink/>
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import Grant from "@/views/account/Grant.vue";
import Project from "@/views/account/Project.vue";
import Work from "@/views/account/Work.vue";
import Occupancy from "./Occupancy.vue";
import SocialLink from "./SocialLink.vue";
import {mapActions, mapState} from "pinia";
import SimpleEditor from "@/components/editor/SimpleEditor.vue";
import {useCountryStore} from "@/stores/country";
import {useCityStore} from "@/stores/city";
import {useOrganizationStore} from "@/stores/organization";
import {useAccountStore} from "@/stores/account";
import {useLocalesStore} from "@/stores/l10s";
import {useUserStore} from "@/stores/user";

export default {
  name: "Account",
  components: {
    SimpleEditor,
    SocialLink,
    Project,
    Grant,
    Work,
    Occupancy,
  },
  data(){
    return {
      showCommon: true,
      showAvatar: true,
      changePassword: false,
      organizationSearch:'',
      user: {
        first_name: {
          en:'',
          uk:'',
        },
        second_name: {
          en:'',
          uk:'',
        },
        surname: {
          en:'',
          uk:'',
        },
        email: '',
        phone: '',
        desc: {
          en:'',
          uk:'',
        },
        degree:null,
        position:'',
        country_id: null,
        city_id:null,
        organization_id: null,
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
      activePositionTab: 'en',
    }
  },
  created() {
    this.user = useAccountStore().user;
    if (!this.user.desc) this.user.desc = {
      en:'',
      uk:'',
    };
    this.user.country_id = this.user.country?this.user.country.id:null;
    this.downloadCountries();
    this.downloadOrganizations();
    this.downloadDegrees();
  },
  computed: {
    // fillCommon() {
    //   return this.$store.state.tutorial.step === 2 && this.$store.state.tutorial.tutorialCategory === 'account';
    // },
    // fillAvatar() {
    //   return this.$store.state.tutorial.step === 3 && this.$store.state.tutorial.tutorialCategory === 'account';
    // },
    ...mapState(useCountryStore,['countries']),
    ...mapState(useCityStore,['cities']),
    ...mapState(useOrganizationStore,['organizations']),
    ...mapState(useLocalesStore,['locale']),
    ...mapState(useUserStore,['degrees']),
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
      this.update(this.user)
          .then((res) => {
            this.user = res;
            this.$loadingClose();
            this.downloadAccount();
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
      this.updatePhoto(form)
          .then((res) => {
            this.user = res;
            this.$loadingClose();
            this.downloadAccount();
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
      this.updatePassword(this.changePasswordRequest)
          .then((res) => {
            this.user = res;
            this.$loadingClose();
            this.downloadAccount()
            this.$notify('','success','Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    ...mapActions(useCountryStore,['downloadCountries']),
    ...mapActions(useCityStore,['downloadCities']),
    ...mapActions(useOrganizationStore,['downloadOrganizations']),
    ...mapActions(useAccountStore,['downloadAccount','update','updatePhoto','updatePassword']),
    ...mapActions(useUserStore,['downloadDegrees'])
  },
  watch: {
    'user.country_id': {
      handler () {
        this.downloadCities();
      },
      deep: true,
    },
  },
}
</script>

<style scoped>

</style>
