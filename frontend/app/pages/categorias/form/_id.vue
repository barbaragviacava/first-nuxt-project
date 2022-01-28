<template>
    <div>

        <BBreadcrumb class="float-xl-end">
            <BBreadcrumbItem :to="{ name: 'dashboard' }">Início</BBreadcrumbItem>
            <BBreadcrumbItem :to="{ name: 'categorias' }">{{PLURAL_NAME}}</BBreadcrumbItem>
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
                                    <ValidationProvider v-slot="{ errors, classes }" vid="categoria_pai_id" :name="labels.categoria_pai_id">
                                        <div class="mb-3">
                                            <label class="form-label" for="categoria_pai_id" :class="{'vee-error' : $validationHelper.hasFieldError(errors)}">{{labels.categoria_pai_id}}</label>
                                            <SelectInfiniteCategoria
                                                v-model="registro.categoriaPai"
                                                input-id="categoria_pai_id"
                                                :class="classes"
                                                :placeholder="labels.categoria_pai_id"
                                                :disabled="isLoading"
                                            />
                                            <InputErrorsList :errors="errors" />
                                        </div>
                                    </ValidationProvider>
                                </BCol>
                            </BRow>

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
import { PLURAL_NAME, SINGULAR_NAME } from '~/repositories/CategoriaRepository'

export default {
    components: {
        ValidationObserver,
        ValidationProvider
    },
    async asyncData({ params, $repository, error, $errorHandler }) {
        try {
            if (params.id > 0) {
                const registro = await $repository.categorias.show(params.id)
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
            SINGULAR_NAME,
            labels: {
                nome: 'Nome',
                categoria_pai_id: `${SINGULAR_NAME} Pai`,
                active: 'Situação',
            },
            registro: {
                active: true
            }
        }
    },
    head() {
        return {
            title: (this.isEdit ? 'Editando' : 'Criando') + ' '+ SINGULAR_NAME,
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

                this.registro.categoria_pai_id = (this.registro.categoriaPai != null ? this.registro.categoriaPai.id : null)

                const registroNovo = await this.$repository.categorias.create(this.registro);

                this.$toast.success('Criada com sucesso! Você será redirecionado para a tela de edição.')

                this.$router.push({ name: 'categorias-form-id', params: {id : registroNovo.id} })

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

                this.registro.categoria_pai_id = (this.registro.categoriaPai != null ? this.registro.categoriaPai.id : null)

                const registroAtualizado = await this.$repository.categorias.update(this.registro.id, this.registro);

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
            this.$router.push({ name: 'categorias' })
        }
    }
}
</script>
