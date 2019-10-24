<template>
    <div class="container">
        <bar-component :title="project.title" :menu="menu"></bar-component>

        <blockquote>
            <p>{{ project.content }}</p>
        </blockquote>

        <h5>Przypisani użytkownicy</h5>
        <ul>
            <li v-for="user in project.users">{{ user.name }}</li>
        </ul>

        <select v-model="newUser" @change="addUser" class="form-control">
            <option value=""></option>
            <option v-for="user in usersToAdd" v-bind:value="user.id">{{ user.name }}</option>
        </select>

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
    span {
        color: red;
    }
</style>