<template>
  <div>

    <BBreadcrumb class="float-xl-end">
      <BBreadcrumbItem :to="localePath({ name: 'dashboard' })">{{ $t('pages.index.home') }}</BBreadcrumbItem>
      <BBreadcrumbItem active>{{ $t('pages.user.profile.title') }}</BBreadcrumbItem>
    </BBreadcrumb>

    <BaseTitle>
      {{ $t('pages.user.profile.title') }}
      <small>{{ $t('pages.user.profile.description') }}</small>
    </BaseTitle>

    <BRow>
      <BCol md="2">

        <BCard no-body class="bg-dark mb-3">
          <BCardBody style="margin: 0 auto">
            <AvatarUser class="img-thumbnail" size="150px" :rounded="false" />
          </BCardBody>

          <BCardBody class="text-center bg-white">
            <BaseButton type="button" class="btn btn-link" :loading="isLoading" @click="$refs.file.click()">
              {{ $t('pages.user.profile.changeAvatarButton') }}
            </BaseButton>

            <form ref="formFile">
              <input ref="file" type="file" accept="image/*" class="d-none" @change="loadImage($event)" />
            </form>
          </BCardBody>
        </BCard>

      </BCol>
      <BCol>
        <BasePanel>
          <template #body>

            <ValidationObserver ref="form" v-slot="{ passes }">
              <form method="POST" @submit.prevent="passes(onSubmit)">

                <fieldset>
                  <div class="row mb-3">
                    <div class="col-md-6">

                      <ValidationProvider v-slot="{ errors, classes }" vid="name" :name="labels.name" rules="required">
                        <InputFloating v-model="user.name" type="text" maxlength="250" :label="labels.name" :input-classes="classes" :readonly="isLoading" />
                        <InputErrorsList :errors="errors" />
                      </ValidationProvider>

                      <br />

                      <ValidationProvider v-slot="{ errors, classes }" vid="email" :name="labels.email" rules="required|email">
                        <InputFloating v-model="user.email" type="email" maxlength="250" :label="labels.email" :input-classes="classes" :readonly="isLoading" />
                        <InputErrorsList :errors="errors" />
                      </ValidationProvider>
                    </div>
                  </div>
                  <hr />
                  <BaseButton type="submit" class="btn-purple w-100px me-5px" :loading="isLoading">{{ $t('pages.form.saveButton') }}</BaseButton>
                </fieldset>
              </form>
            </ValidationObserver>

          </template>
        </BasePanel>
      </BCol>
    </BRow>

    <BModal
      id="modal-cropper"
      hide-header
      :cancel-title="$t('pages.form.cancelButton')"
      :ok-title="$t('pages.form.saveButton')"
      @hidden="onModalHidden"
      @ok="crop">

      <Cropper
          ref="cropper"
          class="upload-example__cropper"
          check-orientation
          :src="image"
          :debounce="false"
          :stencil-props="{
              aspectRatio: 1,
          }"
          :max-height="500"
          :max-width="500"
          @change="onCropperChange"
      />

      <BContainer fluid class="p-4 bg-dark">
        <div class="d-flex justify-content-center">
          <div class="p-4">
            <CropperPreview
              class="img-thumbnail"
              :width="120"
              :height="120"
              :image="preview.image"
              :coordinates="preview.coordinates"
            />
          </div>
          <div class="p-4">
            <CropperPreview
              class="img-thumbnail"
              :width="90"
              :height="90"
              :image="preview.image"
              :coordinates="preview.coordinates"
            />
          </div>
          <div class="p-4">
            <CropperPreview
              class="img-thumbnail"
              :width="50"
              :height="50"
              :image="preview.image"
              :coordinates="preview.coordinates"
            />
          </div>
        </div>
      </BContainer>

      <template #modal-footer>
        <div class="w-100">
          <BaseButton class="btn btn-secondary" :loading="isLoading" @click="$bvModal.hide('modal-cropper')">{{ $t('pages.form.cancelButton') }}</BaseButton>
          <BaseButton class="btn btn-primary" :loading="isLoading" @click="crop()">{{ $t('pages.form.saveButton') }}</BaseButton>
        </div>
      </template>

    </BModal>

  </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";

export default {
  components: {
    ValidationObserver,
    ValidationProvider
  },
  asyncData({ $auth }) {
    const user = $auth.getUser()

    return {
      user: {
        name: user.name,
        email: user.email
      }
    }
  },
  data() {
    return {
      labels: {
        name : this.$t('repositories.user.nameColumn'),
        email : 'E-mail'
      },
      size: 150,
      image: null,
      preview: {
        coordinates: null,
        image: null
      }
    }
  },
  head() {
    return {
      title: this.$t('pages.user.profile.title'),
    }
  },
  computed: {
    isLoading() {
      return this.$coreLoading.isActive();
    },

    cssVars() {
      return {
        '--size': this.size + 'px'
      }
    },
  },
  methods: {

    async onSubmit() {
      try {

        const updatedUser = await this.$repository.users.update(this.user);

        this.user.name = updatedUser.name
        this.user.email = updatedUser.email

        this.$auth.setUser(this.user)

        this.$toast.success(this.$t('pages.form.successfullyUpdated', {gender: 'male'}))

      } catch (error) {
        const errorInfo = this.$errorHandler.setAndParse(error)

        if (errorInfo.status == 422) {
          this.$refs.form.setErrors(this.$errorHandler.get());
        } else {
          this.$toast.error(errorInfo.message)
        }
      }
    },

    onCropperChange({ coordinates, image }) {
			this.preview = {
				coordinates,
				image
			};
		},

    onModalHidden() {
      this.image = null
      this.preview = {
				coordinates: null,
				image: null
      }
      this.$refs.formFile.reset();
    },

    crop() {
			const { canvas } = this.$refs.cropper.getResult();
			canvas.toBlob(async (blob) => {

				const formData = new FormData();

        formData.append('avatar', blob);

        const { url } = await this.$repository.users.avatar(formData);

        this.$auth.setUser({ avatar: url })

        this.$bvModal.hide('modal-cropper')

        this.$toast.success(this.$t('pages.user.profile.imageSuccessfullyUpdated'))

			}, 'image/jpg');
		},

		loadImage(event) {

      this.$bvModal.show('modal-cropper')

			const { files } = event.target;

			if (files && files[0]) {

				// Revoke the object URL, to allow the garbage collector to destroy the uploaded before file
				if (this.image) {
					URL.revokeObjectURL(this.image);
				}

				// Create the blob link to the file to optimize performance:
				const blob = URL.createObjectURL(files[0]);
				const reader = new FileReader();

				reader.onload = (e) => {
					this.image = blob;
				};

				reader.readAsArrayBuffer(files[0]);
			}
		}
  }
}
</script>

<style scoped>

.avatar-buttons-container {
  position: relative;
}

.avatar-buttons-container .btn-camera {
  position: absolute;
  top:40%;
  left:45%;
}

.btn-camera input {
  display: none;
}

.user-avatar {
  width: var(--size);
  height: var(--size);
}

</style>
