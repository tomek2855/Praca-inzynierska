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

                menu: [{ name: "Powrót", link: { name: "projects.issues", params: { projectId: this.$route.params.projectId } } }]
            }
        },
        mounted() {
            this.service.show(this.$route.params.id).then(response => {
                this.issue = response.data
            }).catch(error => {
                this.error = error
            })

            this.projectService.getUserList(this.$route.params.projectId).then(response => {
                this.userList = response.data
            }).catch(error => {
                this.error = error
            })
        },
        methods: {
            userChanged() {
                this.service.save(this.issue)
            }
        }
    }
</script>

<style scoped>
    span {
        color: red;
    }
</style>