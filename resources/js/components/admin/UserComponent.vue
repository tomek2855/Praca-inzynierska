<template>
    <div class="container">
        <bar-component :title="'Panel administracyjny / Użytkownicy / ' + user.name" :menu="menu" :search="false"></bar-component>

        <div class="row">
            <div class="col-6">
                <h4>Dane podstawowe</h4>
                <table class="table info">
                    <tbody>
                        <tr>
                            <td>Imię</td>
                            <td v-text="user.first_name"></td>
                        </tr>
                        <tr>
                            <td>Nazwisko</td>
                            <td v-text="user.last_name"></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td v-text="user.email"></td>
                        </tr>
                        <tr>
                            <td>Data utworzenia</td>
                            <td v-text="user.created_at"></td>
                        </tr>
                        <tr>
                            <td>Administrator</td>
                            <td v-if="user.is_admin">Tak</td>
                            <td v-else>Nie</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-6">
                <h4>Projekty do których należy użytkownik</h4>
                <table class="table">
                    <tbody>
                        <tr v-for="project in user.projects">
                            <td>
                                <router-link :to='{ name: "projects.show", params: { id: project.id } }' v-text="project.title"></router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <span v-if="error" v-text="error" class="error"></span>
    </div>
</template>

<script>
    export default {
        name: "user-component",
        props: ["seagrvice"],
        data() {
            return {
                user: {name: ""},
                error: "",
                menu: [
                    { name: "Powrót", link: { name: "admin.users" } },
                    { name: "Edytuj użytkownika", link: { name: "admin.users.edit", params: { id: this.$route.params.id } } }
                ]
            }
        },
        mounted() {
            this.init()
        },
        methods: {
            init() {
                let loader = this.$loading.show()

                this.service.getUser(this.$route.params.id).then(response => {
                    this.user = response.data
                }).catch(error => {
                    this.error = error
                }).finally(() => {
                    loader.hide()
                })
            },
        }
    }
</script>

<style scoped>
    .info tr td:first-child {
        font-weight: bold;
    }
</style>
