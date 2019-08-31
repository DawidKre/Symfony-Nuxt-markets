<template>
  <form @submit.prevent="handleSubmit(item)">
    <div class="form-group">
      <label
        for="marketproduct_name"
        class="form-control-label">name</label>
      <input
        id="marketproduct_name"
        v-model="item.name"
        :class="['form-control', isInvalid('name') ? 'is-invalid' : '']"
        type="text"
        required="true"
        placeholder=""
        @input="handleUpdateField('name', $event.target.value)">
      <div
        v-if="isInvalid('name')"
        class="invalid-feedback">{{ violations.name }}</div>
    </div>
    <div class="form-group">
      <label
        for="marketproduct_unit"
        class="form-control-label">unit</label>
      <input
        id="marketproduct_unit"
        v-model="item.unit"
        :class="['form-control', isInvalid('unit') ? 'is-invalid' : '']"
        type="text"
        required="true"
        placeholder=""
        @input="handleUpdateField('unit', $event.target.value)">
      <div
        v-if="isInvalid('unit')"
        class="invalid-feedback">{{ violations.unit }}</div>
    </div>
    <div class="form-group">
      <label
        for="marketproduct_quantity"
        class="form-control-label">quantity</label>
      <input
        id="marketproduct_quantity"
        v-model="item.quantity"
        :class="['form-control', isInvalid('quantity') ? 'is-invalid' : '']"
        type="text"
        required="true"
        placeholder=""
        @input="handleUpdateField('quantity', $event.target.value)">
      <div
        v-if="isInvalid('quantity')"
        class="invalid-feedback">{{ violations.quantity }}</div>
    </div>
    <div class="form-group">
      <label
        for="marketproduct_amount"
        class="form-control-label">amount</label>
      <input
        id="marketproduct_amount"
        v-model="item.amount"
        :class="['form-control', isInvalid('amount') ? 'is-invalid' : '']"
        type="number"
        required="true"
        placeholder=""
        @input="handleUpdateField('amount', $event.target.value)">
      <div
        v-if="isInvalid('amount')"
        class="invalid-feedback">{{ violations.amount }}</div>
    </div>
    <div class="form-group">
      <label
        for="marketproduct_priceMin"
        class="form-control-label">priceMin</label>
      <input
        id="marketproduct_priceMin"
        v-model="item.priceMin"
        :class="['form-control', isInvalid('priceMin') ? 'is-invalid' : '']"
        type="text"
        placeholder=""
        @input="handleUpdateField('priceMin', $event.target.value)">
      <div
        v-if="isInvalid('priceMin')"
        class="invalid-feedback">{{ violations.priceMin }}</div>
    </div>
    <div class="form-group">
      <label
        for="marketproduct_priceMax"
        class="form-control-label">priceMax</label>
      <input
        id="marketproduct_priceMax"
        v-model="item.priceMax"
        :class="['form-control', isInvalid('priceMax') ? 'is-invalid' : '']"
        type="text"
        placeholder=""
        @input="handleUpdateField('priceMax', $event.target.value)">
      <div
        v-if="isInvalid('priceMax')"
        class="invalid-feedback">{{ violations.priceMax }}</div>
    </div>
    <div class="form-group">
      <label
        for="marketproduct_priceAvg"
        class="form-control-label">priceAvg</label>
      <input
        id="marketproduct_priceAvg"
        v-model="item.priceAvg"
        :class="['form-control', isInvalid('priceAvg') ? 'is-invalid' : '']"
        type="text"
        placeholder=""
        @input="handleUpdateField('priceAvg', $event.target.value)">
      <div
        v-if="isInvalid('priceAvg')"
        class="invalid-feedback">{{ violations.priceAvg }}</div>
    </div>
    <div class="form-group">
      <label
        for="marketproduct_priceDifference"
        class="form-control-label">priceDifference</label>
      <input
        id="marketproduct_priceDifference"
        v-model="item.priceDifference"
        :class="['form-control', isInvalid('priceDifference') ? 'is-invalid' : '']"
        type="text"
        placeholder=""
        @input="handleUpdateField('priceDifference', $event.target.value)">
      <div
        v-if="isInvalid('priceDifference')"
        class="invalid-feedback">{{ violations.priceDifference }}</div>
    </div>
    <div class="form-group">
      <label
        for="marketproduct_priceAvgPrevious"
        class="form-control-label">priceAvgPrevious</label>
      <input
        id="marketproduct_priceAvgPrevious"
        v-model="item.priceAvgPrevious"
        :class="['form-control', isInvalid('priceAvgPrevious') ? 'is-invalid' : '']"
        type="text"
        placeholder=""
        @input="handleUpdateField('priceAvgPrevious', $event.target.value)">
      <div
        v-if="isInvalid('priceAvgPrevious')"
        class="invalid-feedback">{{ violations.priceAvgPrevious }}</div>
    </div>
    <div class="form-group">
      <label
        for="marketproduct_market"
        class="form-control-label">market</label>
      <input
        id="marketproduct_market"
        v-model="item.market"
        :class="['form-control', isInvalid('market') ? 'is-invalid' : '']"
        type="text"
        required="true"
        placeholder=""
        @input="handleUpdateField('market', $event.target.value)">
      <div
        v-if="isInvalid('market')"
        class="invalid-feedback">{{ violations.market }}</div>
    </div>
    <div class="form-group">
      <label
        for="marketproduct_category"
        class="form-control-label">category</label>
      <input
        id="marketproduct_category"
        v-model="item.category"
        :class="['form-control', isInvalid('category') ? 'is-invalid' : '']"
        type="text"
        placeholder=""
        @input="handleUpdateField('category', $event.target.value)">
      <div
        v-if="isInvalid('category')"
        class="invalid-feedback">{{ violations.category }}</div>
    </div>
    <div class="form-group">
      <label
        for="marketproduct_masterProduct"
        class="form-control-label">masterProduct</label>
      <input
        id="marketproduct_masterProduct"
        v-model="item.masterProduct"
        :class="['form-control', isInvalid('masterProduct') ? 'is-invalid' : '']"
        type="text"
        placeholder=""
        @input="handleUpdateField('masterProduct', $event.target.value)">
      <div
        v-if="isInvalid('masterProduct')"
        class="invalid-feedback">{{ violations.masterProduct }}</div>
    </div>
    <div class="form-group">
      <label
        for="marketproduct_prices"
        class="form-control-label">prices</label>
      <input
        id="marketproduct_prices"
        v-model="item.prices"
        :class="['form-control', isInvalid('prices') ? 'is-invalid' : '']"
        type="text"
        required="true"
        placeholder=""
        @input="handleUpdateField('prices', $event.target.value)">
      <div
        v-if="isInvalid('prices')"
        class="invalid-feedback">{{ violations.prices }}</div>
    </div>
    <div class="form-group">
      <label
        for="marketproduct_isActive"
        class="form-control-label">isActive</label>
      <input
        id="marketproduct_isActive"
        v-model="item.isActive"
        :class="['form-control', isInvalid('isActive') ? 'is-invalid' : '']"
        type="checkbox"
        placeholder=""
        @input="handleUpdateField('isActive', $event.target.value)">
      <div
        v-if="isInvalid('isActive')"
        class="invalid-feedback">{{ violations.isActive }}</div>
    </div>
    <div class="form-group">
      <label
        for="marketproduct_priceMinPrevious"
        class="form-control-label">priceMinPrevious</label>
      <input
        id="marketproduct_priceMinPrevious"
        v-model="item.priceMinPrevious"
        :class="['form-control', isInvalid('priceMinPrevious') ? 'is-invalid' : '']"
        type="text"
        placeholder=""
        @input="handleUpdateField('priceMinPrevious', $event.target.value)">
      <div
        v-if="isInvalid('priceMinPrevious')"
        class="invalid-feedback">{{ violations.priceMinPrevious }}</div>
    </div>
    <div class="form-group">
      <label
        for="marketproduct_priceMaxPrevious"
        class="form-control-label">priceMaxPrevious</label>
      <input
        id="marketproduct_priceMaxPrevious"
        v-model="item.priceMaxPrevious"
        :class="['form-control', isInvalid('priceMaxPrevious') ? 'is-invalid' : '']"
        type="text"
        placeholder=""
        @input="handleUpdateField('priceMaxPrevious', $event.target.value)">
      <div
        v-if="isInvalid('priceMaxPrevious')"
        class="invalid-feedback">{{ violations.priceMaxPrevious }}</div>
    </div>
    <div class="form-group">
      <label
        for="marketproduct_createdAt"
        class="form-control-label">createdAt</label>
      <input
        id="marketproduct_createdAt"
        v-model="item.createdAt"
        :class="['form-control', isInvalid('createdAt') ? 'is-invalid' : '']"
        type="dateTime"
        required="true"
        placeholder=""
        @input="handleUpdateField('createdAt', $event.target.value)">
      <div
        v-if="isInvalid('createdAt')"
        class="invalid-feedback">{{ violations.createdAt }}</div>
    </div>
    <div class="form-group">
      <label
        for="marketproduct_updatedAt"
        class="form-control-label">updatedAt</label>
      <input
        id="marketproduct_updatedAt"
        v-model="item.updatedAt"
        :class="['form-control', isInvalid('updatedAt') ? 'is-invalid' : '']"
        type="dateTime"
        required="true"
        placeholder=""
        @input="handleUpdateField('updatedAt', $event.target.value)">
      <div
        v-if="isInvalid('updatedAt')"
        class="invalid-feedback">{{ violations.updatedAt }}</div>
    </div>
    <div class="form-group">
      <label
        for="marketproduct_deletedAt"
        class="form-control-label">deletedAt</label>
      <input
        id="marketproduct_deletedAt"
        v-model="item.deletedAt"
        :class="['form-control', isInvalid('deletedAt') ? 'is-invalid' : '']"
        type="dateTime"
        required="true"
        placeholder=""
        @input="handleUpdateField('deletedAt', $event.target.value)">
      <div
        v-if="isInvalid('deletedAt')"
        class="invalid-feedback">{{ violations.deletedAt }}</div>
    </div>

    <button
      type="submit"
      class="btn btn-success">Submit</button>
  </form>
</template>

<script>
export default {
  props: {
    handleSubmit: {
      type: Function,
      required: true
    },

    handleUpdateField: {
      type: Function,
      required: true
    },

    values: {
      type: Object,
      required: true
    },

    errors: {
      type: Object,
      default: () => {}
    },

    initialValues: {
      type: Object,
      default: () => {}
    }
  },

  computed: {
    // eslint-disable-next-line
    item () {
      return this.initialValues || this.values
    },

    violations () {
      return this.errors || {}
    }
  },

  methods: {
    isInvalid (key) {
      return Object.keys(this.violations).length > 0 && this.violations[key]
    }
  }
}
</script>
