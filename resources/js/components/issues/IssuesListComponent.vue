<template>
    <div class="container">
        <bar-component :title="'Twoje zadania'" :search="true" @searchClicked="searchClicked"></bar-component>

        <div v-if="error" v-text="error" style="color: red;"></div>

        <table-component :head="tableHead" :data="issues" :links="tableLink"></table-component>

        <pagination :data="data" @pagination-change-page="getResults"></pagination>
    </div>
</template>

<script>
    export default {
        name: "issue-list-component",
        props: ["service"],
        data() {
            return {
                data: {},
                issues: {},
                query: "",
                error: "",
                tableHead: [{id: "id", name: "#", class: "bold center w-3"}, {id: "title", name: "Zadanie"}, {id: "statusText", name: "Status"}, {id: "updated_at", name: "Data modyfikacji", class: "w-20"}],
                tableLink: { name: "issues.show", params: { id: "id", projectId: "project_id" } },
            }
        },
        mounted() {
            this.getResults()
        },
        methods: {
            getResults(page = 1) {
                let loader = this.$loading.show()

                this.service.get({
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
