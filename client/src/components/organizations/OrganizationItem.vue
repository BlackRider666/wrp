<template>
    <v-card
        class="mx-auto organization__card"
        :to="{name:'organization', params: { organization_id: org.id}}"
    >
      <v-row dense>
        <v-col :cols="detailed?6:12" :class="detailed?'pa-0':'pb-0'">
        <v-img
            :src="org.img_url"
            :aspect-ratio="16/9"
            class="organization__img"
            :class="detailed?'detailed':''"
            height="100%"
        >
        </v-img>
        </v-col>
        <v-col :cols="detailed?6:12" class="pa-0">
          <v-card-title :title="org.name" class="text-h6 organization__title" >{{org.name.length > 106 ? org.name.substring(0,103)+'...':org.name }}</v-card-title>

          <v-card-text class="text-md-caption">
            <v-list class="organization__list" dense v-if="detailed">
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
            <v-row>
              <v-col>
                <span>{{org.city_id? org.city.name : ''}}</span>
                <br>
                <span>{{org.country_id? org.country.name: ''}}</span>
              </v-col>
              <v-col class="text-end" align-self="center">
                {{$t('organization.placeholder.rating', 'Rating')}}: <span class="organization__rating">{{org.rate}} <v-icon color="success" class="text-md-caption">mdi-finance</v-icon></span>
              </v-col>
            </v-row>
          </v-card-text>

          <v-card-actions>
            <v-btn
                block
                class="organization__btn"
            >
              {{$t('btn.read-more','Read more')}}
            </v-btn>
          </v-card-actions>
          <v-menu offset-y v-if="!detailed">
            <template v-slot:activator="{on}">
              <v-btn v-on="on" block class="organization__btn-more text-center" color="primary" height="16"><v-icon>mdi-chevron-down</v-icon></v-btn>
            </template>
            <v-list class="organization__list" dense>
              <v-list-item>
                <v-list-item-title class="justify-space-between text-caption d-inline-flex">
                  <div>Показник</div>
                  <div>К-ть</div>
                </v-list-item-title>
              </v-list-item>
              <v-list-item>
                <v-list-item-title class="justify-space-between text-body-1 d-inline-flex">
                  <span>Faculty</span>
                  <span>24</span>
                </v-list-item-title>
              </v-list-item>
              <v-list-item>
                <v-list-item-title class="justify-space-between text-body-1 d-inline-flex">
                  <span>Faculty</span>
                  <span>24</span>
                </v-list-item-title>
              </v-list-item>
              <v-list-item>
                <v-list-item-title class="justify-space-between text-body-1 d-inline-flex">
                  <span>Faculty</span>
                  <span>24</span>
                </v-list-item-title>
              </v-list-item>
              <v-list-item>
                <v-list-item-title class="justify-space-between text-body-1 d-inline-flex">
                  <span>Faculty</span>
                  <span>24</span>
                </v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-col>
      </v-row>
    </v-card>
</template>

<script>
export default {
  name: "OrganizationItem",
  props: [
      'org',
      'detailed'
  ],
}
</script>

<style scoped lang="scss">
.organization {
  &__rating {
    color: #4caf50 !important;
  }
  &__card {
    border-top: 4px solid #1976D2;
  }
  &__img {
    width: 100%;
  }
  &__title {
    hyphens: auto;
  }
  &__img.detailed{
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
  }
  &__btn {
    font-weight: 500;
    box-shadow: none;
    transition: all 0.2s ease-in-out;
    &:hover {
      color: #fff;
      background: #1976D2;
    }
  }
  &__btn-more {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
  }
  &__list.v-list--dense .v-list-item, .v-list-item--dense {
    min-height: 28px;
  }
}
</style>
