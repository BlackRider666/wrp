<template>
  <v-stepper v-if="step !== null" :value="step" flat outlined class="primary min-with-content">
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
        </v-row>
      </v-stepper-content>
    </v-stepper-items>
    <v-row class="max-width-content pt-2">
      <v-col cols="6"><v-btn dark block text @click="nextStep">{{steps[steps.length -1].step === step? $t('tutorials.btn.complete','Complete'):$t('tutorials.btn.next','Next')}}</v-btn></v-col>
      <v-col cols="6"><v-btn dark block text @click="backToChoose">{{ $t('tutorials.btn.back_to_choose', 'Back To Choose') }}</v-btn></v-col>
    </v-row>
  </v-stepper>
</template>

<script>
import {mapState} from "vuex";

export default {
  name: "TutorialStepper",
  props:{
      tutorial: {
        default: '',
        type: String,
      }
  },
  data() {
    return {
      steps:[],
    };
  },
  computed: {
    ...mapState({
      step: (state) => state.tutorial.step,
    }),
  },
  methods: {
    nextStep() {
      if (this.steps[this.steps.length -1].step === this.step) {
        this.$store.dispatch('tutorial/complete');
      }
      this.$store.dispatch('tutorial/nextStep');
    },
    backToChoose() {
      this.$store.dispatch('tutorial/complete');
    }
  },
  mounted() {
    let steps = require('./tutorialSteps/'+this.tutorial+'.js');
    this.steps = steps.default
  }
}
</script>

<style scoped>
.without_box_shadow {
  box-shadow: none;
}
.min-with-content {
  min-width: 400px;
}
</style>