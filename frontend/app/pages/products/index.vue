<template>
    <div>

        <BaseTitle>
            {{ PLURAL_NAME }}
            <small>Gerenciamento de {{ PLURAL_NAME }}</small>
        </BaseTitle>

        <BBreadcrumb class="float-xl-end">
            <BBreadcrumbItem :to="{ name: 'dashboard' }">Início</BBreadcrumbItem>
            <BBreadcrumbItem active>{{ PLURAL_NAME }}</BBreadcrumbItem>
        </BBreadcrumb>

        <div class="mb-3">
            <NuxtLink :to="{name: 'products-form-id'}" class="btn btn-purple px-4">
                <fa icon="plus" class="me-2"/> Criar {{SINGULAR_NAME}}
            </NuxtLink>
        </div>

        <BasePanel>

            <template #body>

                <div class="rounded border p-3 mb-5">
                    <div class="mb-3">
                        <label class="d-flex align-items-center fs-5 fw-bold">
                            <span class="required">Filtros</span>
                        </label>
                        <div class="fs-7 fw-bold text-muted">Utilize os filtros abaixo para encontrar o(s) {{SINGULAR_NAME | lower }}(s) com mais facilidade</div>
                    </div>
                    <BRow>
                        <BCol cols="12" md="3" class="me-2 mb-2">
                            <BInputGroup>
                                <BInputGroupText class="bg-primary text-light border-0"><fa icon="search" /></BInputGroupText>
                                <input v-model.lazy="filters.name" type="text" class="form-control" :placeholder="'Nome do '+ SINGULAR_NAME" autocomplete="off">
                            </BInputGroup>
                        </BCol>
                        <BCol cols="12" md="3" class="mb-2">
                            <SelectInfiniteCategory
                                v-model="filters.categories"
                                class="d-inline"
                                multiple
                                :placeholder="CATEGORY_NAME"
                            />
                        </BCol>
                        <BCol class="mb-2">
                            <div class="btn-group" role="group">
                                <input id="filtro-active-1" v-model="filters.active" value="" class="btn-check" type="radio" name="active" autocomplete="off" />
                                <label class="btn btn-outline-purple" for="filtro-active-1">Mostrar todos</label>

                                <input id="filtro-active-2" v-model="filters.active" value="yes" class="btn-check" type="radio" name="active" />
                                <label class="btn btn-outline-purple" for="filtro-active-2">Apenas ativos</label>

                                <input id="filtro-active-3" v-model="filters.active" value="no" class="btn-check" type="radio" name="active" />
                                <label class="btn btn-outline-purple" for="filtro-active-3">Apenas inativos</label>
                            </div>
                        </BCol>
                    </BRow>
                </div>

                <div v-if="checkedItemsCount > 0" class="d-flex justify-content-end my-1">
                    <div class="me-2 pt-2">
                        <h5>{{checkedItemsCount}} itens selecionados</h5>
                    </div>
                    <div class="ms-2">
                        <BDropdown
                            right
                            text="O que fazer com os itens selecionados ?"
                            variant="lime"
                            split-variant="outline-lime"
                            split
                            boundary="window"
                        >
                            <BDropdownItem @click="activeAll()">
                                Ativar todos
                            </BDropdownItem>
                            <BDropdownItem @click="inactiveAll()">
                                Inativar todos
                            </BDropdownItem>
                            <BDropdownItem @click="removeAll()">
                                Remover todos
                            </BDropdownItem>
                        </BDropdown>
                    </div>
                    <div class="ms-2">
                        <BaseButton class="btn-outline-dark" @click="clearAllCheckedItems"><fa icon="minus-square" class="me-2" /> Limpar seleção de itens</BaseButton>
                    </div>
                </div>

                <BTable
                    ref="table"
                    responsive
                    :items="list"
                    :fields="fields"
                    :filter="filters"
                    :current-page="meta.current_page"
                    :per-page="meta.per_page"
                    :sort-by.sync="ordernation.sortBy"
                    :sort-desc.sync="ordernation.sortDesc"
                >
                    <template #table-busy>
                        <div class="w-100 text-center">
                            <LoaderDefault :size="70" color="gray" />
                        </div>
                    </template>

                    <template #head(checkbox)="">
                        <input v-model="isCheckAllChecked[meta.current_page]" class="form-check-input" type="checkbox" :disabled="isLoading" @click="checkAll">
                    </template>

                    <template #cell(checkbox)="row">
                        <input v-model="checkedItems" class="form-check-input" type="checkbox" :value="row.item.id">
                    </template>

                    <template #cell(price)="row">
                        <span>{{ $n(row.item.price, 'currency') }}</span>
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

                    <template #cell(name)="row">
                        <strong>{{row.item.name}}</strong>
                        <div class="fw-bold fs-6 text-gray-500">{{row.item.category.name}}</div>
                    </template>

                    <template #cell(actions)="row">
                        <BDropdown right text="Ações" variant="success" no-caret boundary="window">
                            <template #button-content>
                                Ações <fa icon="angle-down" class="ms-1" />
                            </template>
                            <BDropdownItem :to="{name: 'products-form-id', params: {id : row.item.id }}">
                                Editar
                            </BDropdownItem>
                            <BDropdownItem @click="toggleActive(row.item)">
                                {{ row.item.active ? 'Inativar' : 'Ativar' }}
                            </BDropdownItem>
                            <BDropdownItem @click="remove(row.item)">
                                Remover
                            </BDropdownItem>
                        </BDropdown>
                    </template>
                </BTable>

                <div v-if="meta.total > meta.per_page" class="d-md-flex align-items-center">
                    <div class="me-md-auto text-md-left text-center mb-2 mb-md-0">
                        Mostrando {{meta.per_page}} do total de {{meta.total}} {{ PLURAL_NAME | lower }}
                    </div>
                    <ul class="pagination mb-0 justify-content-center">
                        <BPagination
                            v-model="meta.current_page"
                            :total-rows="meta.total"
                            :per-page="meta.per_page"
                        />
                    </ul>
                </div>

            </template>
        </BasePanel>
    </div>
