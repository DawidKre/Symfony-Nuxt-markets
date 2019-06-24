<template>
  <div>
    <v-app
      v-if="!ready"
      style="background-color: black;"
    >
      <img
        src="~/assets/file.jpg"
        style="max-height: 100%; max-width: 100%; margin: 200px 0">
      <div style="background-color: black">..</div>
    </v-app>
    <v-app v-if="ready">
      <v-navigation-drawer
        v-model="drawer"
        :clipped="clipped"
        :mini-variant="miniVariant"
        app
        fixed
      >
        <v-list>
          <v-list-tile
            v-for="(item, i) in items"
            :key="i"
            :to="item.to"
            exact
            router
          >
            <v-list-tile-action>
              <v-icon v-html="item.icon"/>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title v-text="item.title"/>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-navigation-drawer>
      <v-toolbar
        :clipped-left="clipped"
        app
        fixed
      >
        <v-toolbar-side-icon @click="drawer = !drawer"/>
        <v-btn
          icon
          @click.stop="miniVariant = !miniVariant"
        >
          <v-icon v-html="miniVariant ? 'chevron_right' : 'chevron_left'"/>
        </v-btn>
        <v-btn
          icon
          @click.stop="clipped = !clipped"
        >
          <v-icon>web</v-icon>
        </v-btn>
        <v-btn
          icon
          @click.stop="fixed = !fixed"
        >
          <v-icon>remove</v-icon>
        </v-btn>
        <v-toolbar-title v-text="title"/>
        <v-btn
          icon
          @click.stop="rightDrawer = !rightDrawer"
        >
          <v-icon>menu</v-icon>
        </v-btn>
      </v-toolbar>
      <v-content>
        <v-container>
          <nuxt/>
        </v-container>
      </v-content>
      <v-navigation-drawer
        v-model="rightDrawer"
        :right="right"
        fixed
        temporary
      >
        <v-list>
          <v-list-tile @click.native="right = !right">
            <v-list-tile-action>
              <v-icon light>compare_arrows</v-icon>
            </v-list-tile-action>
            <v-list-tile-title>Switch drawer (click me)</v-list-tile-title>
          </v-list-tile>
        </v-list>
      </v-navigation-drawer>
      <v-footer
        :fixed="fixed"
        app
      >
        <span>&copy; 2019</span>
      </v-footer>
    </v-app>
  </div>
</template>
<script>
export default {
  data() {
    return {
      ready: false,
      clipped: false,
      drawer: true,
      fixed: false,
      items: [
        { icon: 'apps', title: 'Welcome', to: '/' },
        { icon: 'bubble_chart', title: 'Inspire', to: '/inspire' }
      ],
      miniVariant: false,
      right: true,
      rightDrawer: false,
      title: 'Vuetify.js'
    }
  }
}
</script>
