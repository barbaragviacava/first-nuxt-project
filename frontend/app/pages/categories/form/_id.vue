<template>
    <div>

        <BBreadcrumb class="float-xl-end">
            <BBreadcrumbItem :to="{ name: 'dashboard' }">Início</BBreadcrumbItem>
            <BBreadcrumbItem :to="{ name: 'categories' }">{{PLURAL_NAME}}</BBreadcrumbItem>
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
                                    <ValidationProvider v-slot="{ errors, classes }" vid="name" :name="labels.name" rules="required">
                                        <div class="mb-3">
                                            <label class="form-label required" for="name" :class="{'vee-error' : $validationHelper.hasFieldError(errors)}">{{labels.name}}</label>
                                            <BaseInput id="name" v-model="registry.name" maxlength="40" :placeholder="labels.name" :readonly="isLoading" :class="classes" />
                                            <InputErrorsList :errors="errors" />
                                        </div>
                                    </ValidationProvider>
                                </BCol>
                                <BCol>
                                    <ValidationProvider v-slot="{ errors, classes }" vid="parent_category_id" :name="labels.parent_category_id">
                                        <div class="mb-3">
                                            <label class="form-label" for="parent_category_id" :class="{'vee-error' : $validationHelper.hasFieldError(errors)}">{{labels.parent_category_id}}</label>
                                            <SelectInfiniteCategory
                                                v-model="registry.parentCategory"
                                                input-id="parent_category_id"
                                                :except="isEdit ? [registry.id] : null"
                                                :class="classes"
                                                :placeholder="labels.parent_category_id"
                                            />
                                            <InputErrorsList :errors="errors" />
                                        </div>
                                    </ValidationProvider>
                                </BCol>
                            </BRow>

                            <ValidationProvider v-show="!isEdit" v-slot="{ errors }" :name="labels.active" rules="required">
                                <label class="form-label col-form-label col-md-3">Criar a {{SINGULAR_NAME | lower}} como ativa?</label>
                                <small class="text-muted d-block mb-2">Você pode alterar a situação da {{SINGULAR_NAME | lower}} a qualquer momento</small>
                                <div class="form-check form-switch">
                                    <input id="active" v-model="registry.active" class="form-check-input" type="checkbox" />
                                    <label class="form-check-label" for="active">Sim</label>
                                </div>
                                <InputErrorsList :errors="errors" />
                            </ValidationProvider>

                            <hr />

                            <BaseButton type="submit" class="btn-purple w-100px" :loading="isLoading">Salvar</BaseButton>
                            <BaseButton type="button" class="btn-default w-100px" title="Você será redirecionado para a listagem" @click="back">Voltar</BaseButton>

                        </fieldset>
                    </form>
                </ValidationObserver>

            </template>
        </BasePanel>

    </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { PLURAL_NAME, SINGULAR_NAME } from '~/repositories/CategoryRepository'

export default {
    components: {
        ValidationObserver,
        ValidationProvider
    },
    async asyncData({ params, $repository, error, $errorHandler }) {
        try {
            if (params.id > 0) {
                const registry = await $repository.categories.show(params.id)
                return { registry }
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
                name: 'Nome',
                parent_category_id: `${SINGULAR_NAME} Pai`,
                active: 'Situação',
            },
            registry: {
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

                this.registry.parent_category_id = (this.registry.parentCategory != null ? this.registry.parentCategory.id : null)

                const newRegistry = await this.$repository.categories.create(this.registry);

                this.$toast.success('Criada com sucesso! Você será redirecionado para a tela de edição.')

                this.$router.push({ name: 'categories-form-id', params: {id : newRegistry.id} })

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

                this.registry.parent_category_id = (this.registry.parentCategory != null ? this.registry.parentCategory.id : null)

                const updatedRegistry = await this.$repository.categories.update(this.registry.id, this.registry);

                this.$toast.success('Atualizada com sucesso!')

                this.registry = updatedRegistry

            } catch (error) {
                const errorInfo = this.$errorHandler.setAndParse(error)

                if (errorInfo.status == 422) {
                    this.$refs.form.setErrors(this.$errorHandler.get());
                } else {
                    this.$toast.error(errorInfo.message)
                }
            }
        },

        back() {
            this.$router.push({ name: 'categories' })
        }
    }
}
</script>
