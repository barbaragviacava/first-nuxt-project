<template>
    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
        viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve" class="loading" :style="cssVars">
        <rect :fill="color" width="3" height="100" transform="translate(0) rotate(180 3 50)">
            <animate
                attributeName="height"
                attributeType="XML"
                dur="1s"
                values="30; 100; 30"
                repeatCount="indefinite"/>
        </rect>
        <rect x="17" :fill="color" width="3" height="100" transform="translate(0) rotate(180 20 50)">
            <animate
                attributeName="height"
                attributeType="XML"
                dur="1s"
                values="30; 100; 30"
                repeatCount="indefinite"
                begin="0.1s"/>
        </rect>
        <rect x="40" :fill="color" width="3" height="100" transform="translate(0) rotate(180 40 50)">
            <animate
                attributeName="height"
                attributeType="XML"
                dur="1s"
                values="30; 100; 30"
                repeatCount="indefinite"
                begin="0.3s"/>
        </rect>
        <rect x="60" :fill="color" width="3" height="100" transform="translate(0) rotate(180 58 50)">
        <animate
            attributeName="height"
            attributeType="XML"
            dur="1s"
            values="30; 100; 30"
            repeatCount="indefinite"
            begin="0.5s"/>
        </rect>
        <rect x="80" :fill="color" width="3" height="100" transform="translate(0) rotate(180 76 50)">
            <animate
                attributeName="height"
                attributeType="XML"
                dur="1s"
                values="30; 100; 30"
                repeatCount="indefinite"
                begin="0.1s"/>
        </rect>
    </svg>
</template>

<script>
export default {
    props: {
        color: {
            default: 'var(--bs-primary)',
            type: String
        },
        size: {
            default: 50,
            type: Number
        }
    },
    computed: {
        cssVars() {

            return {
                '--size': this.size + 'px',
            }
        }
    }
}
</script>

<style scoped>
.loading {
  width: var(--size);
  height: var(--size);
  display:inline-block;
}
</style>
