<template>
  <div>

    <BBreadcrumb class="float-xl-end">
      <BBreadcrumbItem :to="localePath({ name: 'dashboard' })">{{ $t('pages.index.home') }}</BBreadcrumbItem>
      <BBreadcrumbItem :to="localePath({ name: 'products' })">{{PLURAL_NAME}}</BBreadcrumbItem>
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
                      <BaseInput id="name" v-model.trim="registry.name" :placeholder="labels.name" :readonly="isLoading" :class="classes" />
                      <InputErrorsList :errors="errors" />
                    </div>
                  </ValidationProvider>
                </BCol>
                <BCol>
                  <ValidationProvider v-slot="{ errors, classes }" vid="price" :name="labels.price" rules="required|gt_zero">
                    <div class="mb-3">
                      <label class="form-label required" for="price" :class="{'vee-error' : $validationHelper.hasFieldError(errors)}">{{labels.price}}</label>
                      <currency-input
                        v-model="registry.price"
                        :currency="$i18n.localeProperties.currency"
                        :locale="$i18n.localeProperties.code"
                        :allow-negative="false"
                        :auto-decimal-mode="true"
                        class="form-control"
                        :placeholder="labels.price"
                        :readonly="isLoading"
                        :class="classes"
                      />
                      <InputErrorsList :errors="errors" />
                    </div>
                  </ValidationProvider>
                </BCol>
              </BRow>

              <ValidationProvider v-slot="{ errors, classes }" vid="category_id" :name="labels.category_id" rules="required">
                <div class="mb-3">
                  <label class="form-label required" for="category_id" :class="{'vee-error' : $validationHelper.hasFieldError(errors)}">{{labels.category_id}}</label>
                  <SelectInfiniteCategory
                    v-model="registry.category"
                    input-id="category_id"
                    :class="classes"
                    :placeholder="labels.category_id"
                    :only-actives="true"
                  />
                  <InputErrorsList :errors="errors" />
                </div>
              </ValidationProvider>

              <ValidationProvider v-show="!isEdit" v-slot="{ errors }" :name="labels.active" rules="required">
                <label class="form-label col-form-label col-md-3">{{ $t('pages.form.statusLabel', {singular_name: SINGULAR_NAME.toLowerCase(), gender: 'male' }) }}</label>
                <small class="text-muted d-block mb-2">{{ $t('pages.form.statusWarning', {singular_name: SINGULAR_NAME.toLowerCase(), gender: 'male' }) }}</small>
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
import { SINGULAR_NAME as CATEGORY_NAME } from '~/repositories/CategoryRepository'
import { PLURAL_NAME, SINGULAR_NAME as PRODUCT_NAME } from '~/repositories/ProductRepository'

export default {
  components: {
    ValidationObserver,
    ValidationProvider
  },
  async asyncData({ params, $repository, error, $errorHandler }) {
    try {
      if (params.id > 0) {
        const registry = await $repository.products.show(params.id)

        registry.price = Number(registry.price)

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
      SINGULAR_NAME: this.$t(PRODUCT_NAME),
      labels: {
        name: this.$t('repositories.product.nameColumn'),
        category_id: this.$t(CATEGORY_NAME),
        price: this.$t('repositories.product.priceColumn'),
        active: this.$t('repositories.product.activeColumn'),
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

        const registry = {...this.registry}

        registry.category_id = (this.registry.category != null ? this.registry.category.id : null)

        const addedRegistry = await this.$repository.products.create(registry);

        this.$toast.success(this.$t('pages.form.successfullyCreated', {gender: 'male'}))

        this.$router.push(this.localePath({ name: 'products-form-id', params: {id : addedRegistry.id} }))

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

        this.registry.category_id = (this.registry.category != null ? this.registry.category.id : null)

        const updatedRegistry = await this.$repository.products.update(this.registry.id, this.registry);

        this.$toast.success(this.$t('pages.form.successfullyUpdated', {gender: 'male'}))

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
      this.$router.push(this.localePath({ name: 'products' }))
    }
  }
}
</script>
