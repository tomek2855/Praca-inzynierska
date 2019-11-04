<template>
    <div class="container">
        <bar-component :title="issue.title" :menu="menu"></bar-component>

        <div class="row">
            <div class="col-lg-9">
                <p>{{ issue.content }}</p>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="userSelect">Przypisane do</label>
                    <select v-model="issue.assigned_user_id" @change="userChanged" id="userSelect" class="form-control">
                        <option value=""></option>
                        <option v-for="user in userList" v-bind:value="user.id">{{ user.name }}</option>
                    </select>
                </div>
            </div>
        </div>

        <span v-if="error" class="error">{{ error }}</span>

        <comments-list-component :service="commentsService" :issue="issue"></comments-list-component>
    </div>
</template>

<script>
    export default {
        name: "issue-component",
        props: ["service", "projectService", "commentsService"],
        data() {
            return {
                issue: {},
                userList: [],
                error: "",

                menu: [
                    { name: "Powrót", link: { name: "projects.issues", params: { projectId: this.$route.params.projectId } } },
                    { name: "Edytuj zadanie", link: { name: "projects.issues.edit", params: { issueId: this.$route.params.id } } }
                ]
            }
        },
        mounted() {
            let loader = this.$loading.show()

            this.service.show(this.$route.params.id).then(response => {
                this.issue = response.data
            }).catch(error => {
                this.error = error
            }).finally(() => {
                loader.hide()
            })

            this.projectService.getUserList(this.$route.params.projectId).then(response => {
                this.userList = response.data
            }).catch(error => {
                this.error = error
            }).finally(() => {
                loader.hide()
            })
        },
        methods: {
            userChanged() {
                let loader = this.$loading.show()

                this.service.save(this.issue).finally(() => {
                    loader.hide()
                })
            }
        }
    }
</script>

<style scoped>
    .error {
        color: red;
    }
</style>