<template>
  <div>
    <q-layout
      v-if="1 === 1"
      view="hHh lpR fff"
    >
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
            Markets App {{ test() }}
          </q-toolbar-title>
        </q-toolbar>
      </q-header>
      <q-drawer
        v-model="drawer"
        :breakpoint="500"
        :width="200"
        bordered
        content-class="bg-grey-3"
        show-if-above
      >
        <q-scroll-area class="fit">
          <q-list
            v-for="(menuItem, index) in menuList"
            :key="index"
          >
            <q-item
              v-ripple
              :active="menuItem.label === 'Outbox'"
              clickable
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
    <img
      v-else
      class="vertical-middle absolute-center"
      style="width: 50%"
      src="~assets/soon.jpg"
    >
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
