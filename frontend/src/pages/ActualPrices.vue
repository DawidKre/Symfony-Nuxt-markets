<template>
  <div class="q-pl-md q-pt-none q-pb-none q-pr-md">
    <market-products-list/>
  </div>
</template>

<script>
import MarketProductsList from '../components/marketproduct/ProductList'

export default {
  name: 'ActualPrices',
  components: { MarketProductsList }
}
</script>
