<template>
    <div class="container">
        <bar-component :title="'Panel administracyjny / Użytkownicy / ' + user.name" :menu="menu" :search="false"></bar-component>

            <table class="table" style="width: 50%;">
                <tbody>
                    <tr>
                        <td>Login</td>
                        <td>
                            <input v-model="user.name" type="text" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>Imię</td>
                        <td>
                            <input v-model="user.first_name" type="text" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>Nazwisko</td>
                        <td>
                            <input v-model="user.last_name" type="text" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>
                            <input v-model="user.email" type="text" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>Data utworzenia</td>
                        <td v-text="user.created_at"></td>
                    </tr>
                    <tr>
                        <td>Administrator</td>
                        <td>
                            <input v-model="user.is_admin" type="checkbox">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input @click="saveUser" class="btn btn-success" type="submit" value="Zapisz">
                            <button v-on:click="deleteUser" v-show="this.$route.params.id" class="btn btn-danger">Usuń użytkownika</button>
                        </td>
                    </tr>
                </tbody>
            </table>

        <span v-if="error" v-html="error" class="error"></span>
    </div>
</template>

<script>
    export default {
        name: "user-add-component",
        props: ["service"],
        data() {
            return {
                user: {name: ""},
                error: "",
                menu: []
            }
        },
        mounted() {
            if (this.$route.params.id) {
                this.menu = [
                    { name: "Powrót", link: { name: "admin.users.show", params: { id: this.$route.params.id } } },
                ]
            }

            this.getUser()
        },
        methods: {
            getUser() {
                if (this.$route.params.id) {
                    let loader = this.$loading.show()

                    this.service.getUser(this.$route.params.id).then(response => {
                        this.user = response.data
                    }).catch(error => {
                        this.error = error
                    }).finally(() => {
                        loader.hide()
                    })
                }
            },

            saveUser() {
                let loader = this.$loading.show()

                this.service.saveUser(this.user).then(response => {
                    this.$router.push({ name: "admin.users.show", params: { id: response.data.id } })
                }).catch(error => {
                    this.error = ""

                    if (error.response.data.errors.name) {
                        error.response.data.errors.name.forEach(item => {
                            this.error += "<br>" + item
                        })
                    }
                    if (error.response.data.errors.first_name) {
                        error.response.data.errors.first_name.forEach(item => {
                            this.error += "<br>" + item
                        })
                    }
                    if (error.response.data.errors.last_name) {
                        error.response.data.errors.last_name.forEach(item => {
                            this.error += "<br>" + item
                        })
                    }
                    if (error.response.data.errors.email) {
                        error.response.data.errors.email.forEach(item => {
                            this.error += "<br>" + item
                        })
                    }
                    if (error.response.data.errors.is_admin) {
                        error.response.data.errors.is_admin.forEach(item => {
                            this.error += "<br>" + item
                        })
                    }
                }).finally(() => {
                    loader.hide()
                })
            },

            deleteUser() {
                if (this.user.id) {
                    this.$dialog
                        .confirm('Na pewno usunąć?', {okText: "Tak", cancelText: "Nie"})
                        .then(() => {
                            let loader = this.$loading.show()

                            this.service.deleteUser(this.user.id).finally(() => {
                                loader.hide()
                                this.$router.push({ name: "admin.users" })
                            })
                        })
                }
            },
        }
    }
</script>

<style scoped>
    tr td:first-child {
        font-weight: bold;
    }
</style>
