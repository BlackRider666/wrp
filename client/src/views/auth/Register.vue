<template>
  <v-col cols="12" md="5" sm="8">
    <v-card
        class="mx-auto pb-6"
        raised
    >
      <v-card-title class="d-flex align-center justify-center auth__top__wrapper">
        <router-link class="d-flex align-center auth__logo mt-4" :to="{name: 'dashboard'}">
          <v-img :aspect-ratio="16/9" :src="require('@/assets/logo.png')" width="90" contain="contain"/>
        </router-link>
        <v-btn size="large" variant="text" color="primary" icon="mdi-close" class="auth__btn-close" @click="$router.push({name:'dashboard'})"></v-btn>
      </v-card-title>
      <v-card-text v-if="registerStepper < 4">
        <v-row justify="center">
          <v-col cols="12" align="center">
            <div class="text-h5 font-weight-medium mb-8 mt-2">{{$t('register.title', 'Create Account')}}</div>
          </v-col>
        </v-row>
        <v-stepper v-model="registerStepper" flat>
          <template v-slot:default>
            <v-stepper-header class="auth__stepper__header">
              <v-stepper-item
                  :complete="registerStepper > 1"
                  :value="1"
              >
              </v-stepper-item>
              <v-stepper-item
                  :complete="registerStepper > 2"
                  :value="2"
              >
              </v-stepper-item>

              <v-stepper-item
                  :complete="registerStepper > 3"
                  :value="3"
              >
              </v-stepper-item>
            </v-stepper-header>

            <v-stepper-window>
              <v-stepper-window-item :value="1">
                <v-card
                    flat
                    class="mt-1 pt-2"
                >
                  <v-form
                      ref="formRegStep1"
                      lazy-validation
                      align="center"
                      @submit="nextStep"
                      aria-autocomplete="none"
                  >
                    <v-text-field
                        v-model="user.first_name"
                        :label="$t('placeholder.first_name', 'First Name')"
                        variant="outlined"
                        prepend-inner-icon="mdi-account-outline"
                        :rules="[rules.required]"
                    />
                    <v-text-field
                        v-model="user.second_name"
                        :label="$t('placeholder.second_name', 'Second Name')"
                        variant="outlined"
                        prepend-inner-icon="mdi-account-outline"
                        :rules="[rules.required]"
                        aria-autocomplete="none"
                    />
                    <v-text-field
                        v-model="user.surname"
                        :label="$t('placeholder.surname', 'Surname')"
                        variant="outlined"
                        prepend-inner-icon="mdi-account-outline"
                        :rules="[rules.required]"
                    />
                    <v-btn
                        color="primary"
                        block
                        tile
                        type="submit"
                        class="my-3"
                        :disabled="!activeContinueStep1"
                    >
                      Continue
                    </v-btn>

                    <v-btn block variant="text" color="primary" class="my-3" :to="{name:'login'}">
                      {{$t('btn.back-to-login', 'Back to Login')}}
                    </v-btn>
                  </v-form>
                </v-card>
              </v-stepper-window-item>

              <v-stepper-window-item :value="2">
                <v-card
                    flat
                    class="mt-1 pt-2"
                >
                  <v-form
                      ref="formRegStep2"
                      lazy-validation
                      align="center"
                      @submit="nextStep"
                  >
                    <v-text-field
                        v-model="user.email"
                        variant="outlined"
                        prepend-inner-icon="mdi-email-outline"
                        :label="$t('placeholder.email', 'Email')"
                        :rules="[rules.required, rules.email]"
                        :error="emailError.length > 0"
                        :error-messages="emailError"
                        @change="clearErrors"
                        type="email"
                    />
                    <v-text-field
                        v-model="user.phone"
                        :label="$t('placeholder.phone', 'Phone')"
                        variant="outlined"
                        prepend-inner-icon="mdi-phone"
                        :rules="[rules.required, rules.phone]"
                    />

                    <v-btn
                        color="primary"
                        block
                        tile
                        type="submit"
                        class="my-3"
                        :disabled="!activeContinueStep2"
                    >
                      Continue
                    </v-btn>

                    <v-btn block variant="text" color="primary" class="my-3" :to="{name:'login'}">
                      {{$t('btn.back-to-login', 'Back to Login')}}
                    </v-btn>
                  </v-form>
                </v-card>
              </v-stepper-window-item>

              <v-stepper-window-item :value="3">
                <v-card
                    flat
                    class="mt-1 pt-2"
                >
                  <v-form
                      ref="formRegStep3"
                      lazy-validation
                      align="center"
                      @submit="nextStep"
                  >
                    <v-text-field
                        v-model="user.password"
                        :rules="[rules.required, rules.min]"
                        variant="outlined"
                        prepend-inner-icon="mdi-lock"
                        color="primary"
                        :type="passwordType"
                        :label="$t('placeholder.password', 'Password')"
                    >
                      <template v-slot:append-inner>
                        <v-icon color="secondary" v-if="passwordType === 'password'" @click="passwordType = 'text'">mdi-eye</v-icon>
                        <v-icon color="primary" v-if="passwordType === 'text'" @click="passwordType = 'password'">mdi-eye</v-icon>
                      </template>
                    </v-text-field>
                    <v-text-field
                        v-model="user.password_confirmation"
                        :type="passwordType"
                        :label="$t('placeholder.password_confirmation', 'Confirm Password')"
                        color="primary"
                        variant="outlined"
                        prepend-inner-icon="mdi-lock"
                        :rules="[rules.required, rules.min, rules.confirmation]"
                    />
                    <v-btn
                        color="primary"
                        block
                        tile
                        @click="nextStep"
                        class="my-3"
                        :disabled="!activeContinueStep3"
                    >
                      Continue
                    </v-btn>

                    <v-btn block variant="text" color="primary" class="my-3" :to="{name:'login'}">
                      {{$t('btn.back-to-login', 'Back to Login')}}
                    </v-btn>
                  </v-form>
                </v-card>
              </v-stepper-window-item>
            </v-stepper-window>
          </template>
        </v-stepper>
      </v-card-text>
      <v-card-text v-else>
        <v-checkbox v-model="registerContractSuccess">
          <template v-slot:label>
          {{$t('btn.register-agree', 'By registering I agree to the')}} <router-link :to="{name:'dashboard'}" class="auth__contract-link">{{$t('link.register-contract', 'contract, rules, and conditions of use of the WRP platform')}}</router-link>
        </template>
        </v-checkbox>
        <v-btn color="primary" :disabled="!registerContractSuccess" block @click="verifyRegister">{{$t('btn.register', 'Register')}}</v-btn>
      </v-card-text>
    </v-card>
  </v-col>
