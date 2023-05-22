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
                <div class="text-h4 font-weight-medium">{{organization.name}}</div>
              </v-col>
              <v-col cols="4">
                <div>
                  <div class="text-subtitle-1">{{$t('placeholder.city','City')}}, {{$t('placeholder.country','Country')}}</div>
                  <div class="text-h6 font-weight-regular">
                    {{organization.city_id? organization.city.name : ''}}, {{organization.country_id? organization.country.name: ''}}
                  </div>
                </div>
                <div>
                  <div class="text-subtitle-1">@{{$t('placeholder.address','Address')}}</div>
                  <div class="text-h6 font-weight-regular">
                    Address
                  </div>
                </div>
                <div>
                  <div class="text-subtitle-1">@{{$t('placeholder.zip_code','Zip code')}}</div>
                  <div class="text-h6 font-weight-regular">
                    05505
                  </div>
                </div>
              </v-col>
              <v-col cols="4">
                <div>
                  <div class="text-subtitle-1">{{$t('placeholder.code_wrp','Code WRP')}}</div>
                  <div class="text-h6 font-weight-regular">
                    #113321
                  </div>
                </div>
                <div>
                  <div class="text-subtitle-1">@{{$t('placeholder.site','Site')}}</div>
                  <div class="text-h6 font-weight-regular">
                    <a href="#">https://www.site.com</a>
                  </div>
                </div>
                <div>
                  <div class="text-subtitle-1">@{{$t('placeholder.phone','Phone')}}</div>
                  <div class="text-h6 font-weight-regular">
                    +38 (012)345 67 89
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
      <v-col cols="12"><v-divider/></v-col>
      <v-col cols="12">
        <v-tabs>
          <v-tab>{{$t('placeholder.desc', 'Desc')}}</v-tab>
          <v-tab>{{$t('placeholder.structure','Structure')}}</v-tab>
          <v-tab>{{$t('placeholder.contacts','Contacts')}}</v-tab>
          <v-tab>{{$t('placeholder.gallery','Gallery')}}</v-tab>
          <v-tab>{{$t('articles.conferences.title','Conferences')}}</v-tab>
          <v-tab>{{$t('articles.patents.title','Patents')}}</v-tab>
          <v-tab>{{$t('grants.title','Grants')}}</v-tab>
          <v-tab-item>
            <div class="text-body-1 mt-6">
              Lorem ipsum dolor sit amet consectetur. Pellentesque quam ut tellus sed. Adipiscing et feugiat fringilla vitae pellentesque egestas mi venenatis ornare. In eget ornare ultrices varius pulvinar euismod lobortis sed. Tempus urna iaculis orci leo quam penatibus odio. Vel hendrerit amet urna ultrices arcu. Est massa orci praesent vitae. Sed mauris risus lobortis erat aenean sed. Semper mauris at mauris dolor amet duis. Sit porta purus phasellus ridiculus sagittis. Nisl massa nec donec vel eu justo lacinia eu non. Tristique arcu nunc condimentum interdum ut bibendum amet. Mi hac sit ut tempus nunc cursus eget at semper.
              Sagittis consectetur egestas feugiat interdum ipsum duis mi arcu. Elit malesuada sem lorem rutrum bibendum ultricies elit malesuada. Praesent magnis quis tincidunt ut leo in. Pharetra facilisis posuere fermentum metus nullam risus proin mattis eget. Nunc nullam hendrerit eget nunc non sit sem in neque. Morbi duis sit sit malesuada nullam. Id tortor eu elementum turpis in augue. Arcu arcu erat amet id velit malesuada sit netus. Etiam consequat eget tellus blandit lectus. Hendrerit orci non dapibus sit sed ullamcorper vitae ipsum. Ac at nulla arcu consectetur faucibus.
              Lorem ipsum dolor sit amet consectetur. Pellentesque quam ut tellus sed. Adipiscing et feugiat fringilla vitae pellentesque egestas mi venenatis ornare. In eget ornare ultrices varius pulvinar euismod lobortis sed. Tempus urna iaculis orci leo quam penatibus odio. Vel hendrerit amet urna ultrices arcu. Est massa orci praesent vitae. Sed mauris risus lobortis erat aenean sed. Semper mauris at mauris dolor amet duis. Sit porta purus phasellus ridiculus sagittis. Nisl massa nec donec vel eu justo lacinia eu non. Tristique arcu nunc condimentum interdum ut bibendum amet. Mi hac sit ut tempus nunc cursus eget at semper.
            </div>
          </v-tab-item>
          <v-tab-item>
            Structure
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
  computed: {
    ...mapState({
      organization: (state) => state.organization.organization,
    })
  },
  mounted() {
    this.$store.dispatch('organization/getOrganization', this.$route.params.organization_id);
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
</style>
