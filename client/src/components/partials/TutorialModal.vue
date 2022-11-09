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
      <v-btn icon small @click="notShowing"><v-icon>mdi-close</v-icon></v-btn>
      </v-col>
    </v-row>
    <template v-if="!fold">
    <template v-if="selectedTutorial && step !== 0">
      <TutorialStepper :tutorial="selectedTutorial"></TutorialStepper>
    </template>
    <v-row v-else class="max-width-content">
      <v-col cols="12">
        <span>{{$t('tutorial.question_help','Help you fill out your account? Choose a tutorial to continue!')}}</span>
      </v-col>
      <v-col cols="12">
        <v-radio-group :value="selectedTutorial" @change="selectTutorial" class="mt-0">
          <v-radio
              v-for="tutorial in tutorials"
              :key="tutorial.value"
              :label="$t('tutorial.select.placeholder.'+tutorial.value,tutorial.text)"
              :value="tutorial.value"
          ></v-radio>
        </v-radio-group>
      </v-col>
      <v-col cols="6"><v-btn dark text :disabled="!selectedTutorial" @click="startTutorial">Yes</v-btn></v-col>
      <v-col cols="6"><v-btn dark text @click="notShowing">No</v-btn></v-col>
    </v-row>
    </template>
  </v-snackbar>
</template>

<script>
import {mapState} from "vuex";
import TutorialStepper from "./TutorialStepper";

export default {
  name: "TutorialModal",
  components:{
    TutorialStepper,
  },
  data() {
    return {
      tutorials:[
        {
          value:'account',
          text:'Account',
        },
        {
          value:'article',
          text:'Article',
        },
      ],
      fold:false,
    }
  },
  computed: {
    ...mapState({
      show: (state) => state.tutorial.show,
      step: (state) => state.tutorial.step,
      selectedTutorial: (state) => state.tutorial.tutorialCategory,
    }),
    needRollUp() {
      return (this.step === 4 || this.step === 5 || this.step === 6) && this.selectedTutorial === 'account';
    }
  },
  methods: {
    startTutorial() {
      this.$store.dispatch('tutorial/start', this.selectedTutorial)
    },
    notShowing() {
      this.$store.dispatch('tutorial/updateShow',false);
    },
    foldTutorial() {
      this.fold = !this.fold;
    },
    selectTutorial(item) {
      this.$store.dispatch('tutorial/selectTutorial',item)
    }
  },
}
</script>

<style>
.max-width-content {
  max-width: 450px;
}
</style>