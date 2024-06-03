<template>
  <v-list-item :key="unit.id" variant="tonal" class="my-1">
      <div class="d-flex align-center">
        <v-list-item-title class="flex-1-0">{{ unit.name[locale.iso_code] }}</v-list-item-title>
        <v-btn
            v-if="unit.child && unit.child.length"
            :icon="isOpen ? 'mdi-chevron-down' : 'mdi-chevron-right'"
            variant="text"
            @click="toggle"
            size="small"
            density="comfortable"
        ></v-btn>
        <v-btn icon="mdi-pencil" variant="text" color="warning" size="small" density="comfortable" @click="editItem(unit)"></v-btn>
        <v-btn icon="mdi-plus" variant="text" color="primary" size="small" density="comfortable" @click="addItem(unit)"></v-btn>
        <v-btn icon="mdi-delete" variant="text" color="error" size="small" density="comfortable" @click="deleteItem(unit)"></v-btn>
      </div>
  </v-list-item>
  <v-slide-y-transition>
    <v-list v-if="isOpen && unit.child && unit.child.length" dense sub-group class="ma-1">
      <units-row
          v-for="childUnit in unit.child"
          :key="childUnit.id"
          :unit="childUnit"
          :editItem="editItem"
          :addItem="addItem"
          :deleteItem="deleteItem"
      />
    </v-list>
  </v-slide-y-transition>
</template>

<script>
import {mapState} from "pinia";
import {useLocalesStore} from "../../stores/l10s";

export default {
  name: "UnitsRow",
  props: {
    unit: {
      type: Object,
      required: true,
    },
    editItem: Function,
    addItem: Function,
    deleteItem: Function
  },
  data() {
    return {
      isOpen: false,
    }
  },
  computed: {
    ...mapState(useLocalesStore,['locale']),
  },
  methods: {
    toggle() {
      this.isOpen = !this.isOpen;
    }
  },
}
</script>

<style scoped>

</style>
