<template>
    <div>

        <BaseTitle>
            Categorias
            <small>Gerenciamento de categorias</small>
        </BaseTitle>

        <BasePanel>

            <template #body>

                <BRow class="my-3">
                    <BCol cols="12" md="3" class="me-2 mb-2">
                        <BInputGroup>
                            <BInputGroupText class="bg-primary text-light border-0"><fa icon="search" /></BInputGroupText>
                            <input v-model.lazy="filtros.nome" type="text" class="form-control" placeholder="Pesquise pelo nome aqui">
                        </BInputGroup>
                    </BCol>
                    <BCol cols="6" md="4" class="mb-2">
                        <BDropdown right split no-flip variant="white" menu-class="w-300px">
                            <template #button-content>
                                <fa icon="filter" class="me-2" /> Mais Filtros
                            </template>
                            <BDropdownForm>
                                <fieldset>
                                    <div class="mb-3">
                                        <label class="form-label">Situação</label>
                                        <div class="form-check mb-2">
                                            <input id="filtro-actived-1" v-model="filtros.active" value="" class="form-check-input" type="radio" name="actived" checked />
                                            <label class="form-check-label" for="filtro-actived-1">Todas</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input id="filtro-actived-2" v-model="filtros.active" value="sim" class="form-check-input" type="radio" name="actived" />
                                            <label class="form-check-label" for="filtro-actived-2">Apenas ativas</label>
                                        </div>
                                        <div class="form-check">
                                            <input id="filtro-actived-3" v-model="filtros.active" value="nao" class="form-check-input" type="radio" name="actived" />
                                            <label class="form-check-label" for="filtro-actived-3">Apenas inativas</label>
                                        </div>
                                    </div>
                                </fieldset>
                            </BDropdownForm>
                        </BDropdown>
                    </BCol>
                    <BCol class="text-end mb-2">
                        <BaseButton class="btn-purple px-4" @click="criar">
                            <fa icon="plus" class="me-2"/> Criar Categoria
                        </BaseButton>
                    </BCol>
                </BRow>

                <BTable
                    table-class="table-row-dashed align-middle fsuper"
                    responsive
                    :items="listar"
                    :fields="fields"
                    :filter="filtros"
                    :current-page="meta.current_page"
                    :per-page="meta.per_page"
                    :sort-by="ordernation.sortBy"
                    :sort-desc="ordernation.sortDesc"
                    @sort-changed="onSortChange"
                >
                    <template #table-busy>
                        <BaseLoading color="gray" />
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
                        <BDropdown right text="Ações" variant="default" no-caret>
                            <template #button-content>
                                Ações <fa icon="angle-down" class="ms-1" />
                            </template>
                            <BDropdownItem @click="edit(row.item)">
                                Editar
                            </BDropdownItem>
                            <BDropdownItem @click="toggleActived(row.item)">
                                {{ row.item.active ? 'Inativar' : 'Ativar' }}
                            </BDropdownItem>
                            <BDropdownItem @click="remove(row.item)">
                                Remover
                            </BDropdownItem>
                        </BDropdown>
                    </template>
                </BTable>

                <div class="d-md-flex align-items-center">
                    <div class="me-md-auto text-md-left text-center mb-2 mb-md-0">
                        Mostrando {{meta.per_page}} do total de {{meta.total}} categorias
                    </div>
                    <ul class="pagination mb-0 justify-content-center">
                        <BPagination
                            v-model="meta.current_page"
                            :total-rows="meta.total"
                            :per-page="meta.per_page"
                            align="fill"
                            first-text="Primeira"
                            prev-text="Anterior"
                            next-text="Próxima"
                            last-text="Última"
                        />
                    </ul>
                </div>

            </template>
        </BasePanel>
    </div>
</template>

<script>
export default {
    data () {
        return {
            fields: [
                { key: 'nome', label: 'Nome', sortable: true },
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
                sortBy: 'nome',
                sortDesc: false,
            },
            filtros: {}
        }
    },
    head: {
        title: 'Categorias'
    },
    methods: {
        async listar() {
            const { data, meta } = await this.$repository.categorias.list({
                sortBy: this.ordernation.sortBy,
                sortDirection: (this.ordernation.sortDesc ? 'desc' : 'asc'),
                page: this.meta.current_page,
                ...this.filtros
            });

            this.meta = meta

            return data;
        },

        onSortChange(ctx) {
            this.ordernation.sortBy = ctx.sortBy
            this.ordernation.sortDesc = ctx.sortDesc
        },

        edit(item) {
            this.$router.push({name: 'categorias-form-id', params: {id : item.id }});
        },

        toggleActived(item) {

        },

        remove(item) {

        },

        criar() {
            this.$router.push({name: 'categorias-form-id'})
        },
    }
}
</script>
