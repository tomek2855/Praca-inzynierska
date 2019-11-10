<template>
    <div class="container">
        <bar-component :title="'Dodaj projekt'"></bar-component>

        <div class="row">
            <div class="col-lg-9">
                <div class="form-group">
                    <label for="name">Nazwa projektu</label>
                    <input v-model="projectName" id="name" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="content">Opis projektu</label>
                    <textarea v-model="projectContent" id="content" class="form-control" rows="5"></textarea>
                </div>
                <button v-on:click="addProject" class="btn btn-primary">Zapisz</button>
                <button v-on:click="$router.go(-1)" class="btn btn-warning">Wróć</button>

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
                let loader = this.$loading.show()

                this.service.save({
                    title: this.projectName,
                    content: this.projectContent
                }).then(response => {
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
            }
        }
    }
</script>

<style scoped>
    span {
        color: red;
    }
</style>