<template>
    <div>
        <BasePageHeader>Dashboard</BasePageHeader>

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <WidgetStats
                    color="bg-red"
                    icon="tags"
                    info-title="Categorias"
                    :info-value="qtdCategoriasCadastradas"
                    link-to-details="/categorias"
                    :loading="isLoading"
                />
            </div>
            <div class="col-xl-3 col-md-6">
                <WidgetStats
                    color="bg-blue"
                    icon="book"
                    info-title="Produtos"
                    :info-value="qtdProdutosCadastrados"
                    link-to-details="/produtos"
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
            qtdCategoriasCadastradas : 0,
            qtdProdutosCadastrados: 0
        }
    },
    async fetch() {

        try {

            this.qtdCategoriasCadastradas = await this.$repository.dashboard.contarCategorias()
            this.qtdProdutosCadastrados = await this.$repository.dashboard.contarProdutos()

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
