<template>
    <VSelect
        class="v-select-core-admin"
        :value="value"
        :placeholder="placeholder"
        :options="categorias"
        :disabled="disabled"
        :multiple="multiple"
        :filterable="false"
        :reduce="reduce"
        :input-id="inputId"
        :get-option-key="(option) => option.id"
        :get-option-label="(option) => option.nome"
        @input="(selected) => $emit('input', selected)"
        @open="onOpen"
        @close="onClose"
        @search="onSearch"
    >
        <template #spinner="{ loading }">
            <div
                v-if="loading"
                style="border-left-color: rgba(88, 151, 251, 0.71)"
                class="vs__spinner"
            >
                Buscando...
            </div>
        </template>

        <template slot="no-options">
            Nenhum resultado encontrado
        </template>

        <template #open-indicator="{ attributes }">
            <fa icon="angle-down" v-bind="attributes"></fa>
        </template>

        <template #list-footer>
            <li v-show="hasNextPage" ref="load" class="loader">
                Buscando mais categorias...
            </li>
        </template>

    </VSelect>
</template>

<script>
export default {
    props: {
        value: {
            default: null
        },
        placeholder: {
            type: String,
            default: ""
        },
        reduce: {
            type: Function,
            default: option => option
        },
        inputId: {
            type: String
        },
        disabled: {
            type: Boolean,
            default: false
        },
        multiple: {
            type: Boolean,
            default: false
        },
    },
    data() {
        return {
            categorias: [],
            observer: null,
            meta: {
                limit: 20,
                total: null
            }
        }
    },
    async fetch() {
        await this.buscarCategorias()
    },
    computed: {
        hasNextPage() {
            return !this.meta.total || this.meta.limit < this.meta.total
        },
    },
    mounted() {
        this.observer = new IntersectionObserver(this.infiniteScroll)
    },
    methods: {

        async onSearch(search, loading) {
            loading(true)
            await this.buscarCategorias(search)
            loading(false)
        },

        buscarCategorias(search) {
            return this.$repository.categorias.list({sortBy: 'nome', nome: search, limit: this.meta.limit}).then(({data, meta}) => {
                this.categorias = data
                this.meta.total = meta.total
            })
        },

        async onOpen() {
            if (this.hasNextPage) {
                await this.$nextTick()
                this.observer.observe(this.$refs.load)
            }
        },

        onClose() {
            this.observer.disconnect()
        },

        async infiniteScroll([{ isIntersecting, target }]) {
            if (isIntersecting) {
                const ul = target.offsetParent
                const scrollTop = target.offsetParent.scrollTop
                this.meta.limit += 20
                await this.buscarCategorias()
                await this.$nextTick()
                ul.scrollTop = scrollTop
            }
        },
    }
}
</script>
