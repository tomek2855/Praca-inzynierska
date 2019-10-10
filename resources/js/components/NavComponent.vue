<template>
    <div>
        <li v-for="e in elements" class="nav-item">
            <router-link :to="e.path" v-text="e.name" class="nav-link"></router-link>
        </li>
    </div>
</template>

<script>
    export default {
        name: "nav-component",
        data() {
            return {
                elements: []
            }
        },
        mounted() {
            this.elements = [
                {
                    path: { name: "home" },
                    name: "Strona główna"
                },
                {
                    path: { name: 'projects.index' },
                    name: "Projekty"
                }
            ]
        }
    }
</script>

<style scoped>
    div {
        display: contents;
    }
</style>