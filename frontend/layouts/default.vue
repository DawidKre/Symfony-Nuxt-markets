<template>
  <div>
    <v-app
      style="background-color: black;"
      v-if="!ready"
    >
      <img
        src="~/assets/file.jpg"
        style="max-height: 100%; max-width: 100%; margin: 200px 0">
      <div style="background-color: black">..</div>
    </v-app>
    <v-app v-if="ready">
      <v-navigation-drawer
        :clipped="clipped"
        :mini-variant="miniVariant"
        app
        fixed
        v-model="drawer"
      >
        <v-list>
          <v-list-tile
            :key="i"
            :to="item.to"
            exact
            router
            v-for="(item, i) in items"
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
          @click.stop="miniVariant = !miniVariant"
          icon
        >
          <v-icon v-html="miniVariant ? 'chevron_right' : 'chevron_left'"/>
        </v-btn>
        <v-btn
          @click.stop="clipped = !clipped"
          icon
        >
          <v-icon>web</v-icon>
        </v-btn>
        <v-btn
          @click.stop="fixed = !fixed"
          icon
        >
          <v-icon>remove</v-icon>
        </v-btn>
        <v-toolbar-title v-text="title"/>
        <v-btn
          @click.stop="rightDrawer = !rightDrawer"
          icon
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
        :right="right"
        fixed
        temporary
        v-model="rightDrawer"
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
