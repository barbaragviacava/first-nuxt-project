<template>
    <span class="badge shadow-sm fw-bolder" :class="classes">
        <slot></slot>
    </span>
</template>

<script>
export default {
    props: {
        bgColor: {
            default: 'primary',
            type: String
        },
        outline: {
            default: false,
            type: Boolean
        }
    },
    computed: {
        classes() {
            let classes = []
            if (this.outline) {
                classes = [
                    'border',
                    'bg-none',
                ];
            } else {
                classes = [
                    `bg-${this.bgColor}`
                ]
            }

            return classes;
        }
    }
}
</script>
