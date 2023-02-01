<template>
	<div class="error">
		<div class="error-code">{{errorCode}}</div>
		<div class="error-content">
			<div class="error-message">{{errorMessage}}</div>
      <br>
			<div>
        <button type="button" class="btn btn-success px-3" @click="$router.push(localePath({name:'dashboard', force: true}))">{{ $t('layouts.error.backpage') }}</button>
        <button type="button" class="btn btn-default ms-3" @click="$router.push(localePath({name:'logout', force: true}))">{{ $t('layouts.error.logout') }}</button>
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
        404: this.$t('layouts.error.errorMessage.404'),
        500: this.$t('layouts.error.errorMessage.500'),
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
