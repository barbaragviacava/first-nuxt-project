<template>
  <div id="content" class="app-content">
    <BaseTitle>{{ $t('pages.initial.title') }}</BaseTitle>

    <BasePanel>

      <template #body>

        <p>
          {{ $t('pages.initial.start') }} <NuxtLink :to="localePath({name: 'login'})">login</NuxtLink>.
        </p>
        <p>
          {{ $t('pages.initial.accessData') }}
        </p>
        <dl>
          <dt class="text-inverse">E-mail</dt>
          <dd>barbara.gviacava@gmail.com</dd>
          <dt class="text-inverse">{{ $t('pages.initial.password') }}</dt>
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
