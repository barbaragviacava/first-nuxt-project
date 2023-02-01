<template>
  <div>

    <BBreadcrumb class="float-xl-end">
      <BBreadcrumbItem :to="localePath({ name: 'dashboard' })">{{ $t('pages.index.home') }}</BBreadcrumbItem>
      <BBreadcrumbItem :to="localePath({ name: 'categories' })">{{PLURAL_NAME}}</BBreadcrumbItem>
      <BBreadcrumbItem active>{{(isEdit ? $t('pages.form.editing') : $t('pages.form.creating')) +' '+ SINGULAR_NAME}}</BBreadcrumbItem>
    </BBreadcrumb>

    <BaseTitle>
      {{PLURAL_NAME}}
      <small>{{isEdit ? $t('pages.form.editing') : $t('pages.form.creating')}} {{SINGULAR_NAME | lower}}</small>
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
                <label class="form-label col-form-label col-md-3">{{ $t('pages.form.statusLabel', {singular_name: SINGULAR_NAME.toLowerCase(), gender: 'female' }) }}</label>
                <small class="text-muted d-block mb-2">{{ $t('pages.form.statusWarning', {singular_name: SINGULAR_NAME.toLowerCase(), gender: 'female' }) }}</small>
                <div class="form-check form-switch">
                  <input id="active" v-model="registry.active" class="form-check-input" type="checkbox" />
                  <label class="form-check-label" for="active">{{ $t('plugins.filters.yes') }}</label>
                </div>
                <InputErrorsList :errors="errors" />
              </ValidationProvider>

              <hr />

              <BaseButton type="submit" class="btn-purple w-100px" :loading="isLoading">{{ $t('pages.form.saveButton') }}</BaseButton>
              <BaseButton type="button" class="btn-default w-100px" title="Você será redirecionado para a listagem" @click="back">{{ $t('pages.form.backButton') }}</BaseButton>

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
      PLURAL_NAME: this.$t(PLURAL_NAME),
      SINGULAR_NAME: this.$t(SINGULAR_NAME),
      labels: {
        name: this.$t('repositories.category.nameColumn'),
        parent_category_id: this.$t('repositories.category.parentCategoryColumn'),
        active: this.$t('repositories.category.activeColumn'),
      },
      registry: {
        active: true
      }
    }
  },
  head() {
    return {
      title: (this.isEdit ? this.$t('pages.form.editing') : this.$t('pages.form.creating')) + ' '+ this.SINGULAR_NAME,
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

        this.$toast.success(this.$t('pages.form.successfullyCreated', {gender: 'female'}))

        this.$router.push(this.localePath({ name: 'categories-form-id', params: {id : newRegistry.id} }))

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

        this.$toast.success(this.$t('pages.form.successfullyUpdated', {gender: 'female'}))

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
      this.$router.push(this.localePath({ name: 'categories' }))
    }
  }
}
</script>
