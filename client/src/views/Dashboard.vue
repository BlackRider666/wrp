<template>
    <v-row dense>
      <v-col cols="6" class="px-0">
        <v-card
          tile
        >
          <v-img
              src="https://picsum.photos/1280/720?random&id=666"
          >
            <v-card-title class="white--text mt-8">
              <p>Some text</p>
            </v-card-title>
          </v-img>
        </v-card>
      </v-col>
      <v-col cols="6" class="px-0">
        <v-card
            tile
        >
          <v-img
              src="https://picsum.photos/1280/720?random&id=777"
          >
            <v-card-text class="white--text mt-8">
              <v-row>
                <v-col cols="12">
                  <p>Auth Info</p>
                </v-col>
                <v-col cols="4" offset="4">
                  <v-btn
                      block
                      outlined
                      color="primary"
                      :to="{name:'login'}"
                  >Sign In</v-btn>
                </v-col>
              </v-row>
            </v-card-text>
          </v-img>
        </v-card>
      </v-col>
      <v-container>
        <v-row>
          <v-col cols="12">
            <v-card
              flat
            >
              <v-card-title class="heading font-weight-medium">
                About us
              </v-card-title>
              <v-card-text>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ut tortor tellus. Donec maximus curs us pulvinar. Proin vehicula eros mauris, sit amet rutrum libero vestibulum ac. Morbi ullamcorper eu lacus vulputate consect. Etur vivamus sagittis accumsan quam eu malesuada. Proin et ante vel libero ultrices cursus. Donec felis leo, cu rsus eget hendrerit at, congue nec enim.
              </v-card-text>
            </v-card>
         </v-col>
          <v-col cols="12">
            <v-card
                flat
            >
              <v-card-title class="heading font-weight-medium">
                News
              </v-card-title>
              <v-card-text>
                <v-row>
                  <v-col cols="4" v-for="n in news" :key="n.id">
                    <v-card
                        class="mx-auto"
                    >
                      <v-img
                          class="white--text align-end"
                          height="200px"
                          :src="n.main_photo_url"
                      >
                        <v-card-title>n.title</v-card-title>
                      </v-img>

                      <v-card-subtitle class="pb-0">
                        {{ n.tag }}
                      </v-card-subtitle>

                      <v-card-text class="text--primary">
                        <div>{{n.sub_title}}</div>
                      </v-card-text>

                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="primary"
                            text
                        >
                          Read more
                        </v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-col>
                </v-row>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12">
            <v-card
                flat
            >
              <v-card-title class="heading font-weight-medium">
                Organizers
              </v-card-title>
              <v-card-text>
                <v-slide-group
                    show-arrows
                >
                  <v-slide-item
                      v-for="organizer in organizers"
                      :key="organizer.id"
                  >
                    <v-card
                        class="ma-4"
                        flat
                    >
                      <v-img :src="organizer.logo_url" class="rounded-circle" :alt="organizer.title" width="100px"/>
                    </v-card>
                  </v-slide-item>
                </v-slide-group>
              </v-card-text>
            </v-card>
          </v-col>
          <v-col cols="12">
            <v-card
                flat
            >
              <v-card-title class="heading font-weight-medium">
                Partners
              </v-card-title>
              <v-card-text>
              <v-slide-group
                  :show-arrows="true"
              >
                <v-slide-item
                    v-for="partner in partners"
                    :key="partner.id"
                >
                  <v-card
                      class="ma-4"
                      flat
                  >
                    <v-img :src="partner.logo_url" class="rounded-circle" width="100px" :alt="partner.title"/>
                  </v-card>
                </v-slide-item>
              </v-slide-group>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-row>
</template>

<script>
import {mapState} from "vuex";

export default {
  name: "Dashboard",
  data() {
    return {
    };
  },
  mounted() {
    this.$store.dispatch('news/downloadNews');
    this.$store.dispatch('organizer/downloadOrganizers');
    this.$store.dispatch('partner/downloadPartners');
  },
  computed: {
    ...mapState({
      news: (state) => state.news.news,
      partners: (state) => state.partner.partners,
      organizers: (state) => state.organizer.organizers,
    }),
  }
}
</script>

<style scoped>

</style>