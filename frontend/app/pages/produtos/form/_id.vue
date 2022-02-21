<template>
    <div>

        <BBreadcrumb class="float-xl-end">
            <BBreadcrumbItem :to="{ name: 'dashboard' }">Início</BBreadcrumbItem>
            <BBreadcrumbItem :to="{ name: 'produtos' }">{{PLURAL_NAME}}</BBreadcrumbItem>
            <BBreadcrumbItem active>{{(isEdit ? 'Editando' : 'Criando') +' '+ SINGULAR_NAME}}</BBreadcrumbItem>
        </BBreadcrumb>

        <BaseTitle>
            {{PLURAL_NAME}}
            <small>{{isEdit ? 'Editando' : 'Criando uma nova'}} {{SINGULAR_NAME | lower}}</small>
        </BaseTitle>

        <BasePanel>
            <template #body>
                <ValidationObserver ref="form" v-slot="{ passes }">
                    <form method="POST" @submit.prevent="passes(onSubmit)">
                        <fieldset>

                            <BRow>
                                <BCol>
                                    <ValidationProvider v-slot="{ errors, classes }" vid="nome" :name="labels.nome" rules="required">
                                        <div class="mb-3">
                                            <label class="form-label required" for="nome" :class="{'vee-error' : $validationHelper.hasFieldError(errors)}">{{labels.nome}}</label>
                                            <BaseInput id="nome" v-model.trim="registro.nome" :placeholder="labels.nome" :readonly="isLoading" :class="classes" />
                                            <InputErrorsList :errors="errors" />
                                        </div>
                                    </ValidationProvider>
                                </BCol>
                                <BCol>
                                    <ValidationProvider v-slot="{ errors, classes }" vid="preco" :name="labels.preco" rules="required|gt_zero">
                                        <div class="mb-3">
                                            <label class="form-label required" for="preco" :class="{'vee-error' : $validationHelper.hasFieldError(errors)}">{{labels.preco}}</label>
                                            <currency-input v-model="registro.preco" class="form-control" :placeholder="labels.preco" :readonly="isLoading" :class="classes" />
                                            <InputErrorsList :errors="errors" />
                                        </div>
                                    </ValidationProvider>
                                </BCol>
                            </BRow>

                            <ValidationProvider v-slot="{ errors, classes }" vid="categoria_id" :name="labels.categoria_id" rules="required">
                                <div class="mb-3">
                                    <label class="form-label required" for="categoria_id" :class="{'vee-error' : $validationHelper.hasFieldError(errors)}">{{labels.categoria_id}}</label>
                                    <SelectInfiniteCategoria
                                        v-model="registro.categoria"
                                        input-id="categoria_id"
                                        :class="classes"
                                        :placeholder="labels.categoria_id"
                                    />
                                    <InputErrorsList :errors="errors" />
                                </div>
                            </ValidationProvider>

                            <ValidationProvider v-show="!isEdit" v-slot="{ errors }" :name="labels.active" rules="required">
                                <label class="form-label col-form-label col-md-3">Criar a {{SINGULAR_NAME | lower}} como ativa?</label>
                                <div class="form-check form-switch">
                                    <input id="active" v-model="registro.active" class="form-check-input" type="checkbox" />
                                    <label class="form-check-label" for="active">Sim</label>
                                </div>
                                <small class="text-muted">Você pode alterar a situação da {{SINGULAR_NAME | lower}} a qualquer momento</small>
                                <InputErrorsList :errors="errors" />
                            </ValidationProvider>

                            <hr />

                            <BaseButton type="submit" class="btn-purple w-100px" :loading="isLoading">Salvar</BaseButton>
                            <BaseButton type="button" class="btn-default w-100px" title="Você será redirecionado para a listagem" @click="voltar">Voltar</BaseButton>

                        </fieldset>
                    </form>
                </ValidationObserver>

            </template>
        </BasePanel>

    </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { SINGULAR_NAME as CATEGORIA_NAME } from '~/repositories/CategoriaRepository'
import { PLURAL_NAME, SINGULAR_NAME as PRODUTO_NAME } from '~/repositories/ProdutoRepository'

export default {
    components: {
        ValidationObserver,
        ValidationProvider
    },
    async asyncData({ params, $repository, error, $errorHandler }) {
        try {
            if (params.id > 0) {
                const registro = await $repository.produtos.show(params.id)

                registro.preco = Number(registro.preco)

                return { registro }
            }
        } catch(errorException) {
            const errorResponse = $errorHandler.setAndParse(errorException)

            error({ statusCode: errorResponse.status, message: errorResponse.message })
        }
        return {}
    },
    data() {
        return {
            PLURAL_NAME,
            SINGULAR_NAME: PRODUTO_NAME,
            labels: {
                nome: 'Nome',
                categoria_id: CATEGORIA_NAME,
                preco: 'Preço',
                active: 'Situação',
            },
            registro: {
                active: true
            }
        }
    },
    head() {
        return {
            title: (this.isEdit ? 'Editando' : 'Criando') + ' '+ PRODUTO_NAME,
        }
    },
    computed: {
        isLoading() {
            return this.$coreLoading.isActive();
        },
        isEdit() {
            return this.$route.params.id > 0
        },
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

                const registro = {...this.registro}

                registro.categoria_id = (this.registro.categoria != null ? this.registro.categoria.id : null)

                const registroAdicionado = await this.$repository.produtos.create(registro);

                this.$toast.success('Criada com sucesso! Você será redirecionado para a tela de edição.')

                this.$router.push({ name: 'produtos-form-id', params: {id : registroAdicionado.id} })

            } catch (error) {
                const errorInfo = this.$errorHandler.setAndParse(error)

                if (errorInfo.status == 422) {
                    this.$refs.form.setErrors(this.$errorHandler.get());
                } else {
                    this.$toast.error(errorInfo.message)
                }
            }
        },

        async update() {
            try {

                this.registro.categoria_id = (this.registro.categoria != null ? this.registro.categoria.id : null)

                const registroAtualizado = await this.$repository.produtos.update(this.registro.id, this.registro);

                this.$toast.success('Atualizada com sucesso!')

                this.registro = registroAtualizado

            } catch (error) {
                const errorInfo = this.$errorHandler.setAndParse(error)

                if (errorInfo.status == 422) {
                    this.$refs.form.setErrors(this.$errorHandler.get());
                } else {
                    this.$toast.error(errorInfo.message)
                }
            }
        },

        voltar() {
            this.$router.push({ name: 'produtos' })
        }
    }
}
</script>
