<template>
  <v-row class="pt-4">
    <v-col cols="12" v-if="!selectedItem">
      <div class="text-body-1 warning--text py-5">Оберіть структурну одиницю, щоб побачити тільки ті одиниці які їй належать</div>
    </v-col>
    <v-col cols="4">
      <div class="text-h5 font-weight-medium">
        <template v-for="(key, index) in unitTitles(units)">
          {{$t('organization.type.' + key,key.toUpperCase())}}{{index < unitTitles(units).length - 1 ? '/' : '' }}</template>
      </div>
    </v-col>
    <v-col offset="4" cols="4" class="d-flex justify-end">
      <template v-for="key in unitTitles(units)">
        <v-btn
            class="font-weight-bold"
            variant="text"
            :color="selectedFilter === key ? 'primary' : 'secondary'"
            @click="selectFilter(key)"
        >{{$t('organization.type.' + key,key.toUpperCase())}}</v-btn>
      </template>
      <v-btn
          class="font-weight-bold"
          variant="text"
          @click="selectFilter('all')"
          :color="selectedFilter === 'all' ? 'primary' : 'secondary'"
      >{{$t('organization.type.all','All')}}</v-btn>
    </v-col>
    <v-col cols="2" v-for="unit in filteredUnits" :key="unit.id">
      <div class="d-flex flex-column align-center cursor-pointer" @click="selectUnit(unit)">
        <v-avatar justify-self="center" size="64" class="mb-2" color="primary">U</v-avatar>
        <span class="text-caption">{{unit.name[locale.iso_code]}}</span>
      </div>
    </v-col>
  </v-row>
  <v-expand-transition>
    <div>
      <recursive-item
          v-if="selectedItem && selectedItem.child.length > 0"
          :units="selectedItem.child"
      />
    </div>
  </v-expand-transition>
</template>

<script>
import {mapState} from "pinia";
import {useLocalesStore} from "../../../stores/l10s";

export default {
  name: "RecursiveItem",
  props:{
    units: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      selectedItem: null,
      selectedFilter: 'all',
    };
},
  computed: {
    ...mapState(useLocalesStore,['locale']),
    filteredUnits() {
      if (this.selectedFilter !== 'all') {
        return this.units.filter(unit => unit.type === this.selectedFilter);
      }

      return this.units;
    }
  },
  methods: {
    unitTitles(units) {
      return units.map((item) => {
        return item.type;
      }).filter((value, index, array) => {
        return array.indexOf(value) === index;
      });
    },
    selectUnit(unit) {
      this.selectedItem = unit;
    },
    selectFilter(filter) {
      this.selectedFilter = filter;
    }
  },
}
</script>

<style scoped>

</style>
