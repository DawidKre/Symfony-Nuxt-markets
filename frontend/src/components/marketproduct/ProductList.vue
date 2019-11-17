<template>
  <div>
    <div class="row q-pb-sm">
      <div class="col-md-8 col-lg-9 col-sm-6 col-xs-12">
        <h4>Aktualne ceny</h4>
      </div>
      <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12">
        <div class="q-mt-lg">
          <q-input
            v-model="filter"
            standout="bg-teal text-white"
            clearable
            clear-icon="clear"
            debounce="300"
            label="Szukaj"
          >
            <template v-slot:append>
              <q-icon name="search" />
            </template>
          </q-input>
        </div>
      </div>
    </div>
    <q-table
      :data="items"
      :columns="columns"
      :pagination.sync="pagination"
      row-key="id"
      :visible-columns="visibleColumns"
      :filter="filter"
    >
      <template v-slot:top="props">
        <q-space />
        <q-select
          v-model="visibleColumns"
          multiple
          borderless
          options-dense
          dropdown-icon="filter_list"
          display-value=""
          emit-value
          map-options
          :options="columns"
          option-value="name"
          style="min-width: 200px;"
        />
        <q-btn
          flat
          round
          dense
          :icon="props.inFullscreen ? 'fullscreen_exit' : 'fullscreen'"
          class="q-ml-md"
          @click="props.toggleFullscreen"
        />
      </template>
    </q-table>
    <span v-if="view">
      <button
        :disabled="!view['hydra:previous']"
        type="button"
        class="btn btn-basic btn-sm"
        @click="getPage(view['hydra:first'])">
        First
      </button>
      <button
        :disabled="!view['hydra:previous']"
        type="button"
        class="btn btn-basic btn-sm"
        @click="getPage(view['hydra:previous'])">
        Previous
      </button>
      <button
        :disabled="!view['hydra:next']"
        type="button"
        class="btn btn-basic btn-sm"
        @click="getPage(view['hydra:next'])">
        Next
      </button>
      <button
        :disabled="!view['hydra:last']"
        type="button"
        class="btn btn-basic btn-sm"
        @click="getPage(view['hydra:last'])">
        Last
      </button>
    </span>
  </div>
</template>
<script>

import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'ProductList',
  data () {
    return {
      filter: '',
      pagination: {
        totalItems: 0,
        rowsPerPage: 10,
        sortBy: 'name',
        descending: false,
        page: 1
      },
      visibleColumns: ['name', 'unit', 'priceMin', 'priceMax', 'priceAvg', 'priceAvgPrevious', 'priceDifference'],
      columns: [
        { name: 'name', align: 'left', label: 'Produkt', field: row => row.name, format: val => val.toUpperCase(), sortable: true },
        { name: 'unit', align: 'center', label: 'Jm.', field: 'unit' },
        { name: 'priceMin', align: 'center', label: 'Cena min.', field: 'priceMin', format: val => `${val}zł`, sortable: true },
        { name: 'priceMax', align: 'center', label: 'Cena max.', field: 'priceMax', format: val => `${val} zł`, sortable: true },
        { name: 'priceAvg', align: 'center', label: 'Cena średnia', field: 'priceAvg', format: val => `${val} zł`, sortable: true },
        { name: 'priceAvgPrevious', align: 'center', label: 'Poprzednia cena średnia', field: 'priceAvgPrevious', format: val => `${val} zł`, sortable: true },
        { name: 'priceDifference', align: 'center', label: 'Różnica', field: 'priceDifference', format: val => `${val} zł`, sortable: true }
      ],
      marketProducts: []
    }
  },
  computed: {
    ...mapGetters('marketproduct/list', {
      error: 'getError',
      items: 'getItems',
      isLoading: 'isLoading',
      view: 'getView'
    })
  },
  mounted () {
    this.getPage()
  },
  methods: {
    ...mapActions('marketproduct', {
      getPage: 'list/default'
    })
  }
}
</script>
