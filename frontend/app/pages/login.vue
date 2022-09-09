<template>
    <ValidationObserver ref="form">
        <form method="POST" @submit.prevent="onSubmit">
            <ValidationProvider v-slot="{ errors }" :name="labels.email" rules="required">
                <div class="form-floating mb-20px">
                    <input v-model="user.email" type="email" class="form-control fs-13px h-45px" name="email" :placeholder="labels.email" :readonly="isLoading" />
                    <label for="emailAddress" class="d-flex align-items-center py-0" :class="{'vee-error' : $validationHelper.hasFieldError(errors)}">{{labels.email}}</label>
                    <small v-if="$validationHelper.hasFieldError(errors)">{{$validationHelper.getFieldErrorMessage(errors)}}</small>
                </div>
            </ValidationProvider>
            <ValidationProvider v-slot="{ errors }" :name="labels.password" rules="required">
                <div class="form-floating mb-20px">
                    <input v-model="user.password" type="password" class="form-control fs-13px h-45px" name="password" :placeholder="labels.password" :readonly="isLoading" />
                    <label for="password" class="d-flex align-items-center py-0" :class="{'vee-error' : $validationHelper.hasFieldError(errors)}">{{labels.password}}</label>
                    <small v-if="$validationHelper.hasFieldError(errors)">{{$validationHelper.getFieldErrorMessage(errors)}}</small>
                </div>
            </ValidationProvider>
            <div class="login-buttons">
                <BaseButton type="submit" class="btn h-45px btn-success d-block w-100 btn-lg" :loading="isLoading">Acessar</BaseButton>
            </div>
        </form>
    </ValidationObserver>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";

export default {
    components: {
        ValidationObserver,
        ValidationProvider
    },
    layout: 'login',
    data() {
        return {
            labels: {
                email : 'E-mail',
                password : 'Senha',
            },
            user: {
                email: '',
                password: '',
            }
        }
    },
    computed: {
        isLoading() {
            return this.$coreLoading.isActive();
        }
    },
    methods: {
        async onSubmit () {
            const success = await this.$refs.form.validate()
            if (!success) {
                return;
            }

            try {

                await this.$auth.login(this.user.email, this.user.password)

            } catch (errors) {

                const errorResponse = this.$errorHandler.setAndParse(errors)

                this.$swal({
                    icon: errorResponse.icon,
                    text: errorResponse.message
                })
            }
		}
    }
}
</script>
