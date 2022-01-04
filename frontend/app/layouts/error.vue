<template>
	<div class="error">
		<div class="error-code">{{errorCode}}</div>
		<div class="error-content">
			<div class="error-message">{{errorMessage}}</div>
            <br>
			<div>
				<button type="button" class="btn btn-success px-3" @click="$router.push({name:'dashboard', force: true})">Voltar para a tela inicial</button>
			</div>
		</div>
	</div>
</template>

<script>
export default {
    layout: 'base-app',
    props: ['error'],
    computed: {

        errorMessage() {

            const defaultMessages = {
                404: 'Não conseguimos encontrar a funcionalidade que você tentou acessar. Por favor, tente novamente ou entre em contato com a nossa equipe.',
                500: 'Ixi! Você descobriu um problema que a nossa equipe precisa investigar. Por favor, informe o nosso suporte sobre o ocorrido.',
            }

            if (!defaultMessages[this.error.statusCode]) {
                return defaultMessages[500]
            }

            let isDev = false
            if (this.$store && this.$store.app && this.$store.app.context) {
                isDev = this.$store.app.context.isDev
            }

            return isDev ? this.error.message : defaultMessages[this.error.statusCode];
        },

        errorCode() {
            return this.error.statusCode || 500;
        }
    }
}
</script>
