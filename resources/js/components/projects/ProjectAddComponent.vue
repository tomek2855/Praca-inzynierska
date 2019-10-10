<template>
    <div class="container">
        <input v-model="projectName" type="text">
        <button v-on:click="addProject">Dodaj</button>
    </div>
</template>

<script>
    export default {
        name: "project-add-component",
        props: ["service"],
        data() {
            return {
                projectName: ''
            }
        },
        methods: {
            addProject() {
                this.service.save({
                    title: this.projectName
                }).then(response => {
                    this.$router.push({ name: "projects.show", params: { id: response.data.id } })
                })
            }
        }
    }
</script>

<style scoped>

</style>