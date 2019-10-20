<template>
    <div>
        <table v-if="data.length" class="table table-sm table-bordered table-hover">
            <thead>
                <tr>
                    <th v-for="item in head">{{ item.name }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="dataItem in data" @click="loadRow(dataItem)">
                    <td v-for="item in head">{{ dataItem[item.id] }}</td>
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
            }
        }
    }
</script>

<style scoped>
    span {
        color: #284257;
    }
</style>