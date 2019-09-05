<template>
  <div>
    <h1>MarketProduct List</h1>

    <div
      v-if="isLoading"
      class="alert alert-info">Loading...</div>
    <div
      v-if="deletedItem"
      class="alert alert-success">{{ deletedItem['@id'] }} deleted.</div>
    <div
      v-if="error"
      class="alert alert-danger">{{ error }}</div>

    <span v-if="view">
      <button
        :disabled="!view['hydra:previous']"
        type="button"
        class="btn btn-basic btn-sm"
        @click="getPage(view['hydra:first'])">First</button>
      &nbsp;
      <button
        :disabled="!view['hydra:previous']"
        type="button"
        class="btn btn-basic btn-sm"
        @click="getPage(view['hydra:previous'])">Previous</button>
      &nbsp;
      <button
        :disabled="!view['hydra:next']"
        type="button"
        class="btn btn-basic btn-sm"
        @click="getPage(view['hydra:next'])">Next</button>
      &nbsp;
      <button
        :disabled="!view['hydra:last']"
        type="button"
        class="btn btn-basic btn-sm"
        @click="getPage(view['hydra:last'])">Last</button>
      &nbsp;
    </span>

    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Id</th>
            <th>name</th>
            <th>unit</th>
            <th>quantity</th>
            <th>amount</th>
            <th>priceMin</th>
            <th>priceMax</th>
            <th>priceAvg</th>
            <th>priceDifference</th>
            <th>priceAvgPrevious</th>
            <th>market</th>
            <th>category</th>
            <th>masterProduct</th>
            <th>prices</th>
            <th>isActive</th>
            <th>priceMinPrevious</th>
            <th>priceMaxPrevious</th>
            <th>createdAt</th>
            <th>updatedAt</th>
            <th>deletedAt</th>
            <th>deleted</th>
            <th colspan="2" />
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in items"
            :key="item['@id']">
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['@id'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['name'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['unit'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['quantity'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['amount'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['priceMin'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['priceMax'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['priceAvg'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['priceDifference'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['priceAvgPrevious'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['market'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['category'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['masterProduct'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['prices'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['isActive'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['priceMinPrevious'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['priceMaxPrevious'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['createdAt'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['updatedAt'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['deletedAt'] }}
              </router-link>
            </td>
            <td>
              <router-link
                v-if="item"
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                {{ item['deleted'] }}
              </router-link>
            </td>
            <td>
              <router-link
                :to="{name: 'MarketProductShow', params: { id: item['@id'] }}">
                <span
                  class="fa fa-search"
                  aria-hidden="true" />
                <span class="sr-only">Show</span>
              </router-link>
            </td>
            <td>
              <router-link :to="{name: 'MarketProductUpdate', params: { id: item['@id'] }}">
                <span
                  class="fa fa-pencil"
                  aria-hidden="true" />
                <span class="sr-only">Edit</span>
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <router-link
      :to="{ name: 'MarketProductCreate' }"
      class="btn btn-primary">Create</router-link>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  computed: mapGetters({
    deletedItem: 'marketproduct/del/deleted',
    error: 'marketproduct/list/error',
    items: 'marketproduct/list/items',
    isLoading: 'marketproduct/list/isLoading',
    view: 'marketproduct/list/view'
  }),

  created () {
    this.getPage()
  },

  methods: mapActions({
    getPage: 'marketproduct/list/default'
  })
}
</script>
