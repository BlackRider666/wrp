<template>
  <v-container>
    <v-row>
    <v-col cols="12">
      <v-card>
        <v-card-text>
          <v-data-table-server
              :headers="headers"
              :items="conferences"
              :items-length="total"
              v-model:items-per-page="options.perPage"
              v-model:page="options.page"
              :items-per-page-options="[
                      {value:5,title:'5'},
                      {value:10,title:'10'},
                      {value:15,title:'15'},
                      {value:20,title:'20'}
                      ]"
              @update:options="getData"
              class="elevation-1"
          >
            <template v-slot:top>
              <v-toolbar dense flat>
                <span class="text-h5 ml-4">{{$t('conference.index.title','Conference')}}</span>
                <v-spacer></v-spacer>
                <v-btn :to="{name:'Conferences Create'}" color="primary">{{$t('conference.btn.add','Add Conference')}}</v-btn>
              </v-toolbar>
              <v-dialog v-model="dialogDelete" max-width="500px">
                <v-card>
                  <v-card-title>{{$t('conference.delete.title','Delete')}}</v-card-title>
                  <v-card-text>{{$t('conference.delete.message','Are you sure you want to delete this item?')}}</v-card-text>
                  <v-card-actions>
                    <v-btn color="darken-1" variant="text" @click="closeDelete">{{$t('btn.cancel','Cancel')}}</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="error" variant="text" @click="deleteItemConfirm">{{$t('btn.delete','Delete')}}</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-btn
                    variant="text"
                    icon="mdi-eye"
                    small
                    class="mr-2"
                    :to="{name:'Conference Show',params:{conference_id:item.id}}"
                >
                </v-btn>
                <v-btn
                    variant="text"
                    icon="mdi-pencil"
                    small
                    class="mr-2"
                    :to="{name:'Conference Edit',params:{conference_id:item.id}}"
                >
                </v-btn>
                <v-btn
                    variant="text"
                    icon="mdi-delete"
                    small
                    @click="deleteItem(item)"
                >
                </v-btn>
            </template>
          </v-data-table-server>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
  </v-container>
</template>

<script>
import {mapActions, mapState} from "pinia";
import {useConferenceStore} from "@/stores/conference";
import {useAccountStore} from "@/stores/account";

export default {
name: "Index",
  data() {
    return {
      headers: [
        { title: this.$t('conference.placeholder.title','Title'), value: 'title' },
        { title: this.$t('conference.placeholder.date','Date'), value: 'date' },
        { title: this.$t('conference.placeholder.actions','Actions'), value: 'actions', sortable: false },
      ],
      dialogDelete: false,
      options: {},
    };
  },
  computed: {
    ...mapState(useConferenceStore,['conferences','total']),
  },
  methods: {
    deleteItem (item) {
      this.selectedItem = item;
      this.dialogDelete = true
    },
    deleteItemConfirm () {
      this.$loading();
      this.deleteConference(this.selectedItem.id)
          .then( () => {
            this.$loadingClose();
            this.$notify('','success', this.$t('messages.success','Success'));
            this.closeDelete()
          })
          .catch( () => {
            this.$loadingClose();
            this.$notify('','error', this.$t('messages.error','Error'));
          });
    },
    closeDelete () {
      this.dialogDelete = false
    },
    getData() {
      this.$loading()
      this.downloadConferences( {
        user_id: useAccountStore().user.id,
        ...this.options,
      }).then(() => {
        this.$loadingClose();
      }).catch(() => {
        this.$loadingClose();
      });
    },
    ...mapActions(useConferenceStore,['downloadConferences','deleteConference']),
  },
}
</script>

<style scoped>

</style>
