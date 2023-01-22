<template>
    <VSelect
        class="v-select-core-admin"
        :value="value"
        :placeholder="placeholder"
        :options="categories"
        :disabled="disabled"
        :multiple="multiple"
        :filterable="false"
        :reduce="reduce"
        :input-id="inputId"
        :get-option-key="(option) => option.id"
        :get-option-label="(option) => option.name"
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
        except: {
            type: Array,
            default: null
        },
    },
    data() {
        return {
            categories: [],
            observer: null,
            meta: {
                limit: 20,
                total: null
            }
        }
    },
    async fetch() {
        await this.findCategories()
    },
    computed: {
        hasNextPage() {
            return this.meta.limit < this.meta.total
        },
    },
    mounted() {
        this.observer = new IntersectionObserver(this.infiniteScroll)
    },
    methods: {

        async onSearch(search, loading) {
            loading(true)
            await this.findCategories(search)
            loading(false)
        },

        findCategories(search) {
            return this.$repository.categories.list({sortBy: 'name', name: search, except_id: this.except, limit: this.meta.limit}).then(({data, meta}) => {

                let categories = data
                if (!this.multiple) {
                    categories = [{
                            id: '',
                            name: 'Nenhuma',
                        },
                        ...data
                    ];
                }
                this.categories = categories
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
                await this.findCategories()
                await this.$nextTick()
                ul.scrollTop = scrollTop
            }
        },
    }
}
</script>