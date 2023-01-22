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
            <NuxtLink :to="{name: 'categories-form-id'}" class="btn btn-purple px-4">
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
                        <div class="fs-7 fw-bold text-muted">Utilize os filtros abaixo para encontrar a(s) {{SINGULAR_NAME | lower }}(s) com mais facilidade</div>
                    </div>
                    <BRow>
                        <BCol cols="12" md="3" class="me-2 mb-2">
                            <BInputGroup>
                                <BInputGroupText class="bg-primary text-light border-0"><fa icon="search" /></BInputGroupText>
                                <input v-model.lazy="filters.name" type="text" class="form-control" :placeholder="'Nome da '+ SINGULAR_NAME" autocomplete="off">
                            </BInputGroup>
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

                    <template #cell(active)="row">
                        <BaseBadge
                            outline
                            :class="{'border-green text-lime': row.item.active, 'border-secondary text-black-50' : !row.item.active}"
                        >
                            <fa :icon="[row.item.active ? 'fas' : 'far', 'circle']" class="me-1" />
                            {{row.item.active | YesNo}}
                        </BaseBadge>
                    </template>

                    <template #cell(parent_category)="row">
                        {{ row.item.parent_category_id > 0 ? row.item.parentCategory.name : null }}
                    </template>

                    <template #cell(actions)="row">
                        <BDropdown right text="Ações" variant="success" no-caret boundary="window">
                            <template #button-content>
                                Ações <fa icon="angle-down" class="ms-1" />
                            </template>
                            <BDropdownItem :to="{name: 'categories-form-id', params: {id : row.item.id }}">
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
import { PLURAL_NAME, SINGULAR_NAME } from '~/repositories/CategoryRepository'

export default {
    data () {
        return {
            PLURAL_NAME,
            SINGULAR_NAME,
            fields: [
                { key: 'name', label: 'Nome', sortable: true },
                { key: 'parent_category', label: 'Categoria Pai' },
                {
                    key: 'active',
                    label: 'Está ativa?',
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
            }
        }
    },
    head: {
        title: PLURAL_NAME
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
                sortBy: this.ordernation.sortBy,
                sortDirection: (this.ordernation.sortDesc ? 'desc' : 'asc'),
                page: this.meta.current_page,
                ...this.filters
            });

            this.meta = meta

            return data;
        },

        edit(item) {
            this.$router.push({name: 'categories-form-id', params: {id : item.id }});
        },

        toggleActive(item) {

            const singular_name = SINGULAR_NAME.toLowerCase()

            this.$swal.fire({
                title: 'Tem certeza?',
                html: `A ${singular_name} "${item.name}" e suas associadas serão <strong>${item.active ? 'in' : ''}ativadas</strong>.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--bs-primary)',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
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
            const singular_name = SINGULAR_NAME.toLowerCase()

            this.$swal.fire({
                title: '',
                text: `Tem certeza que deseja remover a ${singular_name} "${item.name}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--bs-primary)',
                confirmButtonText: 'Sim, pode remover',
                cancelButtonText: 'Não, não quero remover',
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