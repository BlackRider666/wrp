<template>
  <v-snackbar :app="!fold" multi-line right bottom :timeout="-1" :value="show" color="primary">
    <v-row justify="end">
      <v-col>{{ $t('tutorials.header','Tutorial')}}</v-col>
      <v-col cols="2">
        <v-btn icon small @click="foldTutorial">
          <v-icon v-if="fold">mdi-chevron-up</v-icon>
          <v-icon v-else :class="needRollUp?'blink':''">mdi-chevron-down</v-icon>
        </v-btn>
      </v-col>
      <v-col cols="2">
      <v-btn icon small @click="notShowNow"><v-icon>mdi-close</v-icon></v-btn>
      </v-col>
    </v-row>
    <template v-if="!fold">
    <v-row v-if="step === 0">
      <v-col cols="12">
        <span>{{$t('tutorial.question_help','Help you fill out your account?')}}</span>
      </v-col>
      <v-col cols="6"><v-btn dark text @click="startTutorial">Yes</v-btn></v-col>
      <v-col cols="6"><v-btn dark text @click="notShowing">No</v-btn></v-col>
    </v-row>
    <v-stepper :value="step" flat outlined class="primary" v-else>
      <v-stepper-header class="without_box_shadow max-width-content" >
        <v-stepper-step
            v-for="st in steps"
            :key="st.step"
            :complete="step > st.step"
            :step="st.step"
            color="blue darken-3"
            class="pa-2"
        ></v-stepper-step>
      </v-stepper-header>

      <v-stepper-items>
        <v-stepper-content v-for="step in steps" :step="step.step" :key="step.step">
          <v-row class="max-width-content">
            <v-col cols="12">
              <span>{{$t(step.stepTKeyContent,step.stepContent)}}</span>
            </v-col>
            <v-col cols="6"><v-btn dark text @click="nextStep">{{steps[steps.length -1].step === step.step? $t('tutorials.btn.complete','Complete'):$t('tutorials.btn.next','Next')}}</v-btn></v-col>
            <v-col cols="6"><v-btn dark text @click="notShowing">{{ $t('tutorials.btn.stop', 'Stop') }}</v-btn></v-col>
          </v-row>
        </v-stepper-content>
      </v-stepper-items>
    </v-stepper>
    </template>
  </v-snackbar>
</template>

<script>
import {mapState} from "vuex";

export default {
  name: "TutorialModal",
  data() {
    return {
      steps: [
        {
          step:1,
          stepTKeyContent:'tutorials.step1.content',
          stepContent: 'Go to Account in user menu',
        },
        {
          step:2,
          stepTKeyContent:'tutorials.step2.content',
          stepContent: 'Fill in the "Common" section',
        },
        {
          step:3,
          stepTKeyContent:'tutorials.step3.content',
          stepContent: 'Add an avatar in "Avatar" section',
        },
        {
          step:4,
          stepTKeyContent:'tutorials.step4.content',
          stepContent: 'Roll up the tutorial and add your work to "Works" section, after then refresh the page to continue',
        },
        {
          step:5,
          stepTKeyContent:'tutorials.step5.content',
          stepContent: 'Roll up the tutorial and add your grant to "Grants" section, after then refresh the page to continue',
        },
        {
          step:6,
          stepTKeyContent:'tutorials.step6.content',
          stepContent: 'Roll up the tutorial and add your project to "Projects" section, after then refresh the page to continue',
        }
      ],
      fold:false,
    }
  },
  computed: {
    ...mapState({
      show: (state) => state.tutorial.show,
      step: (state) => state.tutorial.step,
    }),
    needRollUp() {
      return this.step === 4 || this.step === 5 || this.step === 6;
    }
  },
  methods: {
    startTutorial() {
      this.$store.dispatch('tutorial/start')
    },
    notShowing() {
      this.$store.dispatch('tutorial/updateShow',false);
    },
    nextStep() {
      if (this.steps[this.steps.length -1].step === this.step) {
        this.$store.dispatch('tutorial/complete');
      }
      this.$store.dispatch('tutorial/nextStep');
    },
    notShowNow()
    {
      this.$store.dispatch('tutorial/updateShowState', false);
    },
    foldTutorial()
    {
      this.fold = !this.fold;
    }
  },
}
</script>

<style scoped>
.without_box_shadow {
  box-shadow: none;
}
.max-width-content {
  max-width: 400px;
}
</style>