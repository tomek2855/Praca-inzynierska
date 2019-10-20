<template>
    <div class="container">
        <bar-component :title="project.title" :menu="menu"></bar-component>

        <p>{{ project.content }}</p>

        <span v-if="error">{{ error }}</span>
    </div>
</template>

<script>
    export default {
        name: "project-component",
        props: ["service"],
        data() {
            return {
                project: {},
                error: "",
                menu: []
            }
        },
        mounted() {
            this.service.show(this.$route.params.id).then(response => {
                this.project = response.data
                this.loadMenu()
            }).catch(error => {
                this.error = error
            })
        },
        methods: {
            loadMenu() {
                this.menu = [
                    {
                        name: "Dodaj zadanie",
                        link: { name: "projects.issues.add", params: { projectId: this.project.id } }
                    },
                    {
                        name: "Zadania",
                        link: { name: "projects.issues", params: { projectId: this.project.id } }
                    },
                    {
                        name: "Opis",
                        link: { name: "projects.show", params: { id: this.project.id } }
                    }
                ]
            }
        }
    }
</script>

<style scoped>
    span {
        color: red;
    }
</style>