<template>
  <div>

    <BaseTitle>
        {{ $t('pages.dashboard.title') }}
    </BaseTitle>

    <div class="row">
      <div class="col-xl-3 col-md-6">
        <WidgetStats
          color="bg-red"
          icon="tags"
          :info-title="$t('repositories.category.plural')"
          :info-value="qtyStoredCategories"
          :link-to-details="localePath({name: 'categories'})"
          :loading="isLoading"
        />
      </div>
      <div class="col-xl-3 col-md-6">
        <WidgetStats
          color="bg-blue"
          icon="book"
          :info-title="$t('repositories.product.plural')"
          :info-value="qtyStoredProducts"
          :link-to-details="localePath({name: 'products'})"
          :loading="isLoading"
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      qtyStoredCategories : 0,
      qtyStoredProducts: 0
    }
  },
  async fetch() {

    try {

      this.qtyStoredCategories = await this.$repository.dashboard.countCategories()
      this.qtyStoredProducts = await this.$repository.dashboard.countProducts()

    } catch (errors) {

      const errorResponse = this.$errorHandler.setAndParse(errors)

      this.$nuxt.error({ statusCode: errorResponse.status, message: errorResponse.message })
    }
  },
  head() {
    return {
      title: this.$t('pages.dashboard.title')
    }
  },
  computed: {
    isLoading() {
      return this.$coreLoading.isActive();
    }
  },
  created() {
    this.$nuxt.$emit('load-content-image', '--image-cover-scrum-board')
  }
}
</script>
