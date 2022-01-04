<template>

    <input type="text" class="form-control" :value="value" v-bind="$props" @input="$emit('input', $event.target.value)">

</template>

<script>
export default {
    props: ['value'],
}
</script>
