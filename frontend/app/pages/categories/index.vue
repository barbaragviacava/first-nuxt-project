<template>
  <div>

    <BaseTitle>
      {{ PLURAL_NAME }}
      <small>{{ $t('pages.index.title', {name: PLURAL_NAME}) }}</small>
    </BaseTitle>

    <BBreadcrumb class="float-xl-end">
      <BBreadcrumbItem :to="localePath({ name: 'dashboard' })">{{ $t('pages.index.home') }}</BBreadcrumbItem>
      <BBreadcrumbItem active>{{ PLURAL_NAME }}</BBreadcrumbItem>
    </BBreadcrumb>

    <div class="mb-3">
      <NuxtLink :to="localePath({name: 'categories-form-id'})" class="btn btn-purple px-4">
        <fa icon="plus" class="me-2"/> {{ $t('pages.index.add') }} {{SINGULAR_NAME}}
      </NuxtLink>
    </div>

    <BasePanel>

      <template #body>

        <div class="rounded border p-3 mb-5">
          <div class="mb-3">
            <label class="d-flex align-items-center fs-5 fw-bold">
              <span class="required">{{ $t('pages.index.filters') }}</span>
            </label>
            <div class="fs-7 fw-bold text-muted">{{ $t('pages.index.filtersDescription') }}</div>
          </div>
          <BRow>
            <BCol cols="12" md="3" class="me-2 mb-2">
              <BInputGroup>
                <BInputGroupText class="bg-primary text-light border-0"><fa icon="search" /></BInputGroupText>
                <input v-model.lazy="filters.name" type="text" class="form-control" :placeholder="$t('pages.index.nameOf', {gender: 'female', name: SINGULAR_NAME})" autocomplete="off">
              </BInputGroup>
            </BCol>
            <BCol class="mb-2">
              <div class="btn-group" role="group">
                <input id="filter-active-1" v-model="filters.active" value="" class="btn-check" type="radio" name="active" autocomplete="off" />
                <label class="btn btn-outline-purple" for="filter-active-1">{{ $t('pages.index.showAll') }}</label>

                <input id="filter-active-2" v-model="filters.active" value="yes" class="btn-check" type="radio" name="active" />
                <label class="btn btn-outline-purple" for="filter-active-2">{{ $t('pages.index.onlyActives') }}</label>

                <input id="filter-active-3" v-model="filters.active" value="no" class="btn-check" type="radio" name="active" />
                <label class="btn btn-outline-purple" for="filter-active-3">{{ $t('pages.index.onlyInactives') }}</label>
              </div>
            </BCol>
          </BRow>
        </div>

        <BTable
          ref="table"
          responsive
          :items="list"
          :fields="fields"
          :filter="filters"
          :empty-text="$t('pages.index.table.emptyText')"
          :empty-filtered-text="$t('pages.index.table.emptyFilteredText')"
          :current-page="filters.page"
          :per-page="filters.limit"
          :sort-by.sync="order.sortBy"
          :sort-desc.sync="order.sortDesc"
        >
          <template #table-busy>
            <div class="w-100 text-center">
              <LoaderDefault :size="70" color="gray" />
            </div>
          </template>

          <template #cell(name)="row">
            <span>{{row.item.name}}</span>
            <div class="fw-bold fs-6 text-gray-500">{{ row.item.parent_category_id > 0 ? row.item.parentCategory.name : null }}</div>
          </template>

          <template #cell(active)="row">
            <BaseBadge
              outline
              :class="{'border-green text-lime': row.item.active, 'border-secondary text-black-50' : !row.item.active}"
            >
              <fa :icon="[row.item.active ? 'fas' : 'far', 'circle']" class="me-1" />
              {{row.item.active | YesNo}}
            </BaseBadge>
          </template>

          <template #cell(actions)="row">
            <BDropdown right text="Ações" variant="success" no-caret boundary="window">
              <template #button-content>
                {{ $t('pages.index.actions.actions') }} <fa icon="angle-down" class="ms-1" />
              </template>
              <BDropdownItem :to="localePath({name: 'categories-form-id', params: {id : row.item.id }})">
                {{ $t('pages.index.actions.edit') }}
              </BDropdownItem>
              <BDropdownItem @click="toggleActive(row.item)">
                {{ row.item.active ? $t('pages.index.actions.inactive') : $t('pages.index.actions.active') }}
              </BDropdownItem>
              <BDropdownItem @click="remove(row.item)">
                {{ $t('pages.index.actions.remove') }}
              </BDropdownItem>
            </BDropdown>
          </template>
        </BTable>

        <div v-if="meta.total > filters.limit" class="d-md-flex align-items-center">
          <div class="me-md-auto text-md-left text-center mb-2 mb-md-0">
            {{ $t('pages.index.pagination.paginationMessage', {per_page: filters.limit, total: meta.total, name: PLURAL_NAME.toLowerCase() }) }}
          </div>
          <ul class="pagination mb-0 justify-content-center">
            <BPagination
              v-model="filters.page"
              :total-rows="meta.total"
              :per-page="filters.limit"
            />
          </ul>
        </div>

      </template>
    </BasePanel>
  </div>
