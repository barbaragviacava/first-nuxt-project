<template>
    <div>

        <BaseTitle>
            Dashboard
        </BaseTitle>

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <WidgetStats
                    color="bg-red"
                    icon="tags"
                    info-title="Categorias"
                    :info-value="qtyStoredCategories"
                    link-to-details="/categories"
                    :loading="isLoading"
                />
            </div>
            <div class="col-xl-3 col-md-6">
                <WidgetStats
                    color="bg-blue"
                    icon="book"
                    info-title="Produtos"
                    :info-value="qtyStoredProducts"
                    link-to-details="/products"
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
    head: {
        title: 'Dashboard'
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
