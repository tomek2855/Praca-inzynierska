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
                <ul class="list-group">
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
                menu: [],
                canEditProject: false,
                canAddIssue: false
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
                        link: { name: "projects.issues.add", params: { projectId: this.project.id } },
                        show: this.canAddIssue
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
                        link: { name: "projects.edit", params: { projectId: this.project.id } },
                        show: this.canEditProject
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

                this.service.getUser().then(response => {
                    this.canEditProject = true

                    this.project.users.forEach(element => {
                        if (response.data.id == element.id) {
                            if ((element.pivot.role == "PROJECT_READER" || element.pivot.role == "PROJECT_USER") && element.is_admin == false) this.canEditProject = false
                            else this.canEditProject = true
                            return 1;
                        }
                    });

                    this.canAddIssue = true

                    this.project.users.forEach(element => {
                        if (response.data.id == element.id) {
                            if ((element.pivot.role == "PROJECT_READER") && element.is_admin == false) this.canAddIssue = false
                            else this.canAddIssue = true
                            return 1;
                        }
                    });

                    this.loadMenu()
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