</template>

<script>
import {mapActions} from "pinia";
import {useAccountStore} from "@/stores/account";
import {useAuthStore} from "@/stores/auth";

export default {
  name: "Register",
  data: function () {
    return {
      user: {
        first_name:'',
        second_name:'',
        surname:'',
        email:'',
        phone:'',
        password:'',
        password_confirmation:'',
      },
      emailError: [],
      passwordType: 'password',
      registerStepper: 1,
      registerContractSuccess: false,
      rules: {
        required: value => !!value || 'Required.',
        min: v => v.length >= 8 || 'Min 8 characters',
        email: value => {
          const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
          return pattern.test(value) || 'Invalid e-mail.'
        },
        confirmation: v => v === this.user.password || 'Password mismatch',
        phone: value => {
          const pattern = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im
          return pattern.test(value) || 'Invalid phone'
        }
      },
    }
  },
  methods: {
    async register() {
      let response;
      this.$loading();
      await this.registerStore(this.user)
          .then(() => {
            this.$loadingClose();
            response = true;
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('', 'error', error.response.data.message);
            this.emailError = error.response.data.errors.email;
            response = false;
          })
      return response;
    },
    async verifyRegister(e) {
      e.preventDefault();
      e.stopPropagation();
      this.$loading();
      await this.verifyRegisterStore(this.user)
          .then(() => {
            this.$loadingClose();
            this.downloadAccount();
            localStorage.removeItem('regUser')
            localStorage.removeItem('regStep')
            this.$router.push({name:'dashboard'})
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('', 'error', error.response.data.message);
          })
    },
    async nextStep(e) {
      e.preventDefault();
      e.stopPropagation();
      switch (this.registerStepper) {
        case 1:
          if (!this.$refs.formRegStep1.validate()) return;
          break;
        case 2:
          if (!this.$refs.formRegStep2.validate()) return;
          let registered = await this.register();
          if (!registered) return;
          break;
        case 3:
          if (!this.$refs.formRegStep3.validate()) return;
          break;
        default:
          return;
      }
      this.registerStepper += 1;
      localStorage.setItem('regUser', JSON.stringify(this.user));
      localStorage.setItem('regStep', this.registerStepper);
    },
    clearErrors() {
      this.emailError = [];
    },
    ...mapActions(useAccountStore,['downloadAccount']),
    ...mapActions(useAuthStore,{
      registerStore:'register',
      verifyRegisterStore:'verifyRegister',
    })
  },
  created() {
    let regUser = localStorage.getItem('regUser');
    let regStep = localStorage.getItem('regStep')
    if (regUser) {
      this.user = JSON.parse(regUser);
    }
    if (regStep) {
      this.registerStepper = parseInt(regStep);
    }
  },
  computed: {
    activeContinueStep1() {
      return this.user.first_name !== '' && this.user.second_name !== '' && this.user.surname !== '';
    },
    activeContinueStep2() {
      return this.user.email !== '' && this.user.phone !== '';
    },
    activeContinueStep3() {
      return this.user.password !== '' && this.user.password_confirmation !== '';
    }
  }
}
</script>

<style lang="scss">
.auth {
  &__logo {
    text-decoration: none;
  }
  &__stepper {
    &__header {
      box-shadow: none;
    }
  }
  &__contract-link {
    display: contents;
  }
  &__top__wrapper {
    position: relative;
    margin-right: 24px;
    margin-left: 24px;
  }
  &__btn-close {
    position: absolute;
    top: 32px;
    right: 16px;
  }
}
</style>
