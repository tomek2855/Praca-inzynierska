<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="login">Login</label>
                    <input v-model="login" v-on:keyup.enter="sendLogin" type="text" class="form-control" id="login" required>
                </div>
                <div class="form-group">
                    <label for="password">Hasło</label>
                    <input v-model="password" v-on:keyup.enter="sendLogin" type="password" class="form-control" id="password" required>
                </div>
                <button @click="sendLogin" type="submit" class="btn btn-primary">Login</button>
                <span v-if="error" class="error">{{ error }}</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "login-component",
        props: ["service"],
        data() {
            return {
                login: "",
                password: "",
                error: ""
            }
        },
        mounted() {
            if (localStorage.getItem("token")) {
                this.$router.push({ name: "home" })
            }
        },
        methods: {
            sendLogin() {
                let loader = this.$loading.show()

                this.service.login({
                    user: this.login,
                    password: this.password
                }).then(response => {
                    localStorage.token = response.data.token
                    this.refreshNavBar()
                    this.$router.push({ name: "home" })
                }).catch(error => {
                    this.error = error.response.data.message
                }).finally(() => {
                    loader.hide()
                })
            },
            refreshNavBar() {
                this.$root.$emit('refreshNavBar')
            }
        }
    }
</script>

<style scoped>

</style>