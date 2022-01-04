<template>
    <div id="content" class="app-content">
        <BaseTitle>Treinamento de Laravel com Vue.js</BaseTitle>

        <BasePanel>

            <template #body>

                <p>
                    Tudo começa na tela de <NuxtLink to="/login">login</NuxtLink>.
                </p>
                <p>
                    Dados de acesso são:
                </p>
                <dl>
                    <dt class="text-inverse">E-mail</dt>
                    <dd>barbara.gviacava@gmail.com</dd>
                    <dt class="text-inverse">Senha</dt>
                    <dd>password</dd>
                </dl>
            </template>
        </BasePanel>
    </div>
</template>

<script>
export default {
    layout: 'external-page'
}
</script>
