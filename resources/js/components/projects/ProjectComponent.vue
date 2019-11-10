<template>
    <div class="container">
        <bar-component :title="project.title" :menu="menu"></bar-component>

        <div class="row">
            <div class="col-lg-9">
                <blockquote>
                    <p>{{ project.content }}</p>
                </blockquote>
            </div>
            <div class="col-lg-3">
                <h5>Uczestnicy projektu</h5>
                <ul class="list-group list-group-flush">
                    <li v-for="user in project.users" class="list-group-item">{{ user.name }}</li>
                </ul>
            </div>
        </div>

        <span v-if="error" class="error">{{ error }}</span>
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
                usersToAdd: [],
                newUser: {},
                menu: []
            }
        },
        mounted() {
            this.init()
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
                    },
                    {
                        name: "Edytuj projekt",
                        link: { name: "projects.edit", params: { projectId: this.project.id } }
                    }
                ]
            },
            init() {
                this.service.show(this.$route.params.id).then(response => {
                    this.project = response.data
                    this.loadMenu()
                }).catch(error => {
                    this.error = error
                })

                this.service.getUsersToAdd(this.$route.params.id).then(response => {
                    this.usersToAdd = response.data
                }).catch(error => {
                    this.error = error
                })
            },
            addUser() {
                this.service.addUserToProject(this.project.id, {
                    userId: this.newUser,
                    role: "PROJECT_USER"
                }).then(response => {
                    this.init()
                }).catch(error => {
                    this.error = error
                })
            }
        }
    }
</script>

<style scoped>
    .list-group-item {
        padding: 0.5rem 1rem;
    }
</style>