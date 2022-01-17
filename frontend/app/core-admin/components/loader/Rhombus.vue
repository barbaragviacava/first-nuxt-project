<template>
    <div class="loading-container">
        <div class="looping-rhombuses-spinner loading-item" :style="cssVars">
            <div class="rhombus" :style="cssVars"></div>
            <div class="rhombus" :style="cssVars"></div>
            <div class="rhombus" :style="cssVars"></div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        color: {
            default: 'var(--bs-primary)',
            type: String
        },
        size: {
            default: 15,
            type: Number
        }
    },
    computed: {
        cssVars() {

            return {
                '--color': this.color,
                '--size': this.size + 'px',
            }
        }
    }
}
</script>

<style scoped>

.loading-container {
    display: flex;
    align-items: center;
    justify-content: center;
}

.loading-item {
    max-width: 50%;
}

.looping-rhombuses-spinner, .looping-rhombuses-spinner * {
    box-sizing: border-box;
}

.looping-rhombuses-spinner {
    width: calc(var(--size) * 4);
    height: var(--size);
    position: relative;
}

.looping-rhombuses-spinner .rhombus {
    height: var(--size);
    width: var(--size);
    background-color: var(--color);
    left: calc(var(--size) * 4);
    position: absolute;
    margin: 0 auto;
    border-radius: 2px;
    transform: translateY(0) rotate(45deg) scale(0);
    animation: looping-rhombuses-spinner-animation 2500ms linear infinite;
}

.looping-rhombuses-spinner .rhombus:nth-child(1) {
    animation-delay: calc(2500ms * 1 / -1.5);
}

.looping-rhombuses-spinner .rhombus:nth-child(2) {
    animation-delay: calc(2500ms * 2 / -1.5);
}

.looping-rhombuses-spinner .rhombus:nth-child(3) {
    animation-delay: calc(2500ms * 3 / -1.5);
}

@keyframes looping-rhombuses-spinner-animation {
    0% {
        transform: translateX(0) rotate(45deg) scale(0);
    }
    50% {
        transform: translateX(-233%) rotate(45deg) scale(1);
    }
    100% {
        transform: translateX(-466%) rotate(45deg) scale(0);
    }
}
</style>
