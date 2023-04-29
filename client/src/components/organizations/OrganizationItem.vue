<template>
    <v-card
        class="mx-auto organization__card"
    >
      <v-img
          :src="org.img_url"
          class="rounded-0 organization__img"
      >
      </v-img>
      <v-card-title class="text-body-1">{{ org.name }}</v-card-title>
      <!--                      <v-card-subtitle class="pb-0">-->
      <!--                        {{ n.tag }}-->
      <!--                      </v-card-subtitle>-->

      <v-card-text class="text-md-caption">
        <v-row>
          <v-col>
            <span>{{org.city_id? org.city.name : ''}}</span>
            <br>
            <span>{{org.country_id? org.country.name: ''}}</span>
          </v-col>
          <v-col class="text-end" align-self="center">
            Рейтинг: <span class="organization__rating">{{org.rate}} <v-icon color="success" class="text-md-caption">mdi-finance</v-icon></span>
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
      <v-menu offset-y>
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
    </v-card>
</template>

<script>
export default {
  name: "OrganizationItem",
  props: [
      'org',
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
    aspect-ratio: 16/9;
    object-fit: contain;
    width: 100%;
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