</template>

<script>
import { PLURAL_NAME, SINGULAR_NAME } from '~/repositories/CategoryRepository'

export default {
  data () {
    return {
      PLURAL_NAME: this.$t(PLURAL_NAME),
      SINGULAR_NAME: this.$t(SINGULAR_NAME),
      fields: [
        { key: 'name', label: this.$t('repositories.category.nameColumn'), sortable: true },
        {
          key: 'active',
          label: this.$t('pages.categories.table.activeColumn'),
          sortable: false
        },
        { key: 'actions', label: this.$t('pages.index.actions.actions'), thClass: 'text-end', tdClass: 'text-end' }
      ],
      meta: {
        total: 0
      },
      order: {
        sortBy: 'name',
        sortDesc: false,
      },
      filters: {
        active: '',
        limit: 20, // per_page
        page: 1 // current_page
      }
    }
  },
  head() {
    return {
      title: this.$t(PLURAL_NAME)
    }
  },
  computed: {
    isLoading() {
      return this.$coreLoading.isActive();
    },
    anyFilterApplied() {
      const {active, ...otherFilters } = this.filters
      return active != '' || Object.values(otherFilters).some(filter => filter != null && filter != '')
    }
  },
  methods: {
    async list() {

      const { data, meta } = await this.$repository.categories.list({
        sortBy: this.order.sortBy,
        sortDirection: (this.order.sortDesc ? 'desc' : 'asc'),
        ...this.filters
      });

      this.meta = meta

      return data;
    },

    edit(item) {
      this.$router.push(this.localePath({name: 'categories-form-id', params: {id : item.id }}));
    },

    toggleActive(item) {

      const singular_name = this.SINGULAR_NAME.toLowerCase()

      this.$swal.fire({
        title: this.$t('pages.index.toggleActiveAlert.title'),
        html: this.$t('pages.categories.toggleActiveAlert.html', {
          singular_name,
          item_name: item.name,
          status: this.$t('pages.index.toggleActiveAlert.' + (item.active ? 'in' : '') + 'activated', {gender: 'female'})
        }),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'var(--bs-primary)',
        confirmButtonText: this.$t('plugins.filters.yes'),
        cancelButtonText: this.$t('plugins.filters.no'),
      }).then(async (result) => {

        if (result.isConfirmed) {
          try {
            await this.$repository.categories.toggleActive(item.id)

            this.$refs.table.refresh();
          } catch (error) {
            const errorInfo = this.$errorHandler.setAndParse(error)

            this.$toast.error(errorInfo.message)
          }
        }
      })
    },

    remove(item) {
      const singular_name = this.SINGULAR_NAME.toLowerCase()

      this.$swal.fire({
        title: '',
        html: this.$t('pages.index.removeAlert.html', {singular_name, item_name: item.name, gender: 'female'}),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'var(--bs-primary)',
        confirmButtonText: this.$t('pages.index.removeAlert.confirmButtonText'),
        cancelButtonText: this.$t('pages.index.removeAlert.cancelButtonText'),
      }).then(async (result) => {

        if (result.isConfirmed) {
          try {
            await this.$repository.categories.delete(item.id)

            this.$refs.table.refresh();
          } catch (error) {
            const errorInfo = this.$errorHandler.setAndParse(error)

            this.$toast.error(errorInfo.message)
          }
        }
      })
    }
  }
}
</script>
