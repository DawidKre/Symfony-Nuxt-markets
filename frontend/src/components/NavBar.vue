<template>
  <q-scroll-area class="fit">
    <router-link :to="{ name: 'MarketProductList' }" class="active">Foos</router-link>
    <q-list
      v-for="(menuItem, index) in menuList"
      :key="index"
    >
      <q-item
        v-ripple
        :to="{ name: menuItem.route}"
        clickable
        exact
      >
        <q-item-section avatar>
          <q-icon :name="menuItem.icon" />
        </q-item-section>
        <q-item-section>
          {{ menuItem.label }}
        </q-item-section>
      </q-item>
      <q-separator />
    </q-list>
  </q-scroll-area>
</template>

<script>

export default {
  name: 'NavBar',
  data () {
    return {
      menuList: [
        { icon: 'dashboard', label: 'Aktualności', separator: false, route: 'dashboard' },
        { icon: 'attach_money', label: 'Aktualne ceny', separator: false, route: 'actualPrices' }
      ]
    }
  }
}
</script>

<style>
</style>
