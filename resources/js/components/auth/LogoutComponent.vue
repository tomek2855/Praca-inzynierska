<template>
    <div class="container">
        <span v-if="error">{{ error }}</span>
    </div>
</template>

<script>
    export default {
        name: "logout-component",
        props: ["service"],
        data() {
            return {
                error: ""
            }
        },
        mounted() {
            this.service.logout().then(response => {
                localStorage.removeItem("token")
                this.refreshNavBar()
                this.$router.push({ name: "home" })
            }).catch(error => {
                this.error = error
            })
        },
        methods: {
            refreshNavBar() {
                this.$root.$emit('refreshNavBar')
            }
        }
    }
</script>

<style scoped>
    span {
        color: red;
    }
</style>