<template>
    <div class="bar">
        <div class="title">{{ title }}</div>
        <div>
            <ul class="nav">
                <li v-for="item in menu" v-if="showLink(item)" class="nav-item">
                    <router-link :to="{ name: item.link.name, params: item.link.params }" class="nav-link">{{ item.name }}</router-link>
                </li>
            </ul>
        </div>
        <div>
            <input v-if="search" v-model="query" v-on:keyup.enter="searchClicked" placeholder="Wyszukaj">
            <button v-if="search" @click="searchClicked" class="btn btn-info">Szukaj</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "bar-component",
        props: ["title", "menu", "search"],
        data() {
            return {
                query: ""
            }
        },
        methods: {
            searchClicked() {
                this.$emit("searchClicked", this.query)
            },
            showLink(item) {
                if (typeof(item.show) === 'undefined')
                    return true
                else
                    return item.show
            }
        }
    }
</script>

<style scoped>
    .bar {
        display: flex;
        justify-content: space-between;
    }
    .title {
        font-size: 24px;
    }
</style>