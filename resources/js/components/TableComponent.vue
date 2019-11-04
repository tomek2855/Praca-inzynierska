<template>
    <div>
        <table v-if="data.length" class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th v-for="item in head" v-bind:class="item.class">{{ item.name }}</th>
                </tr>
            </thead>
            <tbody class="table-striped">
                <tr v-for="dataItem in data" @click="loadRow(dataItem)">
                    <td v-for="item in head" v-bind:class="item.class" v-text="getDataItem(dataItem, item.id)"></td>
                </tr>
            </tbody>
        </table>
        <div v-else>
            <span>Ładowanie danych</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "table-component",
        props: ["head", "data", "links"],
        methods: {
            loadRow(dataItem) {
                if (!this.links) return

                let params = {}
                Object.getOwnPropertyNames(this.links.params).forEach((i) => {
                    params[i] = dataItem[this.links.params[i]]
                })

                this.$router.push({ name: this.links.name, params: params })
            },
            getDataItem(dataItem, id) {
                return id.split('.').reduce((a, b) => a[b] ? a[b] : "", dataItem)
            }
        }
    }
</script>

<style scoped>
    span {
        color: #284257;
    }
    .bold {
        font-weight: bold;
    }
    .center {
        text-align: center;
    }
</style>