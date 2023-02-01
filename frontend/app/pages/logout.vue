<template>

  <div class="d-flex align-items-center justify-content-center vh-100">
    <span class="text-center">
      <LoaderDefault :size="80" color="gray" />
      <p class="lead mt-3">{{ $t('pages.logout.leaving') }}...</p>
    </span>
  </div>

</template>

<script>
export default {
  layout: 'base-app',
  async fetch() {
    try {

      await this.$auth.logout()

    } catch (errors) {

      const errorResponse = this.$errorHandler.setAndParse(errors)

      this.$nuxt.error({ statusCode: errorResponse.status, message: errorResponse.message })
    }
  }
}
</script>
