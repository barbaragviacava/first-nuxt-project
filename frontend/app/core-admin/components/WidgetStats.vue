<template>
    <div class="widget widget-stats" :class="color">
        <div v-if="icon" class="stats-icon"><fa :icon="icon"></fa></div>
        <div class="stats-info">
            <h4 class="text-uppercase">{{infoTitle}}</h4>
            <p v-if="!loading">{{infoValue}}</p>
            <LoaderDefault v-else color="white" :size="30" />
        </div>
        <div v-if="linkToDetails" class="stats-link">
            <NuxtLink :to="linkToDetails">{{ $t('coreAdmin.components.widgetStats.seeDetails') }} <fa icon="arrow-alt-circle-right"></fa></NuxtLink>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        color: {
            default: 'bg-blue',
            type: String,
        },
        icon: {
            default: '',
            type: String,
        },
        infoTitle: {
            default: '',
            type: String,
            required: true,
        },
        infoValue: {
            default: '',
            required: true,
        },
        linkToDetails: {
            default: '',
            type: String,
        },
        loading: {
            default: false,
            type: Boolean,
        }
    }
}
</script>
