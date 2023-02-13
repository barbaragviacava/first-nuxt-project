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
        {{ $t('components.selectInfiniteCategory.searching') }}...
      </div>
    </template>

    <template slot="no-options">
      {{ $t('components.selectInfiniteCategory.noOptions') }}
    </template>

    <template #open-indicator="{ attributes }">
      <fa icon="angle-down" v-bind="attributes"></fa>
    </template>

    <template #list-footer>
      <li v-show="hasNextPage" ref="load" class="loader">
        {{ $t('components.selectInfiniteCategory.searchingMore') }}...
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
    onlyActives: {
      type: Boolean,
      default: false
    }
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

      const params = {
        sortBy: 'name',
        name: search,
        except_id: this.except,
        limit: this.meta.limit
      };

      if (this.onlyActives) {
        params.active = 'yes'
      }

      return this.$repository.categories.list(params).then(({data, meta}) => {

        let categories = data
        if (!this.multiple) {
          categories = [{
              id: '',
              name: this.$t('components.selectInfiniteCategory.emptyOption'),
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
