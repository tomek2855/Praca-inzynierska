<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h2>Lista plików</h2>
                <ul>
                    <li v-for="file in issue.files">
                        <a v-bind:href="fileUrl(file.id)" @click.prevent="service.downloadFile(file.id)" v-text="file.original_filename"></a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-4">
                <h2>Dodaj plik</h2>
                <div class="form-group">
                    <label for="issue-file">Wybierz plik</label>
                    <input v-on:change="handleFileUpload()" ref="issueFile" type="file" id="issue-file" class="form-control-file">
                </div>

                <span v-if="error">{{ error }}</span>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <button v-on:click="$router.go(-1)" class="btn btn-warning">Wróć</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "issue-files-component",
        props: ["service"],
        data() {
            return {
                issue: {},
                error: "",
                issueFile: null,
            }
        },
        mounted() {
            this.init()
        },
        methods: {
            init () {
                let loader = this.$loading.show()

                this.service.show(this.$route.params.issueId).then(response => {
                    this.issue = response.data
                }).catch(error => {
                    this.error = error
                }).finally(() => {
                    loader.hide()
                })
            },

            handleFileUpload() {
                let loader = this.$loading.show()

                this.issueFile = this.$refs.issueFile.files[0]

                if (this.$refs.issueFile.files.length < 1) {
                    this.error = ""
                    loader.hide()
                    return null
                }

                this.service.uploadFile(this.issue.id, this.issueFile, {isPublic: false}).then(response => {
                    this.issueFile = null
                    this.error = ""

                    this.init()
                }).catch(error => {
                    this.error = error
                }).finally(() => {
                    loader.hide()
                })
            },

            fileUrl(id) {
                return "/files/" + id
            }
        }
    }
</script>

<style scoped>
    span {
        color: red;
    }
</style>
