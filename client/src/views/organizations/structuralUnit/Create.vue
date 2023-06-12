<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <v-card-title>
          <v-toolbar dense color="primary">
            {{$t('structuralUnit.create.title','Create Structural Unit')}}
          </v-toolbar>
        </v-card-title>
        <v-card-text>
          <v-sheet outlined>
            <v-form
                ref="form"
                lazy-validation
                align="center"
                @submit.prevent="createStructuralUnit"
            >
              <v-autocomplete
                  v-model="unit.organization"
                  :items="organizations"
                  hide-no-data
                  item-text="name"
                  item-value="id"
                  :label="$t('works.placeholder.organization','Organization')"
                  :placeholder="$t('works.placeholder.organization','Organization')"
                  prepend-inner-icon="mdi-database-search"
                  :search-input="organizationSearch"
                  return-object
                  outlined
              ></v-autocomplete>
              <v-autocomplete
                  v-model="unit.parent_id"
                  :items="structureUnits"
                  hide-no-data
                  item-text="name"
                  item-value="id"
                  :label="$t('works.placeholder.structure-unit','Structure Unit')"
                  :placeholder="$t('works.placeholder.structure-unit','Structure Unit')"
                  prepend-inner-icon="mdi-database-search"
                  :search-input="structureUnitSearch"
                  return-object
                  outlined
              ></v-autocomplete>
                <v-spacer></v-spacer>
                <v-btn color="primary" type="submit">{{$t('btn.create','Create')}}</v-btn>
            </v-form>
          </v-sheet>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import {mapState} from "vuex";

export default {
  name: "Create",
  data() {
    return {
      unit: {
        organization_id: null,
        parent_id: null,
      },
      organizationSearch:'',
      structureUnitSearch: '',
    };
  },
  computed: {
    ...mapState({
      organizations: (state) => state.organization.organizations,
      structureUnits: (state) => state.organization.structureUnits,
    }),
  },
  methods: {
    createStructuralUnit() {

    }
  },
  watch: {
    'newWork.organization'(item) {
      if (item) {
          this.$store.dispatch('organization/downloadStructureUnits', item.id)
      }
    },
  }
}
</script>

<style scoped>

</style>
