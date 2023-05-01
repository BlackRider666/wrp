<template>
  <v-col cols="12" md="5" sm="8">
    <v-card
        class="mx-auto px-6 pb-6"
        raised
        outlined
    >
      <v-card-title class="d-flex align-center justify-center auth__top__wrapper">
        <router-link class="d-flex align-center auth__logo mt-4" :to="{name: 'dashboard'}">
          <v-img :aspect-ratio="16/9" :src="require('@/assets/logo.png')" width="90" contain="contain"/>
        </router-link>
        <v-btn large color="primary" icon class="auth__btn-close" @click="$router.push({name:'dashboard'})"><v-icon>mdi-close</v-icon></v-btn>
      </v-card-title>
      <v-card-text>
            <v-row justify="center">
              <v-col cols="12" align="center">
                <div class="text-h5 font-weight-medium mb-8 mt-2">{{$t('login.title', 'Login')}}</div>
              </v-col>
            </v-row>
            <v-form
                ref="form"
                lazy-validation
                align="center"
                @submit="login"
            >
              <v-text-field
                  v-model="user.email"
                  outlined
                  prepend-inner-icon="mdi-email-outline"
                  :label="$t('placeholder.email', 'Email')"
                  :rules="[rules.required, rules.email]"
                  type="email"
              />

              <v-text-field
                  v-model="user.password"
                  :rules="[rules.required]"
                  outlined
                  prepend-inner-icon="mdi-lock"
                  color="primary"
                  :type="passwordType"
                  :label="$t('placeholder.password', 'Password')"
              >
                <template v-slot:append>
                  <v-icon color="secondary" v-if="passwordType === 'password'" @click="passwordType = 'text'">mdi-eye</v-icon>
                  <v-icon color="primary" v-if="passwordType === 'text'" @click="passwordType = 'password'">mdi-eye</v-icon>
                </template>
              </v-text-field>
              <v-btn type="submit" class="my-3 auth__btn" block tile>
                {{$t('btn.login', 'Login')}}
              </v-btn>
              <v-btn @click="$router.push({name: 'register'})" class="my-3" color="primary" text block tile>
                {{$t('btn.register', 'Register')}}
              </v-btn>
            </v-form>
            <v-divider/>
            <v-btn color="primary" text block tile class="mt-3">{{$t('btn.forgot-password', 'Forgot Password')}}</v-btn>
      </v-card-text>
    </v-card>
  </v-col>
</template>

<script>
export default {
  name: "Login",
  data: function () {
    return {
      user: {
        email: '',
        password: '',
      },
      passwordType: 'password',
      rules: {
        required: value => !!value || 'Required.',
        email: value => {
          const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
          return pattern.test(value) || 'Invalid e-mail.'
        },
      },
    }
  },
  methods: {
    login(e) {
      e.preventDefault();
      e.stopPropagation();
      if (!this.$refs.form.validate()) return;
      this.$loading();
      this.$store.dispatch('auth/login',this.user)
          .then(() => {
            this.$loadingClose();
            this.$store.dispatch('account/downloadAccount');
            this.$router.push({name:'dashboard'});
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })

    },
  },
  mounted() {

  },
}
</script>

<style lang="scss" scoped>
.auth {
  &__btn {
    font-weight: 500;
    box-shadow: none;
    transition: all 0.2s ease-in-out;
  &:hover {
    color: #fff;
    background: #1976D2;
  }
  }
  &__top__wrapper {
    position: relative;
  }
  &__btn-close {
    position: absolute;
    top: 32px;
    right: 16px;
  }
}
</style>
