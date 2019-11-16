<template>
    <div class="container">
        <bar-component :title="'Lista projektów'" :menu="menu" :search="true" @searchClicked="searchClicked"></bar-component>

        <div v-if="error" v-text="error" style="color: red;"></div>

        <table-component :head="tableHead" :data="projects" :links="tableLink"></table-component>

        <pagination :data="data" @pagination-change-page="getResults"></pagination>
    </div>
</template>

<script>
    export default {
        name: "projects-list-component",
        props: ["service"],
        data() {
            return {
                data: {},
                projects: {},
                query: "",
                error: "",
                tableHead: [{id: "id", name: "#", class: "bold center w-3"}, {id: "title", name: "Projekt"}, {id: "updated_at", name: "Data modyfikacji", class: "w-20"}],
                tableLink: { name: "projects.show", params: { id: "id" } },

                menu: [{ name: "Dodaj projekt", show: false, link: { name: "projects.add" } }],
            }
        },
        mounted() {
            this.service.getUser().then(response => {
                let canCreateProject = false
                if (response.data.is_admin > 0) {
                    canCreateProject = true
                }

                this.menu = [{ name: "Dodaj projekt", show: canCreateProject, link: { name: "projects.add" } }]
            })

            this.getResults();
        },
        methods: {
            getResults(page = 1) {
                this.service.get({
                    params: {
                        page: page,
                        q: this.query
                    }
                }).then(response => {
                    this.data = response.data
                    this.projects = response.data.data
                }).catch(error => {
                    this.error = error
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
    li {
        list-style: none;
    }
</style>