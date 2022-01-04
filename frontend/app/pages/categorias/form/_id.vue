<template>
    <div>

        <BaseTitle>
            Categorias
            <small>{{isEdit ? 'Editando' : 'Criando uma nova'}} categoria</small>
        </BaseTitle>

        <BasePanel>
            <template #body>
                <ValidationObserver ref="form" v-slot="{ passes }">
                    <form method="POST" @submit.prevent="passes(onSubmit)">
                        <fieldset>

                            <BRow>
                                <BCol>
                                    <ValidationProvider v-slot="{ errors, classes }" :name="labels.nome" rules="required">
                                        <div class="mb-3">
                                            <label class="form-label" for="nome" :class="{'vee-error' : $validationHelper.hasFieldError(errors)}">{{labels.nome}}</label>
                                            <BaseInput id="nome" v-model="registro.nome" :placeholder="labels.nome" :readonly="isLoading" :class="classes" />
                                            <InputErrorsList :errors="errors" />
                                        </div>
                                    </ValidationProvider>
                                </BCol>
                                <BCol>
                                    <ValidationProvider v-slot="{ errors, classes }" :name="labels.categoria_pai_id" rules="required">
                                        <div class="mb-3">
                                            <label class="form-label" for="categoria_pai_id" :class="{'vee-error' : $validationHelper.hasFieldError(errors)}">{{labels.categoria_pai_id}}</label>
                                            <VSelect
                                                id="categoria_pai_id"
                                                v-model="registro.categoria_pai_id"
                                                :options="categorias"
                                                :placeholder="labels.categoria_pai_id"
                                                :readonly="isLoading"
                                                :class="classes"
                                                :filterable="false"
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
                                            </VSelect>
                                            <InputErrorsList :errors="errors" />
                                        </div>
                                    </ValidationProvider>
                                </BCol>
                            </BRow>

                            <ValidationProvider v-slot="{ errors }" :name="labels.active" rules="required">
                                <label class="form-label col-form-label col-md-3">Criar a categoria como ativa?</label>
                                <div class="form-check form-switch">
                                    <input id="active" v-model="registro.active" class="form-check-input" type="checkbox" />
                                    <label class="form-check-label" for="active">Sim</label>
                                </div>
                                <small class="text-muted">Você pode alterar a situação da categoria a qualquer momento</small>
                                <InputErrorsList :errors="errors" />
                            </ValidationProvider>

                            <hr />

                            <BaseButton type="submit" class="btn-purple" :loading="isLoading">{{isEdit ? 'Atualizar' : 'Criar'}}</BaseButton>
                            <BaseButton type="button" class="btn-default" title="Você será redirecionado para a listagem" @click="cancelar">Cancelar</BaseButton>

                        </fieldset>
                    </form>
                </ValidationObserver>

            </template>
        </BasePanel>

    </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";

export default {
    components: {
        ValidationObserver,
        ValidationProvider
    },
    data() {
        return {
            labels: {
                nome: 'Nome',
                categoria_pai_id: 'Categoria Pai',
                active: 'Situação',
            },
            registro: {
                active: true
            },
            categorias: []
        }
    },
    async fetch() {
        await this.buscarCategorias()
    },
    head() {
        return {
            title: (this.isEdit ? 'Editando' : 'Criando') +  ' Categoria',
        }
    },
    computed: {
        isLoading() {
            return this.$coreLoading.isActive();
        },
        isEdit() {
            return this.$route.params.id > 0
        }
    },
    methods: {

        onSubmit() {
            if (this.isEdit) {
                this.update()
            } else {
                this.store()
            }
        },

        async store() {
            try {

                const registroNovo = await this.$repository.categorias.create(this.registro);

                this.$toast.success('Criada com sucesso! Você será redirecionado para a tela de edição.')

                this.$router.push({ name: 'categorias-form-id', params: {id : registroNovo.id} })

                this.registro = registroNovo

            } catch (error) {
                const errorInfo = this.$errorHandler.setAndParse(error)

                if (errorInfo.status == 422) {
                    this.$refs.form.setErrors(this.$errorHandler.get());
                } else {
                    this.$toast.error(errorInfo.message)
                }
            }
        },

        update() {

        },

        cancelar() {
            this.$router.push({ name: 'categorias' })
        },

        async onSearch(search, loading) {
            loading(true)
            await this.buscarCategorias(search)
            loading(false)
        },

        buscarCategorias(search) {
            return this.$repository.categorias.list({active: true, sortBy: 'nome', nome: search}).then(({data}) => {
                console.log(data)
                this.categorias = data.map(categoria => ({label: categoria.nome, code: categoria.id}))
            })
        },
    }
}
</script>
