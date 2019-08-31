<template>
  <q-layout view="hHh lpR fff">
    <q-header
      class="bg-primary text-white"
      elevated
    >
      <q-toolbar>
        <q-btn
          dense
          flat
          icon="menu"
          round
          @click="left = !left"
        />
        <q-toolbar-title>
          <q-avatar>
            <img src="https://cdn.quasar.dev/logo/svg/quasar-logo.svg">
          </q-avatar>
          Rynek Cen
        </q-toolbar-title>
      </q-toolbar>
    </q-header>
    <q-drawer
      v-model="left"
      :breakpoint="500"
      :width="200"
      bordered
      content-class="bg-grey-3"
      show-if-above
    >
      <nav-bar />
    </q-drawer>
    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>

import NavBar from '../components/NavBar'

export default {
  name: 'Main',
  components: { NavBar },
  data () {
    return {
      left: false,
      categories: []
    }
  },
  /**
   * @this {Vue}
   */
  mounted () {
  }
}
</script>
