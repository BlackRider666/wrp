<template>
  <v-col cols="12" md="5" sm="8">
    <v-card
        class="mx-auto"
        raised
        outlined
    >
      <v-card-title class="d-flex align-center justify-center">
        <router-link class="d-flex align-center auth__logo py-5" :to="{name: 'dashboard'}">
          <h2 class="text-2xl font-weight-semibold">WRP</h2>
        </router-link>
      </v-card-title>
      <v-card-text>
        <v-row justify="center">
          <v-col cols="6" align="center">
            <div class="headline">{{$t('register.create-acc')}}</div>
          </v-col>
        </v-row>
        <v-form
            ref="form"
            lazy-validation
            align="center"
            @submit="register"
        >
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
              :rules="[rules.required, rules.email]"
              type="email"
          />
          <v-text-field
              v-model="user.phone"
              :label="$t('placeholder.phone')"
              outlined
              prepend-inner-icon="mdi-phone"
              :rules="[rules.required, rules.phone]"
          />
          <v-text-field
              v-model="user.password"
              :rules="[rules.required, rules.min]"
              outlined
              prepend-inner-icon="mdi-lock"
              color="primary"
              :type="passwordType"
              :label="$t('placeholder.password')"
          >
            <template v-slot:append>
              <v-icon color="secondary" v-if="passwordType === 'password'" @click="passwordType = 'text'">mdi-eye</v-icon>
              <v-icon color="primary" v-if="passwordType === 'text'" @click="passwordType = 'password'">mdi-eye</v-icon>
            </template>
          </v-text-field>
          <v-text-field
              v-model="user.password_confirmation"
              :type="passwordType"
              :label="$t('placeholder.password_confirmation')"
              color="primary"
              outlined
              prepend-inner-icon="mdi-lock"
              :rules="[rules.required, rules.min, rules.confirmation]"
          />
          <v-row class="mt-3">
            <v-col class="text-md-left">
              <v-btn outlined color="primary" :to="{name: 'login'}">
                {{$t('btn.go-back-to-login')}}
              </v-btn>
            </v-col>
            <v-col class="text-md-right">
              <v-btn type="submit" color="primary">
                {{$t('btn.register')}}
              </v-btn>
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
    </v-card>
  </v-col>
</template>

<script>
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
      passwordType: 'password',
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
    register(e) {
      e.preventDefault();
      e.stopPropagation();
      if (!this.$refs.form.validate()) return;
      this.$loading();
      this.$store.dispatch('auth/register',this.user)
          .then(() => {
            this.$loadingClose();
            this.$store.dispatch('account/downloadAccount')
            this.$router.push({name:'dashboard'})
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

<style lang="scss">
.auth {
  &__logo {
    text-decoration: none;
  }
}
</style>