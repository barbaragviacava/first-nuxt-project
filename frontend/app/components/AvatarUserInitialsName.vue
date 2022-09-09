<template>
    <div class="avatar-name text-center user-avatar" :class="{ 'rounded-circle' : rounded }" :style="cssVars" :title="userName">
        <span class="initials">{{userNameInitials}}</span>
    </div>
</template>

<script>
export default {
    props: {
        size: {
            default: '150px',
            type: String
        },

        rounded: {
            default: true,
            type: Boolean
        }
    },
    computed: {

        userNameInitials() {
            if (!this.userName) {
                return '';
            }
            const splittedName = this.userName.split(' ')

            const firstLetterFirstName = this.userName[0]

            let firstLetterLastName = ''
            if (splittedName.length > 1) {
                firstLetterLastName = splittedName.pop()[0]
            }

            return firstLetterFirstName + firstLetterLastName
        },

        userName() {
            return this.$auth.getUser().name.trim()
        },

        cssVars() {

            return {
                '--size': this.size,
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

.avatar-name {
    background-color: var(--bs-primary);
    color: white;
    text-transform: uppercase;
    line-height: var(--size);
}

.avatar-name .initials {
    font-size: calc(var(--size) / 2);
}
</style>
