<template>
    <div>
        <div class="login login-v1">

            <div class="login-container">

                <div class="login-header">
                    <BaseLogo :slogan="true"></BaseLogo>
                    <div class="icon">
                        <fa icon="lock" size="5x"></fa>
                    </div>
                </div>

                <div class="login-body">
                    <div class="login-content fs-13px">
                        <Nuxt />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    middleware: ['auth'],
    auth: 'guest'
}
</script>
