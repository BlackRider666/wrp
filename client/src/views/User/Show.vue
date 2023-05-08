<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-card flat v-if="user">
          <v-card-text>
<!--            <div v-if="user.projects" class="py-1">-->
<!--              <v-toolbar dense color="primary">-->
<!--                {{$t('projects.title','Projects')}}-->
<!--              </v-toolbar>-->
<!--              <v-data-table-->
<!--                  :headers="headersProjects"-->
<!--                  :items="user.projects"-->
<!--                  :items-per-page="5"-->
<!--                  class="elevation-1"-->
<!--                  hide-default-footer-->
<!--              ></v-data-table>-->
<!--            </div>-->
            <v-row justify="center" class="py-10">
              <v-col cols="8">
                <v-row>
                  <v-col cols="4" class="text-center">
                    <v-avatar size="150">
                      <v-img :src="user.avatar_url"></v-img>
                    </v-avatar>
                    <div class="text-h4 pt-4 font-weight-medium">
                      {{user.full_name}}
                    </div>
                    <div class="text-subtitle-1 pt-1">ID: {{user.id}}</div>
                  </v-col>
                  <v-col cols="4">
                    <div>
                      <div class="text-subtitle-1">Phone</div>
                      <div class="text-h6 font-weight-regular">
                        <template v-if="haveAccess">
                          {{user.phone}}
                        </template>
                        <template v-else>
                          <div class="align-content-center">
                          {{$t('users.get-access', 'Get Access')}} <v-icon color="primary" size="22">mdi-export</v-icon>
                          </div>
                        </template>
                      </div>
                    </div>
                  </v-col>
                  <v-col cols="4">
                    <div>
                      <div class="text-subtitle-1">@Email</div>
                      <div class="text-h6 font-weight-regular">
                        <template v-if="haveAccess">
                          {{user.email}}
                        </template>
                        <template v-else>
                          <div class="align-content-center">
                            {{$t('users.get-access', 'Get Access')}} <v-icon color="primary" size="22">mdi-export</v-icon>
                          </div>
                        </template>
                      </div>
                    </div>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
            <v-row justify="center" class="pt-2 pb-10" v-if="user.id === account.id">
              <v-col cols="3">
                <v-btn tile block :to="{name:'Premium'}" class="font-weight-bold" color="#FFD600" >{{$t('users.activate-premium', 'Activate Premium')}}</v-btn>
              </v-col>
              <v-col cols="3">
                <v-btn class="font-weight-bold" tile :to="{name:'account'}" block color="#F5F5F5">{{$t('users.edit-profile', 'Edit profile')}}</v-btn>
              </v-col>
            </v-row>
            <v-tabs grow>
              <v-tab>{{$t('placeholder.desc', 'Desc')}}</v-tab>
              <v-tab>{{$t('works.title','Works')}}</v-tab>
              <v-tab>{{$t('articles.index.title','Articles')}}</v-tab>
              <v-tab>{{$t('articles.books.title','Books')}}</v-tab>
              <v-tab>{{$t('articles.conferences.title','Conferences')}}</v-tab>
              <v-tab>{{$t('articles.patents.title','Patents')}}</v-tab>
              <v-tab>{{$t('grants.title','Grants')}}</v-tab>

              <v-tab-item>
                <v-row justify="space-between" class="pt-3">
                  <v-col cols="4">
                    <div class="text-subtitle-1 font-weight-medium">Science profile</div>
                    <div class="float-left d-inline-flex py-3">
                      <a class="pr-3" v-if="socialLinks.orcid" target="_blank" :href="socialLinks.orcid" >
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/ORCID/ORCID_Color.svg')"/>
                      </a>
                      <div v-else class="pr-3">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/ORCID/ORCID_Gray.svg')"/>
                      </div>
                      <a class="px-3" v-if="socialLinks.google" target="_blank" :href="socialLinks.google" >
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/GOOGLE/GOOGLE_TEXT_Color.svg')"/>
                      </a>
                      <div v-else class="px-3">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/GOOGLE/GOOGLE_TEXT_Gray.svg')"/>
                      </div>
                      <a class="px-3" v-if="socialLinks.scopus" target="_blank" :href="socialLinks.scopus">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/SCOPUS/SCOPUS_Color.svg')"/>
                      </a>
                      <div v-else class="px-3">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/SCOPUS/SCOPUS_Gray.svg')"/>
                      </div>
                      <a class="px-3" v-if="socialLinks.academia" target="_blank" :href="socialLinks.academia">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/ACADEMIA/ACADEMIA_Color.svg')"/>
                      </a>
                      <div v-else class="px-3">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/ACADEMIA/ACADEMIA_Gray.svg')"/>
                      </div>
                      <a class="px-3" v-if="socialLinks.science" target="_blank" :href="socialLinks.science">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/SCIENCE/SCIENCE_Color.svg')"/>
                      </a>
                      <div v-else class="px-3">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/SCIENCE/SCIENCE_Gray.svg')"/>
                      </div>
                      <a class="px-3" v-if="socialLinks.linkedin" target="_blank" :href="socialLinks.linkedin">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/LINKED/LINKED_Color.svg')"/>
                      </a>
                      <div v-else class="px-3">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/LINKED/LINKED_Gray.svg')"/>
                      </div>
                    </div>
                  </v-col>
                  <v-col offset="4" cols="4">
                    <div class="text-subtitle-1 font-weight-medium text-right">Social profile</div>
                    <div class="float-right d-inline-flex py-3">
                      <a class="px-3" v-if="socialLinks.facebook" target="_blank" :href="socialLinks.facebook">
                        <v-img class="px-3" width="40" height="40" :src="require('@/assets/social-logo/FACEBOOK/FACEBOOK_Color.svg')"/>
                      </a>
                      <div v-else class="px-3">
                        <v-img width="40" height="40" :src="require('@/assets/social-logo/FACEBOOK/FACEBOOK_Gray.svg')"/>
                      </div>
                      <a class="pl-3" v-if="socialLinks.instagram" target="_blank" :href="socialLinks.instagram">
                        <v-img width="40" height="40" :src="require('@/assets/social-logo/INSTAGRAM/INSTAGRAM_Color.svg')"/>
                      </a>
                      <div v-else class="pl-3">
                        <v-img width="40" height="40" :src="require('@/assets/social-logo/INSTAGRAM/INSTAGRAM_Gray.svg')"/>
                      </div>
                    </div>
                  </v-col>
                  <v-col cols="12">
                    {{user.desc}}
                  </v-col>
                </v-row>
              </v-tab-item>
              <v-tab-item>
                <v-data-table
                    :headers="headersWorks"
                    :items="user.works"
                    :items-per-page="5"
                    class="elevation-1"
                    hide-default-footer
                >
                  <template v-slot:item.finish="{ item }">
                    {{item.finish?item.finish: $t('works.now','Now')}}
                  </template>
                </v-data-table>
              </v-tab-item>
              <v-tab-item>
                <v-data-table
                    :headers="headersArticles"
                    :items="user.articles"
                    class="elevation-1"
                >
                  <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="showArticle(item)"
                    >
                      mdi-eye
                    </v-icon>
                  </template>
                </v-data-table>
              </v-tab-item>
              <v-tab-item>
                <v-data-table
                    :headers="headersArticles"
                    :items="user.articles"
                    class="elevation-1"
                >
                  <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="showArticle(item)"
                    >
                      mdi-eye
                    </v-icon>
                  </template>
                </v-data-table>
              </v-tab-item>
              <v-tab-item>
                <v-data-table
                    :headers="headersArticles"
                    :items="user.articles"
                    class="elevation-1"
                >
                  <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="showArticle(item)"
                    >
                      mdi-eye
                    </v-icon>
                  </template>
                </v-data-table>
              </v-tab-item>
              <v-tab-item>
                <v-data-table
                    :headers="headersArticles"
                    :items="user.articles"
                    class="elevation-1"
                >
                  <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="showArticle(item)"
                    >
                      mdi-eye
                    </v-icon>
                  </template>
                </v-data-table>
              </v-tab-item>
              <v-tab-item>
                <v-data-table
                    :headers="headersGrants"
                    :items="user.grants"
                    :items-per-page="5"
                    class="elevation-1"
                    hide-default-footer
                ></v-data-table>
              </v-tab-item>
            </v-tabs>
            <v-row justify="end" v-if="user.id === account.id">
              <v-col cols="2">
                <v-btn tile :to="{name:'account'}" class="font-weight-bold" block color="#F5F5F5">{{$t('users.edit', 'Edit')}}</v-btn>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
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
      headersWorks: [
        { text: this.$t('works.placeholder.title', 'Title'), value: 'title' },
        { text: this.$t('works.placeholder.start', 'Worked from'), value: 'start' },
        { text: this.$t('works.placeholder.finish','Worked Until'), value: 'finish' },
      ],
      headersProjects: [
        { text: this.$t('projects.placeholder.name', 'Name'), value: 'name' },
      ],
      headersGrants: [
        { text: this.$t('grants.placeholder.name', 'Name'), value: 'name' },
      ],
      headersArticles: [
        { text: this.$t('articles.placeholder.title','Title'), value: 'title' },
        { text: this.$t('articles.placeholder.category','Category'), value: 'category.title' },
        { text: this.$t('articles.placeholder.year','Year'), value: 'year' },
        { text: this.$t('articles.placeholder.actions','Actions'), value: 'actions', sortable: false },
      ],
      socialLinks: {
        academia: null,
        facebook: null,
        google: null,
        instagram: null,
        linkedin: null,
        orcid: null,
        scopus: null,
        science: null,
      },
    };
  },
  computed: {
    ...mapState({
      user: (state) => state.user.user,
      account: (state) => state.account.user
    }),
    haveAccess() {
      let user = this.user;
      let acc = this.account;
      if (user && acc) {
        return user.id === acc.id;
      }
      return false;
    }
  },
  mounted() {
    this.$store.dispatch('user/downloadUser', this.$route.params.user_id).then( (res) => {
        res.user.social_links.forEach( (item) => {
          this.socialLinks[item.type] = item.url;
        })
    });
  },
  methods: {
    showArticle(item) {
      this.$router.push( { name: 'Article', params: { article_id: item.id } });
    },
  },
}
</script>

<style scoped>

</style>