</template>

<script>
import { SINGULAR_NAME as CATEGORY_NAME } from '~/repositories/CategoryRepository'
import { PLURAL_NAME, SINGULAR_NAME as PRODUCT_NAME } from '~/repositories/ProductRepository'

export default {
    data () {
        return {
            CATEGORY_NAME,
            PLURAL_NAME,
            SINGULAR_NAME: PRODUCT_NAME,
            fields: [
                { key: 'checkbox', label: '', class: 'checkbox-column' },
                { key: 'name', label: 'Nome', sortable: true },
                { key: 'price', label: 'Preço', class: 'text-right', sortable: true },
                {
                    key: 'active',
                    label: 'Está ativo?',
                    sortable: false
                },
                { key: 'actions', label: 'Ações', thClass: 'text-end', tdClass: 'text-end' }
            ],
            meta: {
                total: 0,
                current_page: 1,
                per_page: 0,
                from: 0,
                to: 0,
            },
            ordernation: {
                sortBy: 'name',
                sortDesc: false,
            },
            filters: {
                active: ''
            },
            isCheckAllChecked: {},
            checkedItems: []
        }
    },
    head: {
        title: PLURAL_NAME
    },
    computed: {
        isLoading() {
            return this.$coreLoading.isActive();
        },
        localItemsId() {
            return this.$refs.table.localItems.map(item => item.id)
        },
        checkedItemsCount() {
            return this.checkedItems.length
        },
        lowerCaseSingularName() {
            return PRODUCT_NAME.toLowerCase();
        },
        lowerCasePluralName() {
            return PLURAL_NAME.toLowerCase();
        }
    },
    methods: {
        async list() {

            const {categories, ...otherFilters } = this.filters
            const categoriesIds = (categories || []).map(category => category.id)

            const { data, meta } = await this.$repository.products.list({
                sortBy: this.ordernation.sortBy,
                sortDirection: (this.ordernation.sortDesc ? 'desc' : 'asc'),
                page: this.meta.current_page,

                category_id: categoriesIds,
                ...otherFilters
            });

            this.meta = meta

            return data;
        },

        checkAll() {
            if (this.isCheckAllChecked[this.meta.current_page]) {
                this.checkedItems = this.checkedItems.filter(id => !this.localItemsId.includes(id));
            } else {
                this.checkedItems = this.checkedItems.concat(this.localItemsId)
            }
            // To avoid repeated ids
            this.checkedItems = [...new Set(this.checkedItems)]
        },

        clearAllCheckedItems() {
            this.checkedItems = []
            this.isCheckAllChecked = {}
        },

        edit(item) {
            this.$router.push({name: 'products-form-id', params: {id : item.id }});
        },

        toggleActive(item) {

            const singular_name = this.lowerCaseSingularName

            this.$swal.fire({
                title: 'Tem certeza?',
                html: `O ${singular_name} "${item.name}" será <strong>${item.active ? 'in' : ''}ativado</strong>.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--bs-primary)',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
            }).then(async (result) => {

                if (result.isConfirmed) {
                    try {
                        await this.$repository.products.toggleActive(item.id)

                        this.$refs.table.refresh();
                    } catch (error) {
                        const errorInfo = this.$errorHandler.setAndParse(error)

                        this.$toast.error(errorInfo.message)
                    }
                }
            })
        },

        remove(item) {
            const singular_name = this.lowerCaseSingularName

            this.$swal.fire({
                title: '',
                text: `Tem certeza que deseja remover o ${singular_name} "${item.name}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--bs-primary)',
                confirmButtonText: 'Sim, pode remover',
                cancelButtonText: 'Não, não quero remover',
            }).then(async (result) => {

                if (result.isConfirmed) {
                    try {
                        await this.$repository.products.delete(item.id)

                        this.$refs.table.refresh();
                    } catch (error) {
                        const errorInfo = this.$errorHandler.setAndParse(error)

                        this.$toast.error(errorInfo.message)
                    }
                }
            })
        },

        activeAll() {
            const plural_name = this.lowerCasePluralName

            this.$swal.fire({
                title: 'Tem certeza?',
                html: `Os ${plural_name} selecionados serão <strong>ativados</strong>.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--bs-primary)',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
            }).then(async (result) => {

                if (result.isConfirmed) {
                    try {
                        await this.$repository.products.activeMany(this.checkedItems)

                        this.clearAllCheckedItems()

                        this.$refs.table.refresh()
                    } catch (error) {
                        const errorInfo = this.$errorHandler.setAndParse(error)

                        this.$toast.error(errorInfo.message)
                    }
                }
            })
        },

        inactiveAll() {
            const plural_name = this.lowerCasePluralName

            this.$swal.fire({
                title: 'Tem certeza?',
                html: `Os ${plural_name} selecionados serão <strong>inativados</strong>.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--bs-primary)',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
            }).then(async (result) => {

                if (result.isConfirmed) {
                    try {
                        await this.$repository.products.inactiveMany(this.checkedItems)

                        this.clearAllCheckedItems()

                        this.$refs.table.refresh()
                    } catch (error) {
                        const errorInfo = this.$errorHandler.setAndParse(error)

                        this.$toast.error(errorInfo.message)
                    }
                }
            })
        },

        removeAll() {
            this.$swal.fire({
                title: '',
                text: `Tem certeza que deseja remover todos esses itens selecionados?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--bs-primary)',
                confirmButtonText: 'Sim, pode remover',
                cancelButtonText: 'Não, não quero remover',
            }).then(async (result) => {

                if (result.isConfirmed) {
                    try {
                        await this.$repository.products.deleteMany(this.checkedItems)

                        this.clearAllCheckedItems()

                        this.$refs.table.refresh()
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
