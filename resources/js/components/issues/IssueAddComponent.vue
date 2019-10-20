<template>
    <div class="container">
        <bar-component :title="'Dodaj zadanie'"></bar-component>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="name">Nazwa zadania</label>
                    <input v-model="issueName" id="name" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="content">Opis zadania</label>
                    <textarea v-model="issueContent" id="content" class="form-control" cols="30" rows="10"></textarea>
                </div>
                <button v-on:click="addIssue" class="btn btn-primary">Dodaj</button>

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
                issueName: "",
                issueContent: "",
                error: ""
            }
        },
        methods: {
            addIssue() {
                this.service.addProjectIssue(this.$route.params.projectId, {
                    title: this.issueName,
                    content: this.issueContent
                }).then(response => {
                    this.$router.push({ name: "issues.show", params: { projectId: this.$route.params.projectId, id: response.data.id } })
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