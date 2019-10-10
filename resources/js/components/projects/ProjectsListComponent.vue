<template>
    <div class="container">
        <h3>Lista projektów</h3>

        <div>
            <input v-model="query" @keypress="getResults" placeholder="Wyszukaj">
            <router-link :to="{ name: 'projects.add' }" class="btn btn-success">Dodaj projekt</router-link>
        </div>

        <div v-if="error" v-text="error" style="color: red;"></div>

        <ul>
            <li v-for="project in projects"><router-link :to="{ name: 'projects.show', params: { id: project.id } }">{{ project.title }}</router-link></li>
        </ul>

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
                    this.error = "Error"
                })
            }
        }
    }
</script>

<style scoped>
    li {
        list-style: none;
    }
</style>