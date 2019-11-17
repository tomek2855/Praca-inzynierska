<template>
    <div class="container">
        <bar-component :title="'Panel administracyjny / Użytkownicy'" :menu="menu" :search="true" @searchClicked="searchClicked"></bar-component>

        <div v-if="error" v-text="error" style="color: red;"></div>

        <table-component :head="tableHead" :data="users" :links="tableLink"></table-component>

        <pagination :data="data" @pagination-change-page="getResults"></pagination>
    </div>
</template>

<script>
    export default {
        name: "users-list-component",
        props: ["service"],
        data() {
            return {
                data: {},
                users: [],
                query: "",
                error: "",
                tableHead: [{id: "id", name: "#", class: "bold center w-3"}, {id: "name", name: "Nazwa konta"}, {id: "first_name", name: "Imię"}, {id: "last_name", name: "Nazwisko"}, {id: "email", name: "E-mail"}, {id: "updated_at", name: "Data modyfikacji", class: "w-20"}],
                tableLink: { name: "admin.users.show", params: { id: "id" }},

                menu: [ { name: "Dodaj użytkownika", link: { name: "admin.users.add" } } ]
            }
        },
        mounted() {
            this.getResults()
        },
        methods: {
            getResults(page = 1) {
                let loader = this.$loading.show()

                this.service.getUsersList({
                    params: {
                        page: page,
                        q: this.query
                    }
                }).then(response => {
                    this.data = response.data
                    this.users = response.data.data
                }).catch(error => {
                    this.error = error
                }).finally(() => {
                    loader.hide()
                })
            },
            searchClicked(query) {
                this.query = query
                this.getResults()
            }
        }
    }
</script>

<style scoped>

</style>
