<template>
    <div class="panel" :class="{ 'panel-inverse' : inverse }">

        <div v-if="title" class="panel-heading">
            <h4 class="panel-title">{{title}}</h4>
        </div>

        <div class="panel-body">
            <slot name="body"></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        inverse: {
            default: true,
            type: Boolean
        },
        title: {
            default: '',
            type: String
        }
    }
}
</script>
