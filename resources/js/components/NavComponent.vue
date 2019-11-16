<template>
    <div>
        <li v-for="e in elements" class="nav-item">
            <router-link v-if="e.show" :to="e.path" v-text="e.name" @refreshNavBar="setElements" class="nav-link"></router-link>
        </li>
    </div>
</template>

<script>
    import DataService from "../dataService";

    export default {
        name: "nav-component",
        data() {
            return {
                elements: [],
                service: {},
                user: {}
            }
        },
        mounted() {
            this.service = new DataService()

            this.setElements()

            this.$root.$on('refreshNavBar', this.setElements)
        },
        methods: {
            setElements() {
                this.service.getUser().then(res => {
                    this.user = res.data
                }).catch(error => {
                    this.user = {}
                }).finally(() => {
                    this.elements = [
                        {
                            path: { name: "home" },
                            name: "Strona główna",
                            show: true
                        },
                        {
                            path: { name: 'projects.index' },
                            name: "Projekty",
                            show: (localStorage.getItem("token"))
                        },
                        {
                            path: { name: "issues.user" },
                            name: "Twoje zadania",
                            show: (localStorage.getItem("token"))
                        },
                        {
                            path: { name: "issues.user" },
                            name: "Panel administracyjny",
                            show: this.user.is_admin > 0
                        },
                        {
                            path: {name: "logout"},
                            name: "Wyloguj się",
                            show: (localStorage.getItem("token"))
                        },
                        {
                            path: { name: "login" },
                            name: "Zaloguj się",
                            show: !(localStorage.getItem("token"))
                        }
                    ]
                })
            }
        }
    }
</script>

<style scoped>
    div {
        display: contents;
    }
</style>