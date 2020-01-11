<template>
    <div class="container">
        <bar-component :title="title + ' / Lista plików'" :menu="menu"></bar-component>

        <ul>
            <li v-for="item in files">
                {{ item.name }}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "files-list-component",
        props: ["service", "files", "title", "menu"],
        data() {
            return {
                error: ""
            }
        }
    }
</script>

<style scoped>

</style>
