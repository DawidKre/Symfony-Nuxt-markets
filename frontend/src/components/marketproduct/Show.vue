<template>
  <div>
    <h1>Show {{ item && item['@id'] }}</h1>

    <div
      v-if="isLoading"
      class="alert alert-info"
      role="status">Loading...</div>
    <div
      v-if="error"
      class="alert alert-danger"
      role="alert">
      <span
        class="fa fa-exclamation-triangle"
        aria-hidden="true" /> {{ error }}
    </div>
    <div
      v-if="deleteError"
      class="alert alert-danger"
      role="alert">
      <span
        class="fa fa-exclamation-triangle"
        aria-hidden="true" /> {{ deleteError }}
    </div>
    <div
      v-if="item"
      class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Field</th>
            <th>Value</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>name</td>
            <td>{{ item['name'] }}</td>
          </tr>
          <tr>
            <td>unit</td>
            <td>{{ item['unit'] }}</td>
          </tr>
          <tr>
            <td>quantity</td>
            <td>{{ item['quantity'] }}</td>
          </tr>
          <tr>
            <td>amount</td>
            <td>{{ item['amount'] }}</td>
          </tr>
          <tr>
            <td>priceMin</td>
            <td>{{ item['priceMin'] }}</td>
          </tr>
          <tr>
            <td>priceMax</td>
            <td>{{ item['priceMax'] }}</td>
          </tr>
          <tr>
            <td>priceAvg</td>
            <td>{{ item['priceAvg'] }}</td>
          </tr>
          <tr>
            <td>priceDifference</td>
            <td>{{ item['priceDifference'] }}</td>
          </tr>
          <tr>
            <td>priceAvgPrevious</td>
            <td>{{ item['priceAvgPrevious'] }}</td>
          </tr>
          <tr>
            <td>market</td>
            <td>{{ item['market'] }}</td>
          </tr>
          <tr>
            <td>category</td>
            <td>{{ item['category'] }}</td>
          </tr>
          <tr>
            <td>masterProduct</td>
            <td>{{ item['masterProduct'] }}</td>
          </tr>
          <tr>
            <td>prices</td>
            <td>{{ item['prices'] }}</td>
          </tr>
          <tr>
            <td>isActive</td>
            <td>{{ item['isActive'] }}</td>
          </tr>
          <tr>
            <td>priceMinPrevious</td>
            <td>{{ item['priceMinPrevious'] }}</td>
          </tr>
          <tr>
            <td>priceMaxPrevious</td>
            <td>{{ item['priceMaxPrevious'] }}</td>
          </tr>
          <tr>
            <td>createdAt</td>
            <td>{{ item['createdAt'] }}</td>
          </tr>
          <tr>
            <td>updatedAt</td>
            <td>{{ item['updatedAt'] }}</td>
          </tr>
          <tr>
            <td>deletedAt</td>
            <td>{{ item['deletedAt'] }}</td>
          </tr>
          <tr>
            <td>deleted</td>
            <td>{{ item['deleted'] }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <router-link
      v-if="item"
      :to="{ name: 'MarketProductList' }"
      class="btn btn-default">Back to list</router-link>
    <button
      class="btn btn-danger"
      @click="deleteItem(item)">Delete</button>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  computed: mapGetters({
    deleteError: 'marketproduct/del/error',
    error: 'marketproduct/show/error',
    isLoading: 'marketproduct/show/isLoading',
    item: 'marketproduct/show/retrieved'
  }),

  beforeDestroy () {
    this.reset()
  },

  created () {
    this.retrieve(decodeURIComponent(this.$route.params.id))
  },

  methods: {
    ...mapActions({
      del: 'marketproduct/del/del',
      reset: 'marketproduct/show/reset',
      retrieve: 'marketproduct/show/retrieve'
    }),

    deleteItem (item) {
      if (window.confirm('Are you sure you want to delete this item?')) {
        this.del(item).then(() => this.$router.push({ name: 'MarketProductList' }))
      }
    }
  }
}
</script>
