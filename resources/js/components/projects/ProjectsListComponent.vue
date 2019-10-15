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
                tableHead: [{id: "id", name: "#"}, {id: "title", name: "Projekt"}, {id: "updated_at", name: "Data modyfikacji"}],
                tableLink: { name: "projects.show", params: { id: "id" } },

                menu: [{ name: "Dodaj projekt", link: { name: "projects.add" } }]
                // menu: [{name: "Test", link: {name: "projects.show", params: {id: 111}}}, {name: "Test", link: {name: "project.show", params: {id: 111}}}],
            }
        },
        mounted() {
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