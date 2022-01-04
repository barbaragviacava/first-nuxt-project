<template>
    <div>

        <img v-if="userImage != null" :src="userImage" class="user-avatar" :class="{ 'rounded-circle' : rounded }" :style="cssVars" :title="userName" />
        <AvatarUserInitialsName v-else :size="size" :rounded="rounded" />

    </div>
</template>

<script>
export default {
    props: {
        size: {
            default: '150px',
            type: String
        },

        imageUrl: {
            default: '',
            type: String
        },

        rounded: {
            default: true,
            type: Boolean
        }
    },
    computed: {

        userName() {
            return this.$auth.getUser().name
        },

        userImage() {
            return this.imageUrl || this.$auth.getUser().avatar
        },

        cssVars() {

            return {
                '--size': this.size
            }
        }
    }
}
</script>

<style scoped>
.user-avatar {
    height: var(--size);
    width: var(--size);
}
</style>
