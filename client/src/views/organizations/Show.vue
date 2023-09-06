<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <template v-if="organization">
          <v-img :src="organization.img_url" :aspect-ratio="16/5" class="rounded">
            <div class="white organization__rating text-center pa-3 rounded">
              <div class="success--text text-h3 align-center d-flex">{{organization.rate}} <v-icon color="success" size="40">mdi-finance</v-icon></div>
              <div class="text-h6">{{$t('organization.placeholder.rating', 'Rating')}}</div>
            </div>
          </v-img>
          <v-container>
            <v-row>
              <v-col cols="12">
                <div class="text-h4 font-weight-medium" v-if="organization.name">{{organization.name[locale.iso_code]}}</div>
              </v-col>
              <v-col cols="4">
                <div>
                  <div class="text-subtitle-1">{{$t('placeholder.city','City')}}, {{$t('placeholder.country','Country')}}</div>
                  <div class="text-h6 font-weight-regular">
                    {{organization.city_id? organization.city.name : ''}}, {{organization.country_id? organization.country.name: ''}}
                  </div>
                </div>
                <div v-if="organization.address">
                  <div class="text-subtitle-1">{{$t('placeholder.address','Address')}}</div>
                  <div class="text-h6 font-weight-regular">
                    {{organization.address}}
                  </div>
                </div>
                <div v-if="organization.zip_code">
                  <div class="text-subtitle-1">{{$t('placeholder.zip_code','Zip code')}}</div>
                  <div class="text-h6 font-weight-regular">
                    {{organization.zip_code}}
                  </div>
                </div>
              </v-col>
              <v-col cols="4">
                <div>
                  <div class="text-subtitle-1">{{$t('placeholder.code_wrp','Code WRP')}}</div>
                  <div class="text-h6 font-weight-regular">
                    #{{organization.code_platform}}
                  </div>
                </div>
                <div v-if="organization.site">
                  <div class="text-subtitle-1">{{$t('placeholder.site','Site')}}</div>
                  <div class="text-h6 font-weight-regular">
                    <a :href="organization.site">{{organization.site}}</a>
                  </div>
                </div>
                <div v-if="organization.phone">
                  <div class="text-subtitle-1">{{$t('placeholder.phone','Phone')}}</div>
                  <div class="text-h6 font-weight-regular">
                    {{organization.phone}}
                  </div>
                </div>
              </v-col>
              <v-col cols="4">
                <v-list class="organization__list" dense>
                  <v-list-item class="px-0">
                    <v-list-item-title class="justify-space-between text-caption d-inline-flex">
                      <div class="text-caption">Показник</div>
                      <div class="text-caption">К-ть</div>
                    </v-list-item-title>
                  </v-list-item>
                  <v-list-item class="px-0">
                    <v-list-item-title class="justify-space-between text-body-1 d-inline-flex">
                      <span class="text-body-1">Faculty</span>
                      <span class="text-body-1">24</span>
                    </v-list-item-title>
                  </v-list-item>
                  <v-list-item class="px-0">
                    <v-list-item-title class="justify-space-between text-body-1 d-inline-flex">
                      <span class="text-body-1">Faculty</span>
                      <span class="text-body-1">24</span>
                    </v-list-item-title>
                  </v-list-item>
                  <v-list-item class="px-0">
                    <v-list-item-title class="justify-space-between text-body-1 d-inline-flex">
                      <span class="text-body-1">Faculty</span>
                      <span class="text-body-1">24</span>
                    </v-list-item-title>
                  </v-list-item>
                  <v-list-item class="px-0">
                    <v-list-item-title class="justify-space-between text-body-1 d-inline-flex">
                      <span class="text-body-1">Faculty</span>
                      <span class="text-body-1">24</span>
                    </v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-col>
            </v-row>
          </v-container>
        </template>
      </v-col>
      <v-col cols="12" v-if="organization">
        <div class="d-flex justify-space-between text-h5 font-weight-medium pb-4">
          <span>Rector</span>
          <span>Prorectorat</span>
        </div>
        <v-row>
          <v-col cols="3">
            <div class="d-inline-flex flex-column align-center" v-if="organization.user">
              <v-avatar justify-self="center" size="64" class="mb-2">
                <v-img :src="organization.user.avatar_url"></v-img>
              </v-avatar>
              <span class="text-body-1">{{organization.user.full_name}}</span>
            </div>
          </v-col>
          <v-col cols="9" class="d-flex justify-end">
            <template v-if="organization.staff.length > 0" >
              <div class="d-inline-flex flex-column align-center" v-for="staff in organization.staff" :key="staff.id">
                <v-avatar justify-self="center" size="64" class="mb-2">
                  <v-img :src="staff.avatar_url"></v-img>
                </v-avatar>
                <span class="text-body-1">{{staff.full_name}}</span>
              </div>
            </template>
          </v-col>
        </v-row>
      </v-col>
      <v-col cols="12"><v-divider/></v-col>
      <v-col cols="12">
        <v-tabs grow>
          <v-tab>{{$t('placeholder.desc', 'Desc')}}</v-tab>
          <v-tab>{{$t('placeholder.structure','Structure')}}</v-tab>
          <v-tab>{{$t('placeholder.contacts','Contacts')}}</v-tab>
          <v-tab>{{$t('placeholder.gallery','Gallery')}}</v-tab>
          <v-tab>{{$t('articles.conferences.title','Conferences')}}</v-tab>
          <v-tab>{{$t('articles.patents.title','Patents')}}</v-tab>
          <v-tab>{{$t('grants.title','Grants')}}</v-tab>
          <v-tab-item>
            <div class="text-body-1 mt-6" v-if="organization && organization.desc" v-html="organization.desc[locale.iso_code]"></div>
          </v-tab-item>
          <v-tab-item>
            <div class="text-body-1 warning--text py-5">Оберіть структурну одиницю, щоб побачити тільки ті одиниці які їй належать</div>
            <v-row justify="space-between" v-if="organization">
              <v-col cols="4">
                <div class="text-h5 font-weight-medium">
                  <template v-for="(key, index) in unitTitles(organization.units)">
                    {{$t('organization.type.' + key,key.toUpperCase())}}{{index < unitTitles(organization.units).length - 1 ? '/' : '' }}</template>
                </div>
              </v-col>
              <v-col cols="4" class="d-flex justify-end">
                <template v-for="key in unitTitles(organization.units)">
                  <v-btn
                    class="font-weight-bold"
                    text
                    color="secondary"
                    :value="key"
                  >{{$t('organization.type.' + key,key.toUpperCase())}}</v-btn>
                </template>
                <v-btn
                  class="font-weight-bold"
                  text
                  value="all"
                  color="primary"
                >{{$t('organization.type.all','All')}}</v-btn>
              </v-col>
            </v-row>
            <v-row v-if="organization">
              <v-col cols="2" v-for="unit in organization.units" :key="unit.id">
                <div class="d-flex flex-column align-center cursor-pointer" @click="selectUnit(unit)">
                  <v-avatar justify-self="center" size="64" class="mb-2" color="primary">U</v-avatar>
                  <span class="text-caption">{{unit.name}}</span>
                </div>
              </v-col>
            </v-row>
            <v-row v-if="selectedItem" class="my-4">
              <template v-if="selectedItem.child.length > 0">
                <v-treeview :items="selectedItem.child" item-children="child" open-on-click expand-icon="">
                  <template v-slot:label="{item}">
                    <div class="d-flex flex-column align-center cursor-pointer">
                      <v-avatar justify-self="center" size="64" class="mb-2" color="primary">U</v-avatar>
                      <span class="text-caption">{{item.name}}</span>
                    </div>
                  </template>
                </v-treeview>
              </template>
            </v-row>
          </v-tab-item>
          <v-tab-item>
            Contacts
          </v-tab-item>
          <v-tab-item>
            Gallery
          </v-tab-item>
          <v-tab-item>
            Conferences
          </v-tab-item>
          <v-tab-item>
            Patents
          </v-tab-item>
          <v-tab-item>
            Grants
          </v-tab-item>
        </v-tabs>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import {mapState} from "vuex";

export default {
  name: "Show",
  data() {
    return {
        selectedItem: null,
    };
  },
  computed: {
    ...mapState({
      organization: (state) => state.organization.organization,
      locale: (state) => state.l10s.locale,
    }),
  },
  mounted() {
    this.$store.dispatch('organization/getOrganization', this.$route.params.organization_id);
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
    }
  },
}
</script>

<style lang="scss" scoped>
.organization {
  &__rating {
    position: absolute;
    bottom: 16px;
    right: 16px;
  }
}
.cursor-pointer {
  cursor: pointer;
}
</style>
