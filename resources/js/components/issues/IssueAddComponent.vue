<template>
    <div class="container">
        <bar-component :title="'Dodaj zadanie'"></bar-component>

        <div class="row">
            <div class="col-lg-9">
                <div class="form-group">
                    <label for="name">Nazwa zadania</label>
                    <input v-model="issue.title" id="name" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="content">Opis zadania</label>
                    <textarea v-model="issue.content" id="content" class="form-control" rows="5"></textarea>
                </div>
                <button v-on:click="addIssue" class="btn btn-primary">Zapisz</button>
                <button v-on:click="$router.go(-1)" class="btn btn-warning">Wróć</button>
                <button v-on:click="deleteIssue" v-show="this.$route.params.id" class="btn btn-danger">Usuń zadanie</button>

                <span v-if="error">{{ error }}</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "issue-add-component",
        props: ["service"],
        data() {
            return {
                error: "",
                issue: {}
            }
        },
        mounted() {
            let loader = this.$loading.show()

            if (this.$route.params.id) {
                this.service.show(this.$route.params.id).then(response => {
                    this.issue = response.data
                }).finally(() => {
                    loader.hide()
                })
            } else {
                loader.hide()
            }
        },
        methods: {
            addIssue() {
                let loader = this.$loading.show()

                if (this.$route.params.id) {
                    this.service.save(this.issue).then(response => {
                        this.$router.push({ name: "issues.show", params: { projectId: this.$route.params.projectId, id: response.data.id } })
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
                } else {
                    this.service.addProjectIssue(this.$route.params.projectId, {
                        title: this.issue.title,
                        content: this.issue.content
                    }).then(response => {
                        this.$router.push({ name: "issues.show", params: { projectId: this.$route.params.projectId, id: response.data.id } })
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
                }
            },

            deleteIssue() {
                if (this.issue.id) {
                    this.$dialog
                        .confirm('Na pewno usunąć komentarz?', {okText: "Tak", cancelText: "Nie"})
                        .then(() => {
                            let loader = this.$loading.show()

                            this.service.delete(this.issue).finally(() => {
                                loader.hide()
                                this.$router.push({ name: "projects.issues", params: { projectId: this.$route.params.projectId } })
                            })
                        })
                }
            }
        }
    }
</script>

<style scoped>
    span {
        color: red;
    }
</style>