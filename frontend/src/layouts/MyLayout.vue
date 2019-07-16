<template>
  <div>
    <q-layout view="hHh lpR fff" v-if="1 === 2">
      <q-header
        class="bg-primary text-white"
        elevated
      >
        <q-toolbar>
          <q-btn
            @click="left = !left"
            dense
            flat
            icon="menu"
            round
          />
          <q-toolbar-title>
            <q-avatar>
              <img src="https://cdn.quasar.dev/logo/svg/quasar-logo.svg">
            </q-avatar>
            Markets App {{ test() }}
          </q-toolbar-title>
        </q-toolbar>
      </q-header>
      <q-drawer
        :breakpoint="500"
        :width="200"
        bordered
        content-class="bg-grey-3"
        show-if-above
        v-model="drawer"
      >
        <q-scroll-area class="fit">
          <q-list
            :key="index"
            v-for="(menuItem, index) in menuList"
          >
            <q-item
              :active="menuItem.label === 'Outbox'"
              clickable
              v-ripple
            >
              <q-item-section avatar>
                <q-icon :name="menuItem.icon" />
              </q-item-section>
              <q-item-section>
                {{ menuItem.label }}
              </q-item-section>
            </q-item>
          </q-list>
        </q-scroll-area>
      </q-drawer>
      <q-page-container>
        <router-view />
      </q-page-container>
    </q-layout>
    <img  class="vertical-middle absolute-center" style="width: 50%" src="~assets/soon.jpg" v-else>
  </div>
</template>

<script>
const menuList = [
  {
    icon: 'inbox',
    label: 'Inbox',
    separator: true
  },
  {
    icon: 'send',
    label: 'Outbox',
    separator: false
  },
  {
    icon: 'delete',
    label: 'Trash',
    separator: false
  },
  {
    icon: 'error',
    label: 'Spam',
    separator: true
  },
  {
    icon: 'settings',
    label: 'Settings',
    separator: false
  },
  {
    icon: 'feedback',
    label: 'Send Feedback',
    separator: false
  },
  {
    icon: 'help',
    iconColor: 'primary',
    label: 'Help',
    separator: false
  }
]

export default {
  data () {
    return {
      drawer: true,
      menuList
    }
  },
  methods: {
    /**
     * @this {Vue}
     */
    test () {
    }
  }
}
</script>
