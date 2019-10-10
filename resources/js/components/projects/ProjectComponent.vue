<template>
    <div class="container">
        <h3>{{ project.title }}</h3>
        <div class="btn-group">
            <button v-bind:class="buttonTabClass(0)" @click="setTab(0)" class="btn">Lista zagadnień</button>
            <button v-bind:class="buttonTabClass(1)" @click="setTab(1)" class="btn">Informacje</button>
            <button v-bind:class="buttonTabClass(2)" @click="setTab(2)" class="btn">Pliki</button>
        </div>

        <div v-if="tabSelected == 0">
            <ul>
                <li v-for="issue in project.issues" v-text="issue.title"></li>
            </ul>
        </div>
        <div v-if="tabSelected == 1">
            <p v-text="project.content"></p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "project-component",
        props: ["service"],
        data() {
            return {
                project: {},
                tabSelected: 1
            }
        },
        mounted() {
            this.service.show(this.$route.params.id).then(response => {
                this.project = response.data
            })
        },
        methods: {
            buttonTabClass (i) {
                return {
                    'btn-primary': this.tabSelected == i,
                    'btn-secondary': this.tabSelected != i
                }
            },
            setTab (i) {
                this.tabSelected = i;
            }
        }
    }
</script>

<style scoped>

</style>