<template>
    <div class="container">
        <bar-component :title="'Dodaj projekt'"></bar-component>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="name">Nazwa projektu</label>
                    <input v-model="projectName" id="name" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="content">Opis projektu</label>
                    <textarea v-model="projectContent" id="content" class="form-control" cols="30" rows="10"></textarea>
                </div>
                <button v-on:click="addProject" class="btn btn-primary">Dodaj</button>

                <span v-if="error">{{ error }}</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "project-add-component",
        props: ["service"],
        data() {
            return {
                projectName: "",
                projectContent: "",
                error: ""
            }
        },
        methods: {
            addProject() {
                this.service.save({
                    title: this.projectName,
                    content: this.projectContent
                }).then(response => {
                    this.$router.push({ name: "projects.show", params: { id: response.data.id } })
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