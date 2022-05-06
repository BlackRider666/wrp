<template>
  <v-col cols="12">
    <v-toolbar dense color="primary">
      {{$t('grants.title','Grants')}}
      <v-spacer/>
      <v-btn
          icon
          @click="openGrantCreate"
      ><v-icon>mdi-plus</v-icon>
      </v-btn>
      <v-btn icon @click="showGrantsSheet">
        <v-icon v-if="grantsSheet">mdi-chevron-up</v-icon>
        <v-icon v-else>mdi-chevron-down</v-icon>
      </v-btn>
    </v-toolbar>
    <v-sheet v-if="grantsSheet" outlined>
      <v-data-table
          :headers="grantsHeaders"
          :items="grants"
          :options.sync="options"
          :server-items-length="total"
          :footer-props="{
                  itemsPerPageOptions:[5,10,15,20]
              }"
          class="elevation-1"
          dense
      >
        <template v-slot:top>
          <v-dialog v-model="editGrantDialog" max-width="500px">
            <v-card>
              <v-card-title>{{$t('grants.edit.title','Edit')}}</v-card-title>
              <v-card-text v-if="selectedGrant">
                <v-text-field
                    v-model="selectedGrant.name"
                    :label="$t('grants.placeholder.name','Name')"
                    outlined
                    prepend-inner-icon="mdi-card-text-outline"
                />
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="darken-1" text @click="closeGrantEdit">{{$t('btn.cancel','Cancel')}}</v-btn>
                <v-btn color="darken-1" text @click="editGrant">{{$t('btn.update','Update')}}</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="deleteGrantDialog" max-width="500px">
            <v-card>
              <v-card-title>{{$t('grants.delete.title','Delete')}}</v-card-title>
              <v-card-text>{{$t('grants.delete.message','Are you sure you want to delete this grant?')}}</v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="darken-1" text @click="closeGrantDelete">{{$t('btn.cancel','Cancel')}}</v-btn>
                <v-btn color="error" text @click="deleteGrant">{{$t('btn.delete','Delete')}}</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon
              small
              class="mr-2"
              @click="openGrantEdit(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
              small
              @click="openGrantDelete(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-sheet>
    <v-dialog v-model="createGrantDialog" max-width="500px">
      <v-card v-if="newGrant">
        <v-card-title>{{$t('grants.create.title','Create')}}</v-card-title>
        <v-card-text>
          <v-text-field
              v-model="newGrant.name"
              :label="$t('grants.placeholder.name','Name')"
              outlined
              prepend-inner-icon="mdi-card-text-outline"
          />
        </v-card-text>
        <v-card-actions>
          <v-btn color="darken-1" text @click="closeGrantCreate">{{$t('btn.cancel','Cancel')}}</v-btn>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="createGrant">{{$t('btn.create','Create')}}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-col>
</template>

<script>
import {mapState} from "vuex";

export default {
  name: "Grant",
  props: {
    user_id: {
      type: Number,
    },
  },
  data() {
    return {
      grantsSheet: false,
      createGrantDialog: false,
      editGrantDialog: false,
      deleteGrantDialog: false,
      grantsHeaders: [
        { text: this.$t('grants.placeholder.name','Name'), value: 'name' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      newGrant: null,
      selectedGrant: null,
      options: {},
    };
  },
  computed: {
    ...mapState({
      grants: (state) => state.grant.grants,
      total: (state) => state.grant.total,
    }),
  },
  methods: {
    showGrantsSheet() {
      this.grantsSheet = !this.grantsSheet;
    },
    openGrantCreate() {
      this.createGrantDialog = true;
      this.newGrant = {
        name: null,
      };
    },
    closeGrantCreate() {
      this.createGrantDialog = false;
    },
    openGrantEdit (item) {
      this.editGrantDialog = true;
      this.selectedGrant = {...item};
    },
    closeGrantEdit() {
      this.editGrantDialog = false;
      this.selectedGrant = null;
    },
    openGrantDelete (item) {
      this.deleteGrantDialog = true;
      this.selectedGrant = item;
    },
    closeGrantDelete() {
      this.deleteGrantDialog = false;
      this.selectedGrant = null;
    },
    createGrant () {
      this.$loading();
      this.$store.dispatch('grant/createGrant',this.newGrant)
          .then(() => {
            this.$loadingClose();
            this.closeGrantCreate();
            this.$notify('','success', 'Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    editGrant() {
      this.$loading();
      this.$store.dispatch('grant/updateGrant',this.selectedGrant)
          .then(() => {
            this.$loadingClose();
            this.closeGrantEdit();
            this.$notify('','success', 'Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    deleteGrant() {
      this.$loading();
      this.$store.dispatch('grant/deleteGrant',this.selectedGrant.id)
          .then(() => {
            this.$loadingClose();
            this.closeGrantDelete();
            this.$notify('','success', 'Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    getData() {
      this.$loading()
      this.$store.dispatch('grant/downloadGrants',{
        user_id:this.user_id,
        ...this.options,
      }).then(() => {
        this.$loadingClose();
      });
    }
  },
  watch: {
    options: {
      handler () {
        this.getData();
      },
      deep: true,
    },
  },
}
</script>

<style scoped>

</style>