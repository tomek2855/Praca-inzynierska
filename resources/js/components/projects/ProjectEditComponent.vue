<template>
    <div class="container">
        <bar-component :title="'Edytuj projekt'"></bar-component>

        <div class="row">
            <div class="col-lg-9">
                <div class="form-group">
                    <label for="name">Nazwa projektu</label>
                    <input v-model="project.title" id="name" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="content">Opis projektu</label>
                    <textarea v-model="project.content" id="content" class="form-control" rows="5"></textarea>
                </div>
                <button v-on:click="editProject" class="btn btn-primary">Zapisz</button>
                <button v-on:click="$router.go(-1)" class="btn btn-warning">Wróć</button>

                <span v-if="error" class="error">{{ error }}</span>
            </div>
            <div class="col-lg-3">
                <h5>Uczestnicy projektu</h5>
                <ul class="list-group list-group-flush">
                    <li v-for="user in project.users" class="list-group-item">
                        {{ user.name }}
                        <span v-on:click="deleteUser(user)" class="btn btn-sm btn-danger float-right">Usuń</span>
                        <br>
                        <small>{{ roles.find(item => {return item.id == user.pivot.role}).name }}</small>
                    </li>
                </ul>

                <div class="form-group" style="padding-top: 20px">
                    <label for="newUserRole">Rola</label>
                    <select v-model="newUser.role" id="newUserRole" class="form-control">
                        <option v-for="role in roles" v-bind:value="role.id">{{ role.name }}</option>
                    </select>
                    <label for="newUser">Dodaj użytkownika</label>
                    <select v-model="newUser.id" id="newUser" class="form-control">
                        <option value=""></option>
                        <option v-for="user in usersToAdd" v-bind:value="user.id">{{ user.name }}</option>
                    </select>
                    <button @click="addUser" class="btn btn-success" style="margin-top: 10px">Dodaj</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "project-edit-component",
        props: ["service"],
        data() {
            return {
                project: {},
                error: "",
                usersToAdd: [],
                newUser: {},
                roles: [{id: "PROJECT_MODERATOR", name: "Moderator"}, {id: "PROJECT_USER", name: "Użytkownik"}, {id: "PROJECT_READER", name: "Czytelnik"}]
            }
        },
        mounted() {
            this.init()
        },
        methods: {
            init() {
                let loader = this.$loading.show()

                this.service.show(this.$route.params.projectId).then(response => {
                    this.project = response.data
                }).catch(error => {
                    this.error = error
                })

                this.service.getUsersToAdd(this.$route.params.projectId).then(response => {
                    this.usersToAdd = response.data
                }).catch(error => {
                    this.error = error
                }).finally(() => {
                    loader.hide()
                })
            },
            editProject() {
                let loader = this.$loading.show()

                this.service.save(this.project).then(response => {
                    this.$router.push({ name: "projects.show", params: { id: response.data.id } })
                }).catch(error => {
                    this.error = ""

                    if (error.response.data.errors.content.length > 0) {
                        error.response.data.errors.content.forEach(item => {
                            this.error += item
                        })
                    }
                    if (error.response.data.errors.title.length > 0) {
                        error.response.data.errors.title.forEach(item => {
                            this.error += item
                        })
                    }
                }).finally(() => {
                    loader.hide()
                })
            },
            addUser() {
                let loader = this.$loading.show()

                this.service.addUserToProject(this.project.id, {
                    userId: this.newUser.id,
                    role: this.newUser.role,
                }).then(response => {
                    this.init()
                    this.error = ""
                }).catch(error => {
                    this.error = ""

                    if (error.response.data.errors.role.length > 0) {
                        error.response.data.errors.role.forEach(item => {
                            this.error += item
                        })
                    }
                    if (error.response.data.errors.userId.length > 0) {
                        error.response.data.errors.userId.forEach(item => {
                            this.error += item
                        })
                    }
                }).finally(() => {
                    loader.hide()
                })
            },
            deleteUser(user) {
                this.$dialog
                    .confirm('Na pewno usunąć?', {okText: "Tak", cancelText: "Nie"})
                    .then(() => {
                        let loader = this.$loading.show()

                        this.service.deleteUserFromProject(this.project.id, {
                            data: {
                                userId: user.id
                            }
                        }).then(response => {
                            this.init()
                            this.error = ""
                        }).catch(error => {
                            this.error = error
                        }).finally(() => {
                            loader.hide()
                        })
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
