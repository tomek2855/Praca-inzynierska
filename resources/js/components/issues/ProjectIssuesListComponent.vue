<template>
    <div class="container">
        <bar-component :title="'Lista zagadnień'" :menu="menu" :search="true" @searchClicked="searchClicked"></bar-component>

        <span v-if="error">{{ error }}</span>

        <table-component :head="tableHead" :data="issues" :links="tableLink"></table-component>

        <pagination :data="data" @pagination-change-page="getResults"></pagination>
    </div>
</template>

<script>
    export default {
        name: "project-issues-list-component",
        props: ["service"],
        data() {
            return {
                data: {},
                issues: [],
                error: "",
                query: "",

                tableHead: [{id: "id", name: "#", class: "bold center w-3"}, {id: "title", name: "Zadanie"}, {id: "assigned_user.name", name: "Przypisane do", class: "w-30"}, {id: "statusText", name: "Status"}, {id: "updated_at", name: "Data modyfikacji", class: "w-20"}],
                tableLink: { name: "issues.show", params: { id: "id", projectId: "project_id" } },
                menu: [
                    {name: "Dodaj zadanie", link: {name: "projects.issues.add", params: {projectId: this.$route.params.projectId}}},
                    {name: "Zadania", link: {name: "projects.issues", params: {projectId: this.$route.params.projectId}}},
                    {name: "Opis", link: {name: "projects.show", params: {id: this.$route.params.projectId}}}
                    ]
            }
        },
        mounted() {
            this.getResults()
        },
        methods: {
            searchClicked(query) {
                this.query = query
                this.getResults()
            },
            getResults(page = 1) {
                let loader = this.$loading.show()

                this.service.getProjectIssues(this.$route.params.projectId, {
                    params: {
                        page: page,
                        q: this.query
                    }
                }).then(response => {
                    this.data = response.data
                    this.issues = response.data.data
                }).catch(error => {
                    this.error = error
                }).finally(() => {
                    loader.hide()
                })
            }
        }
    }
</script>

<style scoped>
    span {
        color: red;
    }
</style>
